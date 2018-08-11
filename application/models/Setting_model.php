<?php
	class Setting_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		private function encode($setting)
		{
			return $setting;
		}

		private function decode($setting , $multi = false)
		{
			if(!$multi)
			{
				return $setting;
			}
			else
			{
				for($i = 0 ; $i < count($setting) ; $i ++)
				{
					$setting[$i] = $this->decode($setting[$i] , false);
				}
				return $setting;
			}
		}

		public function add_setting($setting)
		{
			$setting['setting_id'] = uuid();
			$setting['created_on'] = now();
			$setting['updated_on'] = now();
			$setting['is_archived'] = 'N';
			$setting = $this->encode($setting);

			$this->connector->insert(Table::$settings , $setting);
			return $setting['setting_id'];
		}

		public function update_setting($setting_id , $setting)
		{
			$setting['updated_on'] = now();
			$setting = $this->encode($setting);
			return $this->connector->update(Table::$settings , $setting , array('setting_id' => $setting_id));
		}

		public function get_setting($setting_id)
		{
			$setting =  $this->connector->get(Table::$settings , array('setting_id' => $setting_id));
			$setting = $this->decode($setting);
			return $setting;
		}

		public function get($key)
		{
			$setting =  $this->connector->get(Table::$settings , array('key' => $key));
			$setting = $this->decode($setting);
			return $setting;
		}

		public function get_settings()
		{
			$settings =  $this->connector->gets(Table::$settings);
			$settings = $this->decode($settings , true);
			return $settings;
		}

		public function delete_setting($setting_id)
		{
			$setting = array();
			$setting['updated_on'] = now();
			$setting['is_archived'] = 'Y';
			return $this->connector->update(Table::$settings , $setting , array('setting_id' => $setting_id));
		}

		public function search_settings(Criteria $criteria)
		{
			$result = array();
			$result['count'] = 0;
			$result['result'] = array();

			if($criteria->get_require_count())
			{
				$query = $this->prepare_query($criteria , false);
				$this->connector->select(Table::$settings , array() , $query);
				$result['count'] = $this->connector->num_rows();
			}

			if($criteria->get_require_result())
			{
				$query = $this->prepare_query($criteria);
				$order = $this->prepare_order($criteria);
				$limit = $this->prepare_limit($criteria);

				$this->connector->select(Table::$settings , array() , $query , $order , $limit);
				$settings = $this->connector->get_rows();
				$settings = $this->decode($settings , true);
				$result['result'] = $settings;
			}

			return $result;
		}

		private function prepare_query(Criteria $criteria)
		{
			$criterias = $criteria->get_criterias();

			$query = array('AND' => [] , 'OR' => []);;
			foreach($criterias as $column => $value)
			{
				switch ($column)
				{
					case Setting_search_criteria::$TERM :
						$query['AND'][] = ['OR' => [
							['name' => ['operator' => 'LIKE' , 'value' => $value]]
						]];
						break;
					case Setting_search_criteria::$TYPE :
						$query['AND'][] = ['type' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Setting_search_criteria::$PROGRESS :
						$query['AND'][] = ['progress' => ['operator' => 'IS' , 'value' => $value]];
						break;	
					case Setting_search_criteria::$ARCHIVE :
						$query['AND'][] = ['is_archived' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Setting_search_criteria::$STATUS :
						$query['AND'][] = ['status' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Setting_search_criteria::$STATUS_NE :
						$query['AND'][] = ['status' => ['operator' => 'NE' , 'value' => $value]];
						break;	
					case Setting_search_criteria::$USER_ID :
						$query['AND'][] = ['setting_id' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Setting_search_criteria::$EMAIL :
						$query['AND'][] = ['email' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Setting_search_criteria::$PASSWORD :
						$query['AND'][] = ['password' => ['operator' => 'IS' , 'value' => $value]];
						break;
				}
			}

			return $query;
		}

		private function prepare_order(Criteria $criteria)
		{
			$order = array();
			$sort = $criteria->get_sort();

			if(empty($sort))
			{
				$criteria->set_sort(Setting_sort_criteria::$AUTO_ID, false);
				$sort = $criteria->get_sort();
			}

			switch($sort['column'])
			{
				case Setting_sort_criteria::$AUTO_ID :
					$order = array('auto_id' => $sort['ascending']);
					break;
			}

			return $order;
		}

		private function prepare_limit(Criteria $criteria)
		{
			$limit = array();
			if($criteria->get_start_index() != -1)
			{
				$limit = array($criteria->get_start_index() , $criteria->get_count());
			}

			return $limit;
		}
	}

	class Setting_search_criteria
	{
		public static $TERM = "term";
		public static $TYPE = "type";
		public static $ARCHIVE  = "is_archive";
		public static $STATUS = "status";
		public static $STATUS_NE = "status_ne";
		public static $USER_ID = "setting_id";
		public static $EMAIL = "email";
		public static $PASSWORD = "password";
		public static $PROGRESS = "progress";
	}

	class Setting_sort_criteria
	{
		public static $AUTO_ID = "auto_id";
	}
