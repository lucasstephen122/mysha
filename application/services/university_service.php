<?php
	class University_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('University_model' , 'university_model');
		}

		public function get_universities()
		{
			return $this->ci->university_model->get_universities();
		}
	}
