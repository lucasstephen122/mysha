<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/front/default');
	}

	public function index()
	{
		if($this->app_library->is_valid_session())
		{
			$this->redirect('user/application');
		}
		
		$parse = array();
		$parse['menu'] = 'index';
		
		$this->layout->view('page/index' , $parse);	
	}

	public function faq()
	{
		$parse = array();
		$parse['menu'] = 'faq';

		$this->layout->view('page/faq' , $parse);	
	}

	public function email()
	{
		$user = $this->user_session->get_user();
		$this->notification_library->send_template_emails([$user['email']] , 'Login credentials for program' , 'signup' , $user);
	}
}
