<?php

	class Attachment_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('Attachment_model' , 'attachment_model');
		}

		public function save_attachment($module , $_file)
		{
			$attachment = array();
			$attachment['file_type'] = FileType::$ATTACHMENT;    
			$attachment['name'] = $_file['name'];
			$attachment['content_type'] = $_file['type'];
			$attachment['file_size'] = $_file['size'];
			$attachment['path'] = '';
			$attachment['encoding'] = 'UTF-8';
			$attachment['status'] = Status::$ACTIVE;
			$attachment_id = $this->add_attachment($attachment);
			
			$attachment = $this->get_attachment($attachment_id);
			$path = $this->ci->attachment_library->upload($_file['tmp_name'] , $module , $attachment);
			
			$attachment['path'] = $path;
			$this->update_attachment($attachment['attachment_id'] , $attachment);
			
			$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);

			return $attachment;
		}

		public function clone_attachment($module , $name , $source_path)
		{
			$attachment = array();
			$attachment['file_type'] = FileType::$ATTACHMENT;    
			$attachment['name'] = $name;
			$attachment['content_type'] = $this->ci->attachment_library->get_mime_type($name);
			$attachment['file_size'] = filesize($source_path.'/'.$name);
			$attachment['path'] = '';
			$attachment['encoding'] = 'UTF-8';
			$attachment['status'] = Status::$ACTIVE;
			$attachment_id = $this->add_attachment($attachment);
			
			$attachment = $this->get_attachment($attachment_id);
			$path = $this->ci->attachment_library->upload($source_path.'/'.$name , $module , $attachment);
			
			$attachment['path'] = $path;
			$this->update_attachment($attachment['attachment_id'] , $attachment);
			
			$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);

			return $attachment;
		}

		public function crop_attachment($attachment_id , $x , $y , $w , $h , $width , $height)
		{
			$attachment = $this->get_attachment($attachment_id);
			$attachment = $this->ci->attachment_library->crop_attachment($attachment , $x , $y , $w , $h , $width , $height);

			$attachment['file_size'] = filesize($this->ci->config->item('files_dir').$attachment['path'].'/file');
			$this->update_attachment($attachment_id , $attachment);

			$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);

			return $attachment;
		}

		public function save_resource($module , $name ,  $resource)
		{
			$attachment = array();
			$attachment['file_type'] = FileType::$ATTACHMENT;    
			$attachment['name'] = $name;
			$attachment['content_type'] = $this->ci->attachment_library->get_mime_type($name);
			$attachment['file_size'] = 0;
			$attachment['path'] = '';
			$attachment['encoding'] = 'UTF-8';
			$attachment['status'] = Status::$ACTIVE;
			$attachment_id = $this->add_attachment($attachment);

			$attachment = $this->get_attachment($attachment_id);
			$path = $this->ci->attachment_library->write_resource($resource , $module , $attachment);

			$attachment['path'] = $path;
			$attachment['file_size'] = filesize($this->ci->config->item('files_dir').$path.'/file');
			$this->update_attachment($attachment['attachment_id'] , $attachment);

			$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);

			return $attachment;
		}

		public function save_file($module , $name ,  $path)
		{
			$attachment = array();
			$attachment['file_type'] = FileType::$ATTACHMENT;    
			$attachment['name'] = $name;
			$attachment['content_type'] = $this->ci->attachment_library->get_mime_type($name);
			$attachment['file_size'] = 0;
			$attachment['path'] = '';
			$attachment['encoding'] = 'UTF-8';
			$attachment['status'] = Status::$ACTIVE;
			$attachment_id = $this->add_attachment($attachment);

			$attachment = $this->get_attachment($attachment_id);
			$path = $this->ci->attachment_library->upload($path , $module , $attachment);

			$attachment['path'] = $path;
			$attachment['file_size'] = filesize($this->ci->config->item('files_dir').$path.'/file');
			$this->update_attachment($attachment['attachment_id'] , $attachment);

			$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);

			return $attachment;
		}
		
		public function generate_attachment($name)
		{
			$attachment = array();
			$attachment['file_type'] = FileType::$ATTACHMENT;    
			$attachment['name'] = $name;
			$attachment['content_type'] = $this->ci->attachment_library->get_mime_type($name);
			$attachment['file_size'] = 0;
			$attachment['path'] = '';
			$attachment['encoding'] = 'UTF-8';
			$attachment['status'] = Status::$SUBMITTED;
			$attachment['attachment_id'] = $this->add_attachment($attachment);
			return $attachment;
		}


		public function populate_attachment($attachment_id , $module , $name , $path)
		{
			$attachment = $this->get_attachment($attachment_id);
			
			$attachment['name'] = $name;
			$attachment['content_type'] = $this->ci->attachment_library->get_mime_type($name);

			$path = $this->ci->attachment_library->upload($path , $module , $attachment);

			$attachment['path'] = $path;
			$attachment['file_size'] = filesize($this->ci->config->item('files_dir').$path.'/file');
			$attachment['status'] = Status::$ACTIVE;

			$this->update_attachment($attachment['attachment_id'] , $attachment);

			$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
			$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);

			return $attachment;
		}

		public function add_attachment($attachment)
		{
			$attachment['created_by'] = '';
			return $this->ci->attachment_model->add_attachment($attachment);
		}
		
		public function update_attachment($attachment_id , $attachment)
		{
			return $this->ci->attachment_model->update_attachment($attachment_id , $attachment);
		}
		
		public function get_attachment($attachment_id)
		{
			$attachment =  $this->ci->attachment_model->get_attachment($attachment_id);
			return $attachment;	
		}
		
		public function get_attachments($attachment_ids)
		{
			$attachments = $this->ci->attachment_model->get_attachments($attachment_ids);

			for ($i = 0; $i < count($attachments); $i++) 
			{ 
				$attachment = $attachments[$i];
				$attachment['download_url'] = $this->ci->attachment_library->download_url($attachment['attachment_id']);
				$attachment['render_url'] = $this->ci->attachment_library->render_url($attachment['attachment_id']);
				$attachments[$i] = $attachment;
			}

			return $this->ci->util->get_map('attachment_id' , $attachments);
		}		

		public function merge_attachments($name , $module , $attachment_ids)
		{
			$attachments = $this->get_attachments($attachment_ids);

			$paths = array();
			foreach ($attachment_ids as $attachment_id) 
			{
				$paths[] = $attachments[$attachment_id]['path'];
			}

			$pdf_service = Factory::get_service('pdf_service');
			$attachment = $pdf_service->merge_pdfs($name , $module , $paths);

			return $attachment;
		}
	}
