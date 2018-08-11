<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/front/default');
	}

	public function signup()
	{
		$parse = array();
		
		$this->layout->view('user/signup' , $parse);	
	}

	public function do_signup()
	{
		$user_service = Factory::get_service('user_service');

		$user = array();
		$user['name'] = $this->input->get_required_string('name');
		$user['email'] = $this->input->get_required_string('email');
		$user['phone'] = $this->input->get_required_string('phone');
		$user['password'] = generateRandomString(6);
		$user['type'] = 'user';
		$user['status'] = 'pending';
		$user['read'] = 'N';

		$user_existing = $user_service->get_user_by_email($user['email']);
		if($user_existing)
		{
			set_error_message('Email address is already registered with us');
			$this->redirect("user/signup");
		}

		// $user_id = $user_service->save_user('' , $user);
		// $user = $user_service->get_user($user_id);

		$this->user_session->put_session('user' , $user);
		$this->redirect('quiz');
	}

	public function signin()
	{
		$this->user_session->remove_session('user');

		$parse = array();
		$this->layout->view('user/signin' , $parse);	
	}

	public function do_signin()
	{
		$user_service = Factory::get_service('user_service');

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$is_valid = $user_service->authenticate($email , $password);

		if($is_valid)
		{
			$this->redirect("user/welcome");
		}
		else
		{
			set_error_message('Invalid email or password');
			$this->redirect("user/signin");
		}
	}

	public function signout()
	{
		session_unset();
		session_destroy();

		redirect("/");
	}

	public function forgot_password()
	{
		$this->user_session->remove_session('user');

		$parse = array();
		$this->layout->view('user/forgot_password' , $parse);	
	}

	public function do_forgot_password()
	{
		$user_service = Factory::get_service('user_service');

		$email = $this->input->post('email');
		$user = $user_service->get_user_by_email($email);

		if($user)
		{
			$this->notification_library->send_template_emails([$user['email']] , 'Login credentials for program' , 'signup' , $user);	
			$this->redirect("user/signin");
		}
		else
		{
			set_error_message('Email address is not registered');
			$this->redirect("user/forgot_password");
		}
	}

	public function failed()
	{
		$parse = array();
		
		$this->layout->view('user/failed' , $parse);	
	}

	public function success()
	{
		$user_service = Factory::get_service('user_service');
		
		$this->app_library->validate_session();
		$user = $this->user_session->get_user();
		$user_id = $user_service->save_user('' , $user);
		// $user = $user_service->get_user($user_id);
		// $user_id = $user['user_id'];

		$user = array();
		$user['status'] = 'draft';
		$user['status_edit'] = 'open';

		$user_id = $user_service->save_user($user_id , $user);
		$user = $user_service->get_user($user_id);
		$this->user_session->put_session('user' , $user);

		$this->notification_library->send_template_emails([$user['email']] , 'Login credentials for program' , 'signup' , $user);
		$this->notification_library->send_template_sms($user, 'signup');

		$this->layout->view('user/success');
	}

	public function application()
	{
		$user_service = Factory::get_service('user_service');
		
		$this->app_library->validate_session();	
		$user = $this->user_session->get_user();
		$user_id = $user['user_id'];		
		$user = $user_service->get_user($user_id);

		if($user['status'] == 'pending')
		{
			session_unset();
			session_destroy();
			$this->redirect('/');
		}

		$setting_service = Factory::get_service('setting_service');
		$settings = $setting_service->get_settings();

		$comment_service = Factory::get_service('comment_service');
		$comments = $comment_service->get_user_comments($user_id , 'Y');

		$country_service = Factory::get_service('country_service');
		$countries = $country_service->get_countries();

		$university_service = Factory::get_service('university_service');
		$universities = $university_service->get_universities();
		
		$parse = array();
		$parse['type'] = 'user';
		$parse['user'] = $user;
		$parse['comments'] = $comments;
		$parse['settings'] = $settings;
		$parse['countries'] = $countries;
		$parse['universities'] = $universities;
		
		$this->layout->set_layout('layout/user/default');
		$this->layout->view('panel/application/view' , $parse);	
	}

	public function welcome()
	{
		$user = $this->user_session->get_user();
		$this->layout->set_layout('layout/user/default');
		$this->layout->view('user/welcome', array('user'=>$user));
	}

	public function update()
	{
		$user_service = Factory::get_service('user_service');

		$user = $this->user_session->get_user();
		$user_id = $user['user_id'];		

		$user_existing = $user_service->get_user($user_id);
		if($user_existing['status_edit'] == 'closed') {
			set_error_message('Your you are not allowed to modify information.');	
			$this->redirect('user/application');
			return;
		}

		$setting_service = Factory::get_service('setting_service');
		$settings = $setting_service->get_settings();
		if($settings['application'] == 0) {
			set_error_message('Application submission is currently disabled');	
			$this->redirect('user/application');
			return;
		}

		$user = array();
		$user['first_name'] = $this->input->get_string('first_name');
		$user['middle_name'] = $this->input->get_string('middle_name');
		$user['last_name'] = $this->input->get_string('last_name');
		$user['dob'] = $this->input->get_string('dob');
		$user['gender'] = $this->input->get_string('gender');
		$user['email'] = $this->input->get_string('email');
		$user['phone'] = $this->input->get_string('phone');
		$user['address'] = $this->input->get_string('address');
		$user['city'] = $this->input->get_string('city');

		$user['work'] = $this->input->get_string('work');	
		$user['bachelor_degree'] = $this->input->get_string('bachelor_degree');

		$user['application'] = $_REQUEST;

		$user['read'] = 'N';
		if(isset($_REQUEST['draft'])) {
			$user['status'] = 'draft';
		} else if(isset($_REQUEST['submitted'])) {
			$user['status'] = 'submitted';
		}

		if($user['status'] == 'draft') {
			$user['status_edit'] = 'open';
		} else {
			$user['status_edit'] = 'closed';
		}

		$required_fields = $_REQUEST['required_fields'] ? explode(',' , $_REQUEST['required_fields']) : array();

		$total_fields = 0;
		$filled_fields = 0;

		foreach ($required_fields as $require_field) 
		{
			$total_fields ++;
			if($user['application'][$require_field])
			{
				$filled_fields ++;
			}
		}

		$progress = (int)($filled_fields / $total_fields * 100);
		$user['progress'] = $progress > 100 ? 100 : $progress;

		$user_before = $user_service->get_user($user_id);
		$user_id = $user_service->save_user($user_id , $user);
		$user_after = $user_service->get_user($user_id);

		$log_service = Factory::get_service('log_service');
		$log_service->save($user_id , $this->user_session->get_user_id() , 'application_update');

		if($user_before['status'] != $user_after['status']) {
			$log_service->save($user_id , $this->user_session->get_user_id() , 'application_status_update' , $user_before['status'] , $user_after['status']);
		}

		if($user_before['status_edit'] != $user_after['status_edit']) {
			$log_service->save($user_id , $this->user_session->get_user_id() , 'application_status_edit_update' , $user_before['status_edit'] , $user_after['status_edit']);
		}

		set_success_message('Your information is saved.');	
		$this->redirect('user/application');
	}

	public function submitted()
	{
		$user_service = Factory::get_service('user_service');

		$this->app_library->validate_session();	
		$user = $this->user_session->get_user();
		$user_id = $user['user_id'];		
		$user = $user_service->get_user($user_id);

		$parse = array();
		$parse['user'] = $user;
		
		$this->layout->view('user/submitted' , $parse);	
	}

	public function comment($from=NULL)
	{
		$user_service = Factory::get_service('user_service');
		$comment_service = Factory::get_service('comment_service');

		$user_id = $this->user_session->get_user_id();
		$user = $this->user_session->get_user();

		$comment = array();
		$comment['user_id'] = $this->user_session->get_user_id();
		$comment['commenter_id'] = $this->user_session->get_user_id();
		$comment['comment'] = $this->input->get_required_string('comment');
		$comment['public'] = 'Y';

		$comment_id = $comment_service->save_comment($comment_id , $comment);
		
		$reviewers = $user_service->getReviewers();
		foreach($reviewers as $reviewer){
			$this->notification_library->send_template_emails([$reviewer['email']] , 'User sent comment' , 'user_comment' , $reviewer);
		}

		$log_service = Factory::get_service('log_service');
		$log_service->save($user_id , $this->user_session->get_user_id() , 'application_comment');

		$comments = $comment_service->get_user_comments($user_id);
		
		if ($from==='uc') {
			$this->redirect('user/comments');
		}
		else {
			json_response($comments);
		}
	}

	public function notifications()
	{	
		$user_id = $this->user_session->get_user_id();
		$notification_service = Factory::get_service('notification_service');
		$notifications = $notification_service->get_user_notifications($user_id);

		$parse = array();
		$parse['notifications'] = $notifications;
		$this->layout->set_layout('layout/user/default');
		$this->layout->view('panel/application/notifications' , $parse);
	}

	public function comments()
	{
		$user_id = $this->user_session->get_user_id();
		if (!$user_id) {
			echo 'No user data in session'; exit;
		}
		$comment_service = Factory::get_service('comment_service');
		$comments = $comment_service->get_user_comments($user_id);
		$this->layout->set_layout('layout/user/default');
		$this->layout->view('user/comments' , array('comments' => $comments));
	}
}
