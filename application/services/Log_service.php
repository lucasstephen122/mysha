<?php
	class Log_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('Log_model' , 'log_model');
		}

		public function save($user_id , $actor_id , $type , $old_value = "" , $new_value = "" , $comment = "")
		{
			$user_service = Factory::get_service('user_service');
			$user = $user_service->get_user($user_id);
			$actor = $user_service->get_user($actor_id);

			$log = [];
			$log['application_id'] = $user['auto_id'];
			$log['user_id'] = $user_id;
			$log['actor_id'] = $actor_id;
			$log['role'] = $actor['role'];
			$log['type'] = $type;
			$log['old_value'] = $old_value;
			$log['new_value'] = $new_value;
			$log['comment'] = $comment;

			$this->add_log($log);
		}

		public function save_log($log_id , $log)
		{
			if($log_id == "")
			{
				$log_id = $this->add_log($log);
			}
			else
			{
				$this->update_log($log_id , $log);
			}
			return $log_id;
		}

		public function add_log($log)
		{
			$log['created_by'] = $this->ci->user_session->get_user_id();
			$log['updated_by'] = $this->ci->user_session->get_user_id();

			$log_id = $this->ci->log_model->add_log($log);
			return $log_id;
		}

		public function update_log($log_id , $log)
		{
			$log['updated_by'] = $this->ci->user_session->get_user_id();

			$this->ci->log_model->update_log($log_id , $log);
			return $log_id;
		}

		public function get_log($log_id)
		{
			return $this->ci->log_model->get_log($log_id);
		}

		public function get_user_logs($user_id)
		{
			$logs = $this->ci->log_model->get_user_logs($user_id);
			$logs = $this->get_logs_objects($logs);
			return $logs;
		}

		public function get_recent_logs()
		{
			$criteria = new Criteria();
			$criteria->add_criteria(Log_search_criteria::$ARCHIVE , 'N');
			$criteria->set_sort(Log_sort_criteria::$AUTO_ID, false);
			$criteria->set_start_index(0);
			$criteria->set_count(10);
			$logs = $this->search_logs($criteria);
			$logs = $logs['result'];
			$logs = $this->get_logs_objects($logs);
			return $logs;
		}

		public function get_log_details($log_id)
		{
			$log = $this->get_log($log_id);
			return $log;
		}

		public function get_log_map($log_ids)
		{
			$logs =  $this->ci->log_model->get_logs($log_ids);
			return $this->ci->util->get_map('log_id' , $logs);
		}

		public function delete_log($log_id)
		{
			return $this->ci->log_model->delete_log($log_id);
		}

		public function search_logs($criterias)
		{
			return $this->ci->log_model->search_logs($criterias);
		}

		public function get_logs_objects($logs)
		{
			$user_service = Factory::get_service('user_service');
			for($i = 0 ; $i < count($logs) ; $i ++) {
				$logs[$i]['actor'] = $user_service->get_user($logs[$i]['actor_id']);
				switch ($logs[$i]['type']) {
					case 'application_update': 
						$logs[$i]['message'] = "Application information is updated";
						break;
					case 'application_status_update': 
						$logs[$i]['message'] = "Application status is changed from '".ucwords($logs[$i]['old_value'])."' to '".ucwords($logs[$i]['new_value'])."'.";
						break;	
					case 'application_status_edit_update': 
						$logs[$i]['message'] = "Application edit status is changed from '".ucwords($logs[$i]['old_value'])."' to '".ucwords($logs[$i]['new_value'])."'.";
						break;		
					case 'application_comment': 
						$logs[$i]['message'] = "Comment added on application.";
						break;			
				}
			}
			return $logs;
		}
	}
