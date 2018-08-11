<?php
	class User_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('User_model' , 'user_model');
		}

		public function save_user($user_id , $user)
		{
			if($user_id == "")
			{
				$user_id = $this->add_user($user);
			}
			else
			{
				$this->update_user($user_id , $user);
			}
			return $user_id;
		}

		public function add_user($user)
		{
			$user['created_by'] = $this->ci->user_session->get_user_id();
			$user['updated_by'] = $this->ci->user_session->get_user_id();

			$user_id = $this->ci->user_model->add_user($user);
			return $user_id;
		}

		public function update_user($user_id , $user)
		{
			$user['updated_by'] = $this->ci->user_session->get_user_id();

			$this->ci->user_model->update_user($user_id , $user);
			return $user_id;
		}

		public function get_user($user_id)
		{
			return $this->ci->user_model->get_user($user_id);
		}

		public function get_user_details($user_id)
		{
			$user = $this->get_user($user_id);
			return $user;
		}

		public function get_user_map($user_ids)
		{
			$users =  $this->ci->user_model->get_users($user_ids);
			return $this->ci->util->get_map('user_id' , $users);
		}

		public function delete_user($user_id)
		{
			return $this->ci->user_model->delete_user($user_id);
		}

		public function search_users($criterias)
		{
			return $this->ci->user_model->search_users($criterias);
		}

		public function get_users_objects($users)
		{
			return [];
		}

		public function authenticate($email , $password , $type = 'user')
		{
			$criteria = new Criteria();
			$criteria->add_criteria(User_search_criteria::$EMAIL , $email);
			$criteria->add_criteria(User_search_criteria::$PASSWORD , $password);
			$criteria->add_criteria(User_search_criteria::$TYPE , $type);
			$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
			$criteria->set_require_count(false);

			$search_result = $this->search_users($criteria);
			$users = $search_result['result'];
			if(count($users))
			{
				$user = $users[0];
				$this->ci->user_session->put_session($type , $user);
				return true;
			}
			else
			{
				return false;
			}
		}

		public function get_user_by_email($email)
		{
			$criteria = new Criteria();
			$criteria->add_criteria(User_search_criteria::$EMAIL , $email);
			$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
			$criteria->set_require_count(false);

			$search_result = $this->search_users($criteria);
			$users = $search_result['result'];
			if(count($users))
			{
				$user = $users[0];
				return $user;
			}
			else
			{
				return false;
			}
		}
	}
