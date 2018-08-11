<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/panel/default');
		$this->app_library->validate_role_session('admin');
	}

	public function setting()
	{
		$setting_service = Factory::get_service('setting_service');
		$settings = $setting_service->get_settings();

		$parse = [];
		$parse['settings'] = $settings;
		$this->layout->view('panel/admin/setting' , $parse);
	}

	public function save_setting()
	{
		$setting_service = Factory::get_service('setting_service');

		$application = $this->input->get_string('application');
		$setting_service->save('application' , $application);

		set_success_message('Settings saved successfully');
		$this->redirect('panel/admin/setting');	
	}

	public function broadcast()
	{
		$this->layout->view('panel/admin/broadcast' , $parse);
	}

	public function do_broadcast() 
	{
		$emails = $this->input->get_string('emails');
		$channel = $this->input->get_string('channel');
		$status = $this->input->get_string('status');
		$progress = $this->input->get_string('progress');

		$admin_id = $this->user_session->get_admin_id();

		$notification_emails = [];
		$notification_phones = [];
		
		if($emails) {
			$emails = explode(',' , $emails);
			foreach ($emails as $email) {
				$notification_emails[] = trim($email);
			}
		}

		$user_service = Factory::get_service('user_service');
		$comment_service = Factory::get_service('comment_service');
		$notification_service = Factory::get_service('notification_service');

		$criteria = new Criteria();
		$criteria->set_require_count(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		
		if($status && $progress) {
			$criteria->add_criteria(User_search_criteria::$STATUS , $status);
			if($progress == 'completed') {
				$criteria->add_criteria(User_search_criteria::$PROGRESS , 100);
			} else if($progress == 'incomplete') {
				$criteria->add_criteria(User_search_criteria::$PROGRESS_NE , 100);
			}
		} else if($status) {
			$criteria->add_criteria(User_search_criteria::$STATUS , $status);
		} else if ($progress) {
			if($progress == 'completed') {
				$criteria->add_criteria(User_search_criteria::$PROGRESS , 100);
			} else if($progress == 'incomplete') {
				$criteria->add_criteria(User_search_criteria::$PROGRESS_NE , 100);
			}
		} 

		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$users = $search_result['result'];

		$subject = $this->input->get_string('subject');
		$message = $this->input->get_string('message');

		foreach ($users as $user) {
			if($user['email']) {
				$notification_emails[] = trim($user['email']);
			}

			if($user['phone']) {
				$notification_phones[] = trim($user['phone']);
			}

			$notification_service->add($user['user_id'] , $admin_id , $subject , $message);
		}

		
		$this->notification_library->send_template_bcc_email($notification_emails , $subject , 'broadcast' , ['message' => $message]);

		if($channel == 'phone') {
			$this->notification_library->send_sms($notification_phones , $message);
		} else if($channel == 'email') {
			$this->notification_library->send_template_bcc_email($notification_emails , $subject , 'broadcast' , ['message' => $message]);
		} else if ($channel == 'both') {
			$this->notification_library->send_sms($notification_phones , $message);
			$this->notification_library->send_template_bcc_email($notification_emails , $subject , 'broadcast' , ['message' => $message]);
		}	

		$receivers = "";
		$receivers_count = 0;
		if($channel == 'phone') {
			$receivers .= implode('<br/>' , $notification_phones);
			$receivers_count += count($notification_phones);
		} else if($channel == 'email') {
			$receivers .= implode('<br/>' , $notification_emails);
			$receivers_count += count($notification_emails);
		} else if ($channel == 'both') {
			$receivers .= implode('<br/>' , $notification_phones);
			$receivers_count += count($notification_phones);
			$receivers .= '<hr/>';
			$receivers .= implode('<br/>' , $notification_emails);
			$receivers_count += count($notification_emails);
		}

		set_success_message('Messages sent sucessfully to following (Total : '. $receivers_count .')<br/>'.$receivers);
		$this->redirect('panel/admin/broadcast');
	}

	function listing() {
		$user_service = Factory::get_service('user_service');

		$criteria = new Criteria();
		$criteria->set_require_count(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'admin');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$admins = $search_result['result'];

		$parse = [];
		$parse['admins'] = $admins;
		$this->layout->view('panel/admin/listing' , $parse);
	}

	function add() {
		$user_service = Factory::get_service('user_service');

		$parse = [];
		$this->layout->view('panel/admin/edit' , $parse);
	}

	function edit() {
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(4);

		$user = $user_service->get_user($user_id);
		
		$parse = [];
		$parse['user'] = $user;
		$parse['user_id'] = $user_id;
		$this->layout->view('panel/admin/edit' , $parse);
	}

	function save() {
		$user_service = Factory::get_service('user_service');

		$user_id = $this->input->get_string('user_id');

		$user = array();
		$user['first_name'] = $this->input->get_string('first_name');
		$user['last_name'] = $this->input->get_string('last_name');
		$user['email'] = $this->input->get_string('email');
		$user['phone'] = $this->input->get_string('phone');
		$user['city'] = $this->input->get_string('city');

		$user['type'] = 'admin';	
		$user['role'] = $this->input->get_string('role');	
		$user['progress'] = $progress > 100 ? 100 : $progress;

		if(!$user_id) {
			$user['password'] = generateRandomString(6);
		}
			
		$user_id = $user_service->save_user($user_id , $user);

		set_success_message('Admin information is saved.');
		$this->redirect('panel/admin/listing');	
	}

	function delete() {
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(4);
		$user_id = $user_service->delete_user($user_id);
		
		set_success_message('Admin deleted successfully.');
		$this->redirect('panel/admin/listing');	
	}
}
