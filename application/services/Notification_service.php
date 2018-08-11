<?php
	class Notification_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('Notification_model' , 'notification_model');
		}

		public function add($user_id , $sender_id , $subject , $message) 
		{
			$notification = array();
			$notification['user_id'] = $user_id;
			$notification['sender_id'] = $sender_id;
			$notification['subject'] = $subject;
			$notification['message'] = $message;

			$this->add_notification($notification);
		}

		public function save_notification($notification_id , $notification)
		{
			if($notification_id == "")
			{
				$notification_id = $this->add_notification($notification);
			}
			else
			{
				$this->update_notification($notification_id , $notification);
			}
			return $notification_id;
		}

		public function add_notification($notification)
		{
			$notification['created_by'] = $this->ci->user_session->get_user_id();
			$notification['updated_by'] = $this->ci->user_session->get_user_id();

			$notification_id = $this->ci->notification_model->add_notification($notification);
			return $notification_id;
		}

		public function update_notification($notification_id , $notification)
		{
			$notification['updated_by'] = $this->ci->user_session->get_user_id();

			$this->ci->notification_model->update_notification($notification_id , $notification);
			return $notification_id;
		}

		public function get_notification($notification_id)
		{
			return $this->ci->notification_model->get_notification($notification_id);
		}

		public function get_user_notifications($user_id)
		{
			$notifications = $this->ci->notification_model->get_user_notifications($user_id);
			$notifications = $this->get_notifications_objects($notifications);
			return $notifications;
		}

		public function get_pending_notifications()
		{
			$notifications = $this->ci->notification_model->get_pending_notifications();
			$notifications = $this->get_notifications_objects($notifications);
			return $notifications;
		}

		public function get_recent_notifications()
		{
			$criteria = new Criteria();
			$criteria->add_criteria(Notification_search_criteria::$ARCHIVE , 'N');
			$criteria->set_sort(Notification_sort_criteria::$AUTO_ID, false);
			$criteria->set_start_index(0);
			$criteria->set_count(10);
			$notifications = $this->search_notifications($criteria);
			$notifications = $notifications['result'];
			$notifications = $this->get_notifications_objects($notifications);
			return $notifications;
		}

		public function get_notification_details($notification_id)
		{
			$notification = $this->get_notification($notification_id);
			return $notification;
		}

		public function get_notification_map($notification_ids)
		{
			$notifications =  $this->ci->notification_model->get_notifications($notification_ids);
			return $this->ci->util->get_map('notification_id' , $notifications);
		}

		public function delete_notification($notification_id)
		{
			return $this->ci->notification_model->delete_notification($notification_id);
		}

		public function search_notifications($criterias)
		{
			return $this->ci->notification_model->search_notifications($criterias);
		}

		public function get_notifications_objects($notifications)
		{
			$user_service = Factory::get_service('user_service');
			$users = [];
			for($i = 0 ; $i < count($notifications) ; $i ++) {
				if(!$users[$notifications[$i]['sender_id']]) {
					$users[$notifications[$i]['sender_id']] = $user_service->get_user($notifications[$i]['sender_id']);
				}

				$notifications[$i]['sender'] = $users[$notifications[$i]['sender_id']];
			}
			return $notifications;
		}
	}
