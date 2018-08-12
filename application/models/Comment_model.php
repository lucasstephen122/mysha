<?php
	class Comment_model extends SRx_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		private function encode($comment)
		{
			return $comment;
		}

		private function decode($comment , $multi = false)
		{
			if(!$multi)
			{
				return $comment;
			}
			else
			{
				for($i = 0 ; $i < count($comment) ; $i ++)
				{
					$comment[$i] = $this->decode($comment[$i] , false);
				}
				return $comment;
			}
		}

		public function add_comment($comment)
		{
			$comment['comment_id'] = uuid();
			$comment['created_on'] = now();
			$comment['updated_on'] = now();
			$comment['is_archived'] = 'N';
			$comment = $this->encode($comment);

			$this->connector->insert(Table::$comments , $comment);
			return $comment['comment_id'];
		}

		public function update_comment($comment_id , $comment)
		{
			$comment['updated_on'] = now();
			$comment = $this->encode($comment);
			return $this->connector->update(Table::$comments , $comment , array('comment_id' => $comment_id));
		}

		public function get_comment($comment_id)
		{
			$comment =  $this->connector->get(Table::$comments , array('comment_id' => $comment_id));
			$comment = $this->decode($comment);
			return $comment;
		}

		public function get_comments($comment_ids)
		{
			$comments =  $this->connector->gets(Table::$comments , array('comment_id' => $comment_ids));
			$comments = $this->decode($comments , true);
			return $comments;
		}

		public function get_user_comments($user_id, $public = "")
		{
			$data = array('user_id' => $user_id);
			if($public) {
				$data['public'] = $public;
			}
			$comments =  $this->connector->gets(Table::$comments , $data, array('auto_id'=>''));
			$comments = $this->decode($comments , true);
			return $comments;
		}

		public function get_status_comments($status)
		{
			$query = 'SELECT * FROM '.Table::$comments.' WHERE user_id IN (SELECT user_id FROM '.Table::$users.' WHERE status IN("'. implode('","' , $status) .'"))';
			$this->connector->query($query);
			$comments = $this->connector->get_rows();
			$comments = $this->decode($comments , true);
			return $comments;
		}

		public function get_role_comments($role)
		{
			$comments =  $this->connector->gets(Table::$comments , array('role' => $role));
			$comments = $this->decode($comments , true);
			return $comments;
		}

		public function get_all_comments()
		{
			$comments =  $this->connector->gets(Table::$comments , array()); 
			$comments = $this->decode($comments , true);
			return $comments;
		}

		public function delete_comment($comment_id)
		{
			$comment = array();
			$comment['updated_on'] = now();
			$comment['is_archived'] = 'Y';
			return $this->connector->update(Table::$comments , $comment , array('comment_id' => $comment_id));
		}

		public function search_comments(Criteria $criteria)
		{
			$result = array();
			$result['count'] = 0;
			$result['result'] = array();

			if($criteria->get_require_count())
			{
				$query = $this->prepare_query($criteria , false);
				$this->connector->select(Table::$comments , array() , $query);
				$result['count'] = $this->connector->num_rows();
			}

			if($criteria->get_require_result())
			{
				$query = $this->prepare_query($criteria);
				$order = $this->prepare_order($criteria);
				$limit = $this->prepare_limit($criteria);

				$this->connector->select(Table::$comments , array() , $query , $order , $limit);
				$comments = $this->connector->get_rows();
				$comments = $this->decode($comments , true);
				$result['result'] = $comments;
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
					case Comment_search_criteria::$TERM :
						$query['AND'][] = ['OR' => [
							['name' => ['operator' => 'LIKE' , 'value' => $value]]
						]];
						break;
					case Comment_search_criteria::$TYPE :
						$query['AND'][] = ['type' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Comment_search_criteria::$PROGRESS :
						$query['AND'][] = ['progress' => ['operator' => 'IS' , 'value' => $value]];
						break;	
					case Comment_search_criteria::$ARCHIVE :
						$query['AND'][] = ['is_archived' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Comment_search_criteria::$STATUS :
						$query['AND'][] = ['status' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Comment_search_criteria::$STATUS_NE :
						$query['AND'][] = ['status' => ['operator' => 'NE' , 'value' => $value]];
						break;	
					case Comment_search_criteria::$USER_ID :
						$query['AND'][] = ['comment_id' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Comment_search_criteria::$EMAIL :
						$query['AND'][] = ['email' => ['operator' => 'IS' , 'value' => $value]];
						break;
					case Comment_search_criteria::$PASSWORD :
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
				$criteria->set_sort(Comment_sort_criteria::$AUTO_ID, false);
				$sort = $criteria->get_sort();
			}

			switch($sort['column'])
			{
				case Comment_sort_criteria::$AUTO_ID :
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

	class Comment_search_criteria
	{
		public static $TERM = "term";
		public static $TYPE = "type";
		public static $ARCHIVE  = "is_archive";
		public static $STATUS = "status";
		public static $STATUS_NE = "status_ne";
		public static $USER_ID = "comment_id";
		public static $EMAIL = "email";
		public static $PASSWORD = "password";
		public static $PROGRESS = "progress";
	}

	class Comment_sort_criteria
	{
		public static $AUTO_ID = "auto_id";
	}
