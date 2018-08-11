<?php
	class Attachment extends SRx_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function upload()
		{
			$attachment_service = Factory::get_service("attachment_service");

			$attachment = array();
			$attachment['file_type'] = $_REQUEST['type'];
			$attachment['name'] = $_FILES['attachment']['name'];
			$attachment['content_type'] = $_FILES['attachment']['type'];
			$attachment['file_size'] = $_FILES['attachment']['size'];
			$attachment['path'] = '';
			$attachment['encoding'] = 'UTF-8';
			$attachment_id = $attachment_service->add_attachment($attachment);

			Logger::log('file.upload' , '--------------------------');
			Logger::log('file.upload' , $_FILES);

			$attachment = $attachment_service->get_attachment($attachment_id);
			$path = $this->attachment_library->upload($_FILES['attachment']['tmp_name'] , $_REQUEST['module'] , $attachment);

			$attachment['path'] = $path;
			$attachment_service->update_attachment($attachment['attachment_id'] , $attachment);

			$attachment['download_url'] = $this->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->attachment_library->render_url($attachment['attachment_id']);

			$this->response($this->result($attachment));
		}

		public function crop()
		{
			$attachment_id = $_REQUEST['attachment_id'];

			$x = $_REQUEST['x'];
			$y = $_REQUEST['y'];

			$w = $_REQUEST['w'];
			$h = $_REQUEST['h'];

			$width = $_REQUEST['width'];
			$height = $_REQUEST['height'];

			$attachment_service = Factory::get_service("attachment_service");
			$attachment = $attachment_service->crop_attachment($attachment_id , $x , $y , $w , $h , $width , $height);

			$attachment['download_url'] = $this->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->attachment_library->render_url($attachment['attachment_id']);

			$this->response($this->result($attachment));
		}

		public function download()
		{
			$attachment_service = Factory::get_service("attachment_service");

			$attachment_id = $this->uri->segment(4);
			$attachment = $attachment_service->get_attachment($attachment_id);
			$this->attachment_library->download($attachment);
		}

		public function render()
		{
			$attachment_service = Factory::get_service("attachment_service");

			$attachment_id = $this->uri->segment(4);
			$size = $this->uri->segment(5);
			$trim = $this->uri->segment(6);
			$trim = $trim == 'false' ? false : true;

			$attachment = $attachment_service->get_attachment($attachment_id);

			if($size)
			{
				list($width , $height) = explode('x', $size);
				$this->attachment_library->render_thumb($attachment , $width , $height , $trim);
			}
			else
			{
				$this->attachment_library->render($attachment);
			}
		}

		public function clone_attachment()
		{
			$attachment_service = Factory::get_service("attachment_service");

			$module = $_POST['module'];
			$name = $_POST['name'];
			$source_path = $this->config->item('root_dir').'/'.$_POST['source_path'];

			$attachment = $attachment_service->clone_attachment($module , $name , $source_path);

			$this->response($this->result($attachment));
		}

		public function merge()
		{
			$name = $_POST['name'];
			$module = $_POST['module'];
			$attachment_ids = $_POST['attachment_ids'];

			$attachment_service = Factory::get_service("attachment_service");
			$attachment = $attachment_service->merge_attachments($name , $module , $attachment_ids);

			$this->response($this->result($attachment));
		}
	}
