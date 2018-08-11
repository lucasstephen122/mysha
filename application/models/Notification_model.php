<?php
	class Notification_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		private function encode($notification)
		{
			return $notification;
		}

		private function decode($notification , $multi = false)
		{
			if(!$multi)
			{
				return $notification;
			}
			else
			{
				for($i = 0 ; $i < count($notification) ; $i ++)
				{
					$notification[$i] = $this->decode($notification[$i] , false);
				}
				return $notification;
			}
		}

		public function add_notification($notification)
		{
			$notification['notification_id'] = uuid();
			$notification['created_on'] = now();
			$notification['updated_on'] = now();
			$notification['is_archived'] = 'N';
			$notification = $this->encode($notification);

			$this->connector->insert(Table::$notifications , $notification);
			return $notification['notification_id'];
		}

		public function update_notification($notification_id , $notification)
		{
			$notification['updated_on'] = now();
			$notification = $this->encode($notification);
			return $this->connector->update(Table::$notifications , $notification , array('notification_id' => $notification_id));
		}

		public function get_notification($notification_id)
		{
			$notification =  $this->connector->get(Table::$notifications , array('notification_id' => $notification_id));
			$notification = $this->decode($notification);
			return $notification;
		}

		public function get_notifications($notification_ids)
		{
			$notifications =  $this->connector->gets(Table::$notifications , array('notification_id' => $notification_ids));
			$notifications = $this->decode($notifications , true);
			return $notifications;
		}

		public function get_user_notifications($user_id)
		{
			$notifications =  $this->connector->gets(Table::$notifications , array('user_id' => $user_id));
			$notifications = $this->decode($notifications , true);
			return $notifications;
		}

		public function get_pending_notifications()
		{
			$query = 'SELECT * FROM '.Table::$notifications.' WHERE user_id IN (SELECT user_id FROM '.Table::$users.' WHERE status IN("draft" , "submitted" , "reviewed"))';
			$this->connector->query($query);
			$notifications = $this->connector->get_rows();
			$notifications = $this->decode($notifications , true);
			return $notifications;
		}

		public function delete_notification($notification_id)
		{
			$notification = array();
			$notification['updated_on'] = now();
			$notification['is_archived'] = 'Y';
			return $this->connector->update(Table::$notifications , $notification , array('notification_id' => $notification_id));
		}

		public function search_notifications(Criteria $criteria)
		{
			$result = array();
			$result['count'] = 0;
			$result['result'] = array();

			if($criteria->get_require_count())
			{
				$query = $this->prepare_query($criteria , false);
				$this->connector->select(Table::$notifications , array() , $query);
				$result['count'] = $this->connector->num_rows();
			}

			if($criteria->get_require_result())
			{
				$query = $this->prepare_query($criteria);
				$order = $this->prepare_order($criteria);
				$limit = $this->prepare_limit($criteria);

				$this->connector->select(Table::$notifications , array() , $query , $order , $limit);
				$notifications = $this->connector->get_rows();
				$notifications = $this->decode($notifications , true);
				$result['result'] = $notifications;
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
					case Notification_search_criteria::$TERM :
						$query['AND'][] = ['OR' => [
							['name' => ['operator' => 'LIKE' , 'value' => $value]]
						]];
						break;
					case Notification_search_criteria::$TYPE :
						$query['AND'][] = ['type' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Notification_search_criteria::$PROGRESS :
						$query['AND'][] = ['progress' => ['operator' => 'IS' , 'value' => $value]];
						break;	
					case Notification_search_criteria::$ARCHIVE :
						$query['AND'][] = ['is_archived' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Notification_search_criteria::$STATUS :
						$query['AND'][] = ['status' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Notification_search_criteria::$STATUS_NE :
						$query['AND'][] = ['status' => ['operator' => 'NE' , 'value' => $value]];
						break;	
					case Notification_search_criteria::$USER_ID :
						$query['AND'][] = ['notification_id' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Notification_search_criteria::$EMAIL :
						$query['AND'][] = ['email' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Notification_search_criteria::$PASSWORD :
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
				$criteria->set_sort(Notification_sort_criteria::$AUTO_ID, false);
				$sort = $criteria->get_sort();
			}

			switch($sort['column'])
			{
				case Notification_sort_criteria::$AUTO_ID :
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

	class Notification_search_criteria
	{
		public static $TERM = "term";
		public static $TYPE = "type";
		public static $ARCHIVE  = "is_archive";
		public static $STATUS = "status";
		public static $STATUS_NE = "status_ne";
		public static $USER_ID = "notification_id";
		public static $EMAIL = "email";
		public static $PASSWORD = "password";
		public static $PROGRESS = "progress";
	}

	class Notification_sort_criteria
	{
		public static $AUTO_ID = "auto_id";
	}
