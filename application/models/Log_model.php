<?php
	class Log_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		private function encode($log)
		{
			return $log;
		}

		private function decode($log , $multi = false)
		{
			if(!$multi)
			{
				return $log;
			}
			else
			{
				for($i = 0 ; $i < count($log) ; $i ++)
				{
					$log[$i] = $this->decode($log[$i] , false);
				}
				return $log;
			}
		}

		public function add_log($log)
		{
			$log['log_id'] = uuid();
			$log['created_on'] = now();
			$log['updated_on'] = now();
			$log['is_archived'] = 'N';
			$log = $this->encode($log);

			$this->connector->insert(Table::$logs , $log);
			return $log['log_id'];
		}

		public function update_log($log_id , $log)
		{
			$log['updated_on'] = now();
			$log = $this->encode($log);
			return $this->connector->update(Table::$logs , $log , array('log_id' => $log_id));
		}

		public function get_log($log_id)
		{
			$log =  $this->connector->get(Table::$logs , array('log_id' => $log_id));
			$log = $this->decode($log);
			return $log;
		}

		public function get_logs($log_ids)
		{
			$logs =  $this->connector->gets(Table::$logs , array('log_id' => $log_ids));
			$logs = $this->decode($logs , true);
			return $logs;
		}

		public function get_user_logs($user_id)
		{
			$logs =  $this->connector->gets(Table::$logs , array('user_id' => $user_id));
			$logs = $this->decode($logs , true);
			return $logs;
		}

		public function delete_log($log_id)
		{
			$log = array();
			$log['updated_on'] = now();
			$log['is_archived'] = 'Y';
			return $this->connector->update(Table::$logs , $log , array('log_id' => $log_id));
		}

		public function search_logs(Criteria $criteria)
		{
			$result = array();
			$result['count'] = 0;
			$result['result'] = array();

			if($criteria->get_require_count())
			{
				$query = $this->prepare_query($criteria , false);
				$this->connector->select(Table::$logs , array() , $query);
				$result['count'] = $this->connector->num_rows();
			}

			if($criteria->get_require_result())
			{
				$query = $this->prepare_query($criteria);
				$order = $this->prepare_order($criteria);
				$limit = $this->prepare_limit($criteria);

				$this->connector->select(Table::$logs , array() , $query , $order , $limit);
				$logs = $this->connector->get_rows();
				$logs = $this->decode($logs , true);
				$result['result'] = $logs;
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
					case Log_search_criteria::$TERM :
						$query['AND'][] = ['OR' => [
							['name' => ['operator' => 'LIKE' , 'value' => $value]]
						]];
						break;
					case Log_search_criteria::$TYPE :
						$query['AND'][] = ['type' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Log_search_criteria::$PROGRESS :
						$query['AND'][] = ['progress' => ['operator' => 'IS' , 'value' => $value]];
						break;	
					case Log_search_criteria::$ARCHIVE :
						$query['AND'][] = ['is_archived' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Log_search_criteria::$STATUS :
						$query['AND'][] = ['status' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Log_search_criteria::$STATUS_NE :
						$query['AND'][] = ['status' => ['operator' => 'NE' , 'value' => $value]];
						break;	
					case Log_search_criteria::$USER_ID :
						$query['AND'][] = ['log_id' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Log_search_criteria::$EMAIL :
						$query['AND'][] = ['email' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Log_search_criteria::$PASSWORD :
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
				$criteria->set_sort(Log_sort_criteria::$AUTO_ID, false);
				$sort = $criteria->get_sort();
			}

			switch($sort['column'])
			{
				case Log_sort_criteria::$AUTO_ID :
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

	class Log_search_criteria
	{
		public static $TERM = "term";
		public static $TYPE = "type";
		public static $ARCHIVE  = "is_archive";
		public static $STATUS = "status";
		public static $STATUS_NE = "status_ne";
		public static $USER_ID = "user_id";
		public static $EMAIL = "email";
		public static $PASSWORD = "password";
		public static $PROGRESS = "progress";
	}

	class Log_sort_criteria
	{
		public static $AUTO_ID = "auto_id";
	}
