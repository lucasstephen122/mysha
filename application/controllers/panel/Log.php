<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/panel/default');
		$this->app_library->validate_role_session('admin');		
	}

	function listing() {
		$log_service = Factory::get_service('log_service');

		$criteria = new Criteria();
		$criteria->set_require_count(false);
		$criteria->add_criteria(Log_search_criteria::$ARCHIVE , 'N');
		$search_result = $log_service->search_logs($criteria);
		$logs = $search_result['result'];
		$logs = $log_service->get_logs_objects($logs);

		$parse = [];
		$parse['logs'] = $logs;
		$this->layout->view('panel/log/listing' , $parse);
	}
}
