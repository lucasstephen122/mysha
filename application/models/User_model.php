<?php
	class User_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		private function encode($user)
		{
			if(isset($user['application']))
			{
				$user['application'] = json_encode($user['application']);
			}

			return $user;
		}

		private function decode($user , $multi = false)
		{
			if(!$multi)
			{
				$user['application'] = json_decode($user['application'] , true);
				$user['status_text'] = ucwords($user['status']);
				$user['name'] = $user['name'] ? $user['name'] : $user['first_name']. ' ' .$user['last_name'];

				return $user;
			}
			else
			{
				for($i = 0 ; $i < count($user) ; $i ++)
				{
					$user[$i] = $this->decode($user[$i] , false);
				}
				return $user;
			}
		}

		public function add_user($user)
		{
			$user['user_id'] = uuid();
			$user['created_on'] = now();
			$user['updated_on'] = now();
			$user['is_archived'] = 'N';
			$user = $this->encode($user);

			$this->connector->insert(Table::$users , $user);
			return $user['user_id'];
		}

		public function update_user($user_id , $user)
		{
			$user['updated_on'] = now();
			$user = $this->encode($user);
			return $this->connector->update(Table::$users , $user , array('user_id' => $user_id));
		}

		public function get_user($user_id)
		{
			$user =  $this->connector->get(Table::$users , array('user_id' => $user_id));
			$user = $this->decode($user);
			return $user;
		}

		public function get_users($user_ids)
		{
			$users =  $this->connector->gets(Table::$users , array('user_id' => $user_ids));
			$users = $this->decode($users , true);
			return $users;
		}

		public function delete_user($user_id)
		{
			$user = array();
			$user['updated_on'] = now();
			$user['is_archived'] = 'Y';
			return $this->connector->update(Table::$users , $user , array('user_id' => $user_id));
		}

		public function search_users(Criteria $criteria)
		{
			$result = array();
			$result['count'] = 0;
			$result['result'] = array();

			if($criteria->get_require_count())
			{
				$query = $this->prepare_query($criteria , false);
				$this->connector->select(Table::$users , array() , $query);
				$result['count'] = $this->connector->num_rows();
			}

			if($criteria->get_require_result())
			{
				$query = $this->prepare_query($criteria);
				$order = $this->prepare_order($criteria);
				$limit = $this->prepare_limit($criteria);

				$this->connector->select(Table::$users , array() , $query , $order , $limit);
				$users = $this->connector->get_rows();
				$users = $this->decode($users , true);
				$result['result'] = $users;
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
					case User_search_criteria::$TERM :
						$query['AND'][] = ['OR' => [
							['name' => ['operator' => 'LIKE' , 'value' => $value]]
						]];
						break;
					case User_search_criteria::$TYPE :
						$query['AND'][] = ['type' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case User_search_criteria::$PROGRESS :
						$query['AND'][] = ['progress' => ['operator' => 'IS' , 'value' => $value]];
						break;	
					case User_search_criteria::$ARCHIVE :
						$query['AND'][] = ['is_archived' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case User_search_criteria::$STATUS :
						$query['AND'][] = ['status' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case User_search_criteria::$STATUS_IN :
						$query['AND'][] = ['status' => ['operator' => 'IN' , 'value' => $value]];
						break;
					case User_search_criteria::$STATUS_NE :
						$query['AND'][] = ['status' => ['operator' => 'NE' , 'value' => $value]];
						break;	
					case User_search_criteria::$USER_ID :
						$query['AND'][] = ['user_id' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case User_search_criteria::$EMAIL :
						$query['AND'][] = ['email' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case User_search_criteria::$FIRST_NAME :
						$query['AND'][] = ['first_name' => ['operator' => 'LIKE' , 'value' => $value]];
						break;	
					case User_search_criteria::$LAST_NAME :
						$query['AND'][] = ['last_name' => ['operator' => 'LIKE' , 'value' => $value]];
						break;		
					case User_search_criteria::$GENDER :
						$query['AND'][] = ['gender' => ['operator' => 'IS' , 'value' => $value]];
						break;		
					case User_search_criteria::$CITY :
						$query['AND'][] = ['city' => ['operator' => 'LIKE' , 'value' => $value]];
						break;				
					case User_search_criteria::$REGION :
						$query['AND'][] = ['address' => ['operator' => 'LIKE' , 'value' => $value]];
						break;					
					case User_search_criteria::$WORK :
						$query['AND'][] = ['work' => ['operator' => 'LIKE' , 'value' => $value]];
						break;						
					case User_search_criteria::$BACHELOR_DEGREE :
						$query['AND'][] = ['bachelor_degree' => ['operator' => 'LIKE' , 'value' => $value]];
						break;							
					case User_search_criteria::$PROGRESS_NE :
						$query['AND'][] = ['progress' => ['operator' => 'NE' , 'value' => $value]];
						break;						
					case User_search_criteria::$PASSWORD :
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
				$criteria->set_sort(User_sort_criteria::$AUTO_ID, false);
				$sort = $criteria->get_sort();
			}

			switch($sort['column'])
			{
				case User_sort_criteria::$AUTO_ID :
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
		public function getReviewers(){
			$query = 'SELECT * FROM '.Table::$users." WHERE `type`='admin' and `role`='reviewer' ";
			$this->connector->query($query);
            $reviewers = $this->connector->get_rows();
            return $reviewers;
		}
	}

	class User_search_criteria
	{
		public static $TERM = "term";
		public static $TYPE = "type";
		public static $ARCHIVE  = "is_archive";
		public static $STATUS = "status";
		public static $STATUS_IN = "status_IN";
		public static $STATUS_NE = "status_ne";
		public static $USER_ID = "user_id";
		public static $EMAIL = "email";
		public static $PASSWORD = "password";
		public static $PROGRESS = "progress";

		public static $FIRST_NAME = "first_name";
		public static $LAST_NAME = "last_name";
		public static $GENDER = "gender";
		public static $CITY = "city";
		public static $REGION = "region";
		public static $WORK = "work";
		public static $BACHELOR_DEGREE = "bachelor_degree";
		public static $PROGRESS_NE = "progress_ne";
	}

	class User_sort_criteria
	{
		public static $AUTO_ID = "auto_id";
	}
