<?php
	class Country_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('Country_model' , 'country_model');
		}

		public function get_countries()
		{
			return $this->ci->country_model->get_countries();
		}
	}
