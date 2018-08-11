<?php
	class University_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
        public function get_universities(){
            $query = 'SELECT * FROM '.Table::$universities;
			$this->connector->query($query);
            $countries = $this->connector->get_rows();
            return $countries;
        }
		
	}
