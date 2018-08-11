<?php

	class Attachment_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		private function encode($attachment)
		{
			return $attachment;
		}

		private function decode($attachment , $multi = false)
		{
			if(!$multi)
			{
				return $attachment;
			}
			else 
			{
				for($i = 0 ; $i < count($attachment) ; $i ++)
				{
					$attachment[$i] = $this->decode($attachment[$i] , false);
				}
				return $attachment;
			}
		}
		
		public function add_attachment($attachment)
		{
			$attachment['attachment_id'] = uuid();
			$attachment['created_on'] = now();
			$attachment = $this->encode($attachment);

			$this->connector->insert(Table::$attachments, $attachment);
			
			return $attachment['attachment_id'];
		}
		
		public function update_attachment($attachment_id , $attachment)
		{
			$attachment = $this->encode($attachment);
			return $this->connector->update(Table::$attachments, $attachment, array('attachment_id' => $attachment_id));
		}				
		
		public function get_attachment($attachment_id)
		{
			$attachment = $this->connector->get(Table::$attachments, array('attachment_id' => $attachment_id));		
			$attachment = $this->decode($attachment);
			return $attachment;
		}
		
		public function get_attachments($attachment_ids)
		{
			$attachments = $this->connector->gets(Table::$attachments, array('attachment_id' => $attachment_ids));
			$attachments = $this->decode($attachments , true);
			return $attachments;
		}
	}