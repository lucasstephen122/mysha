<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/front/default');		
		$this->app_library->validate_session();
	}

	public function index()
	{
		$parse = array();	
		$this->layout->view('quiz/index' , $parse);	
	}
}