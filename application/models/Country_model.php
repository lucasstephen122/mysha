<?php
	class Country_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
        public function get_countries(){
            $query = 'SELECT * FROM '.Table::$countries;
			$this->connector->query($query);
            $countries = $this->connector->get_rows();
            return $countries;
        }
		
	}
