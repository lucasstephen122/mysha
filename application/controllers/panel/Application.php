<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/panel/default');
		$this->app_library->validate_admin_session();		
	}

	public function index()
	{
		if(!$this->app_library->is_role_session('admin')) {
			$this->redirect('panel/application/listing/draft');
		}

		$user_service = Factory::get_service('user_service');
		$comment_service = Factory::get_service('comment_service');

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS , 'submitted');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_submitted = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS , 'approved');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_approved = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS , 'rejected');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_rejected = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$GENDER , 'Male');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_male = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$GENDER , 'Female');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_female = $search_result['count'];

		$comments = $comment_service->get_recent_comments();

		$parse = array();
		$parse['count_submitted'] = $count_submitted;
		$parse['count_approved'] = $count_approved;
		$parse['count_rejected'] = $count_rejected;
		$parse['count_male'] = $count_male;
		$parse['count_female'] = $count_female;
		$parse['comments'] = $comments;

		$this->layout->view('panel/application/index' , $parse);
	}

	public function convert() 
	{
		$user_service = Factory::get_service('user_service');

		$criteria = new Criteria();
		$criteria->set_require_count(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$users = $search_result['result'];

		foreach ($users as $user) {
			$application = $user['application'];
			$work = $application['work'];
			$bachelor_degree = $application['bachelor_degree'];
			$graduate_degree = $application['graduate_degree'];

			$user_service->update_user($user['user_id'] , [
				'work' => $work,
				'bachelor_degree' => $bachelor_degree,
				'graduate_degree' => $graduate_degree,
			]);
		}
	}

	public function insights()
	{
		$user_service = Factory::get_service('user_service');
		$comment_service = Factory::get_service('comment_service');
		$this->load->library('RandomColor');

		$criteria = new Criteria();
		$criteria->set_require_count(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$users = $search_result['result'];

		$total_age = 0;
		$total_age_count = 0;

		$total_experience = 0;
		$total_experience_count = 0;

		$count_bachelor_degree = 0;
		$count_graduate_degree = 0;
		$count_awards = 0;

		$regions_count = [];
		$regions_color = [];

		foreach ($users as $user) {
			if($user['dob']) {
				$total_age += get_age($user['dob']);
				$total_age_count += 1;
			}

			$application = $user['application'];
			if($application['work']) {
				$work = (int) filter_var($application['work'], FILTER_SANITIZE_NUMBER_INT);
				$total_work += $work;
				$total_work_count += 1;
			}

			if($application['bachelor_degree']) {
				$count_bachelor_degree += 1;
			}

			if($application['graduate_degree']) {
				$count_graduate_degree += 1;
			}

			if($application['awards']) {
				$count_awards += 1;
			}

			if($user['city']) {
				$regions_count[$user['city']] = $regions_count[$user['city']] ? $regions_count[$user['city']] : 0;
				$regions_count[$user['city']] += 1;

				$regions_color[$user['city']] = $regions_color[$user['city']] ? $regions_color[$user['city']] : RandomColor::one();
			}
		}

		$regions_iname = [];
		$regions_icount = [];
		$regions_icolor = [];
		foreach ($regions_count as $region => $count) {
			$regions_iname[] = $region;
			$regions_icount[] = $count;
			$regions_icolor[] = $regions_color[$region];
		}

		$avg_age = $total_age / $total_age_count;
		$avg_work = $total_work / $total_work_count;

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_all = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS , 'submitted');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_submitted = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS , 'approved');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_approved = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS , 'rejected');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_rejected = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$GENDER , 'Male');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_male = $search_result['count'];

		$criteria = new Criteria();
		$criteria->set_require_result(false);
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$GENDER , 'Female');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		$search_result = $user_service->search_users($criteria);
		$count_female = $search_result['count'];

		$comments = $comment_service->get_recent_comments();

		$parse = array();
		$parse['count_all'] = $count_all;
		$parse['count_submitted'] = $count_submitted;
		$parse['count_approved'] = $count_approved;
		$parse['count_rejected'] = $count_rejected;
		$parse['count_male'] = $count_male;
		$parse['count_female'] = $count_female;
		$parse['comments'] = $comments;
		$parse['avg_age'] = $avg_age;
		$parse['avg_work'] = $avg_work;
		$parse['count_bachelor_degree'] = $count_bachelor_degree;
		$parse['count_graduate_degree'] = $count_graduate_degree;
		$parse['count_awards'] = $count_awards;
		$parse['regions_count'] = $regions_count;
		$parse['regions_color'] = $regions_color;
		$parse['regions_iname'] = $regions_iname;
		$parse['regions_icount'] = $regions_icount;
		$parse['regions_icolor'] = $regions_icolor;

		$this->layout->view('panel/application/insights' , $parse);
	}

	public function listing($app_status)
	{
		$user_service = Factory::get_service('user_service');
		$filter = $this->input->get_string('filter');

		$criteria = new Criteria();
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS_NE , 'pending');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
	
		$city = $this->input->get_string('city');
		if($city)
			$criteria->add_criteria(User_search_criteria::$CITY , $city);

		$number = $this->input->get_string('number');
		if($number)
			$criteria->add_criteria(User_search_criteria::$USER_ID , $number);

		$work = $this->input->get_string('work');
		if($work)
			$criteria->add_criteria(User_search_criteria::$WORK , $work);

		$bachelor_degree = $this->input->get_string('bachelor_degree');
		if($bachelor_degree)
			$criteria->add_criteria(User_search_criteria::$GRADUATE_DEGREE , $bachelor_degree);

		if($app_status == "all"){
			$status = $this->input->get_string('status');
			if($status)
				$criteria->add_criteria(User_search_criteria::$STATUS , $status);
		}else{
			$criteria->add_criteria(User_search_criteria::$STATUS , $app_status);
		}

		$status_edit = $this->input->get_string('status_edit');
		if($status_edit)
			$criteria->add_criteria(User_search_criteria::$STATUS , $status_edit);

		// if($this->app_library->is_role_session('reviewer')) {
		// 	$criteria->add_criteria(User_search_criteria::$STATUS_IN , ['draft' , 'submitted']);
		// } else if($this->app_library->is_role_session('approver')) {
		// 	// $criteria->add_criteria(User_search_criteria::$STATUS_IN , ['reviewed' , 'approved' , 'rejected']);
		// 	$criteria->add_criteria(User_search_criteria::$STATUS_IN , ['reviewed']);
		// }

		$criteria->set_require_count(false);

		$search_result = $user_service->search_users($criteria);
		$users = $search_result['result'];

		if($this->input->get_boolean('export')) {
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename="Applications.csv";');

			$f = fopen('php://output', 'w');

			fputcsv($f, 
			[
				"First name",	
				"Middle Name",
				"Last name",
				"Birth Date",
				"Gender",
				"Email Address",
				"Phone number",
				"City of Residence",
				"Bachelors Degree",
				"Bachelor's University Name",
				"Graduate Degree",
				"Graduate University Name",
				"Number of years of work experience",
				"First Job Role Preference",
				"Second Job Role Preference",
				"Third Job Role Preference"
			]);

			foreach ($users as $user) {

				$line = [
					$user['first_name'] ? $user['first_name'] : "",
					$user['middle_name'] ? $user['middle_name'] : "",
					$user['last_name'] ? $user['last_name'] : "",
					$user['dob'] ? $user['dob'] : "",
					$user['gender'] ? $user['gender'] : "",
					$user['email'] ? $user['email'] : "",
					$user['phone'] ? $user['phone'] : "",
					$user['city'] ? $user['city'] : "",
					$user['application']['bachelor_degree'] ? $user['application']['bachelor_degree'] : "",
					$user['application']['bachelor_university'] ? $user['application']['bachelor_university'] : "",
					$user['application']['graduate_degree'] ? $user['application']['graduate_degree'] : "",
					$user['application']['graduate_university'] ? $user['application']['graduate_university'] : "",
					$user['application']['work'] ? $user['application']['work'] : "",
					$user['application']['first_preference'] ? $user['application']['first_preference'] : "",
					$user['application']['second_preference'] ? $user['application']['second_preference'] : "",
					$user['application']['third_preference'] ? $user['application']['third_preference'] : ""
				];
				fputcsv($f, $line);
			}
			exit;
		}

		$filter = [];
		$filter['city'] = $this->input->get_string('city');
		$filter['work'] = $this->input->get_string('work');
		$filter['bachelor_degree'] = $this->input->get_string('bachelor_degree');
		$filter['status'] = $this->input->get_string('status');
		$filter['number'] = $this->input->get_string('number');

		$parse = array();
		$parse['users'] = $users;
		$parse['filter'] = $filter;
		$parse["app_status"] = $app_status;
		$this->layout->view('panel/application/listing' , $parse);
	}

	public function view()
	{
		$user_service = Factory::get_service('user_service');

		$user_id = $this->uri->segment(4);

		$user = array();
		$user['read']	= 'Y';
		$user_id = $user_service->save_user($user_id , $user);

		$user = $user_service->get_user($user_id);
		
		$comment_service = Factory::get_service('comment_service');
		$comments = $comment_service->get_user_comments($user_id);

		$country_service = Factory::get_service('Country_service');
		$countries = $country_service->get_countries();

		$university_service = Factory::get_service('University_service');
		$universities = $university_service->get_universities();

		$parse = array();
		$parse['type'] = 'admin';
		$parse['user'] = $user;
		$parse['comments'] = $comments;
		$parse['countries'] = $countries;
		$parse['universities'] = $universities;
		$this->layout->view('panel/application/view' , $parse);	
	}

	public function application_read()
	{
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(3);

		$user = array();
		$user['read']	= 'Y';
		$user_id = $user_service->save_user($user_id , $user);
		
		$this->redirect('admin/applications');			
	}

	public function application_unread()
	{
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(3);

		$user = array();
		$user['read']	= 'N';
		$user_id = $user_service->save_user($user_id , $user);
		
		$this->redirect('admin/applications');			
	}

	public function application_approve()
	{
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(3);

		$user = array();
		$user['status']	= 'approved';
		$user_id = $user_service->save_user($user_id , $user);
		
		$user = $user_service->get_user($user_id);
		// $this->notification_library->send_template_emails([$user['email']] , 'Your application is approved.' , 'approved' , $user);
		
		$this->redirect('admin/applications');			
	}

	public function application_reject()
	{
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(3);

		$user = array();
		$user['status']	= 'rejected';
		$user_id = $user_service->save_user($user_id , $user);

		$user = $user_service->get_user($user_id);
		// $this->notification_library->send_template_emails([$user['email']] , 'Your application is rejected.' , 'rejected' , $user);
		
		$this->redirect('admin/applications');			
	}

	public function update()
	{
		$user_service = Factory::get_service('user_service');

		$user_id = $this->input->get_required_string('user_id');

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
		$user['graduate_degree'] = $this->input->get_string('graduate_degree');

		$user['application'] = $_REQUEST;
		if($this->input->get_string('status')) {
			$user['status'] = $this->input->get_string('status');
		}

		if($this->input->get_string('status_edit')) {
			$user['status_edit'] = $this->input->get_string('status_edit');
		}
		if($this->input->get_string("reviewer_status")){
			// $this->app_library->validate_session();
			$admin = $this->user_session->get_session('admin');
			$admin_id = $admin["user_id"];
			$current_user = $user_service->get_user($user_id);
			$reviewer_status = (array)json_decode($current_user["reviewer_status"]);
			$reviewer_status[$admin_id] = $this->input->get_string("reviewer_status");
			$user["reviewer_status"] = json_encode($reviewer_status);
			$approved_count = 0;
			$declined_count = 0;
			foreach($reviewer_status as $status){
				if($status == "approved")$approved_count += 1;
				if($status == "declined")$declined_count += 1;
			}
			if($approved_count == 2)$user["status"] = "approved";
			if($declined_count == 2)$user["status"] = "declined";
			else if($declined_count == 1 && $approved_count == 1)$user["status"] = "conflicted";
			///////////////////////////////////////////
			if($user["status"] == "conflicted"){//When Conflictt send email to the Admin
				$admins = $user_service->getAdmins();
				foreach($admins as $admin){
					$admin["comment"] = "The application for the ".$user["first_name"]." ".$user["last_name"]." was conflicted.";
					$this->notification_library->send_template_emails([$admin['email']] , 'Application Conflicted' , 'application_conflict' , $admin);
				}
			}
			////////////////////////////////////////
		}
		if($this->input->post("admin_status")){
			$admin_status = $this->input->post("admin_status");
			$reviewer_status = json_encode($admin_status);
			$user["reviewer_status"] = $reviewer_status;
			$approved_count = 0;
			$declined_count = 0;
			foreach($admin_status as $reviewer_id=>$status){
				if($status == "approved")$approved_count += 1;
				if($status == "declined")$declined_count += 1;
			}
			if($approved_count == 2)$user["status"] = "approved";
			if($declined_count == 2)$user["status"] = "declined";
			else if($declined_count == 1 && $approved_count == 1)$user["status"] = "conflicted";
		}
		$user['read'] = 'N';

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
		$log_service->save($user_id , $this->user_session->get_admin_id() , 'application_update');

		if($user_before['status'] != $user_after['status']) {
			$log_service->save($user_id , $this->user_session->get_admin_id() , 'application_status_update' , $user_before['status'] , $user_after['status']);
		}

		if($user_before['status_edit'] != $user_after['status_edit']) {
			$log_service->save($user_id , $this->user_session->get_admin_id() , 'application_status_edit_update' , $user_before['status_edit'] , $user_after['status_edit']);
		}

		set_success_message('Application information is saved.');
		$this->redirect('panel/application/view/' . $user_id);
	}

	public function export()
	{
		$user_service = Factory::get_service('user_service');

		$this->app_library->validate_admin_session();		

		$filter = $this->input->get_string('filter');

		$criteria = new Criteria();
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS_NE , 'pending');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
		
		if($filter != '')
		{
			$criteria->add_criteria(User_search_criteria::$STATUS , $filter);	
		}

		$criteria->set_require_count(false);

		$search_result = $user_service->search_users($criteria);
		$users = $search_result['result'];

		if($filter == '')
		{
			$file = 'exports_all.csv';
		}
		else
		{
			$file = 'exports_' . $filter . '.csv';
		}

		$file_url = 'data/exports/';

		$export_url = $this->config->item('data_dir') . 'exports/';
		$export_file = $export_url . $file;

		$export = fopen($export_file, 'w');

		foreach ($users as $user)
		{
			$name = $user['name'];
			$email = $user['email'];

			$fields = array();
			$fields[0] = $name;
			$fields[1] = $email;

			fputcsv($export, $fields);
		}

		fclose($export);

		$this->redirect($file_url . $file);
	}

	public function application_export()
	{
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(3);
		$user = $user_service->get_user($user_id);
		$user_application = $user['application'];
		$user_name = $user_application['first_name'] . ' ' . $user_application['last_name'];

		$file_url = 'data/exports/';

		$file = 'export_user_' . $user_name . '.csv';
		$export_url = $this->config->item('data_dir') . 'exports/';
		$export_file = $export_url . $file;

		$rows = array();
		$empty_row = array('', '');

		$rows[] = array('Personal Information:-' , '', 'head');
		$rows[] = array('Name' , $user_application['first_name'] . ' ' . $user_application['middle_name'] . ' ' . $user_application['last_name']);
		$rows[] = array('Birth Date' , $user_application['dob']);
		$rows[] = array('Gender' , $user_application['gender']);
		$rows[] = array('Email Address' , $user_application['email']);
		$rows[] = array('Phone Number' , $user_application['phone']);
		$rows[] = array('Mailing Address' , $user_application['address']);
		$rows[] = array('City of Residence' , $user_application['city']);


		$rows[] = array('Education Information:-' , '', 'head');
		$rows[] = array('Highest Acedemic Qualificatoin', $user_application['highest_qualification']);
		$rows[] = array('Bachelor\'s Degree', $user_application['bachelor_degree']);
		$rows[] = array('Bachelor\'s University Name', $user_application['bachelor_university']);
		$rows[] = array('University Location', $user_application['bachelor_university_address']);
		$rows[] = array('Period of enrollment', $user_application['bachelor_enrollment']);
		$rows[] = array('Bachelor\'s Major (& Minor)', $user_application['bachelor_major']);
		$rows[] = array('Bachelor\'s final GPA', $user_application['bachelor_gpa']);
		$rows[] = array('Undergraduate Final Year Student Ranking', $user_application['undergraduate_ranking']);
		$rows[] = $empty_row;
		$rows[] = array('Graduate Degree', $user_application['graduate_degree']);
		$rows[] = array('Graduate University Name', $user_application['graduate_university']);
		$rows[] = array('University Location', $user_application['graduate_university_address']);
		$rows[] = array('Period of enrollment', $user_application['graduate_enrollment']);
		$rows[] = array('Graduate Emphasis', $user_application['graduate_major']);
		$rows[] = array('Graduate final GPA', $user_application['graduate_gpa']);
		$rows[] = array('Graduate Final Year Student Ranking', $user_application['graduate_ranking']);
		$rows[] = $empty_row;
		$rows[] = array('High School Name', $user_application['highschool_name']);
		$rows[] = array('High School GPA', $user_application['highschool_gpa']);
		$rows[] = array('High School Final Year Ranking', $user_application['highschool_ranking']);


		$rows[] = array('Work Experience:-', '', 'head');
		$rows[] = array('Number of years of work experience', $user_application['work']);
		$rows[] = array('What is your main area of expertise?', $user_application['work_area']);
		$rows[] = $empty_row;
		$rows[] = array('Experience Details:-', '', 'subhead');

		for($i = 0; $i < 4; $i++)
		{ 
			$work_company = $user_application['work_company_' . $i];
			$work_period = $user_application['work_period_' . $i];
			$work_location = $user_application['work_location_' . $i];
			$work_responsibility = $user_application['work_responsibility_' . $i];

			if($work_company || $work_period || $work_location || $work_responsibility)
			{
				if ($i != 0)
				{
					$rows[] = $empty_row;
				}

				$rows[] = array('Name of Company/Organization', $work_company);
				$rows[] = array('Period of Employment', $work_period);
				$rows[] = array('Location', $work_location);
				$rows[] = array('Key Responsibilities', $work_responsibility);
			}
		}


		$rows[] = array('Extra - Curricular Activities:-', '', 'head');

		for($i = 0; $i < 4; $i++)
		{ 
			$extra = $user_application['extra_extra_' . $i];
			$extra_period = $user_application['extra_period_' . $i];
			$extra_location = $user_application['extra_location_' . $i];
			$extra_responsibility = $user_application['extra_responsibility_' . $i];

			if($extra || $extra_period || $extra_location || $extra_responsibility)
			{
				if ($i != 0)
				{
					$rows[] = $empty_row;
				}

				$rows[] = array('Volunteering/Extra-curricular', $extra);
				$rows[] = array('Period of Employment', $extra_period);
				$rows[] = array('Location', $extra_location);
				$rows[] = array('Key Responsibilities', $extra_responsibility);
			}
		}


		$rows[] = array('Short and long answer questions:-', '', 'head');
		$rows[] = array('What triggers your interest to apply for Shaghaf Program?', $user_application['qna_trigger']);
		$rows[] = array('What are your top priorities in life, what do you want to achieve (bucket list/dream)?', $user_application['qna_priority']);
		$rows[] = array('What do you consider your greatest achievement so far?', $user_application['qna_achievement']);
		$rows[] = array('Who is your role model? and why?', $user_application['qna_role_model']);
		$rows[] = array('What are your hobbies or talents?', $user_application['qna_hobbies']);
		$rows[] = array('What are you most passionate about?', $user_application['qna_passion']);
		$rows[] = array('How do you think you can contribute to the non-profit organizations that you would join to make a positive change in the sector?', $user_application['qna_contribute']);
		$rows[] = array('If you were given a magic wand, how would you use it to change an issue?', $user_application['qna_wand']);


		$rows[] = array('Significant awards:-', '', 'head');
		$rows[] = array('Please use this area to tell us about any significant awards or recognitions that you have received in the last 3 years (i.e., prizes, honors, other fellowships, etc.). You can say \'none\' if this does not apply.', $user_application['awards']);


		$rows[] = array('Job Role Preference:-', '', 'head');
		$rows[] = array('First Preference', $user_application['first_preference']);
		$rows[] = array('Second Preference', $user_application['second_preference']);
		$rows[] = array('Third Preference', $user_application['third_preference']);


		$rows[] = array('Contact Reference:-', '', 'head');

		for($i = 1; $i < 3; $i++)
		{
			$rows[] = array('Reference #' . $i . ':-', '', 'subhead');

			$contact_name = $user_application['contact_title_' . $i] . '. ' . $user_application['contact_name_' . $i];
			$contact_email = $user_application['contact_email_' . $i];
			$contact_phone = $user_application['contact_phone_' . $i];
			$contact_organization = $user_application['contact_organization_' . $i];
			$contact_relationship = $user_application['contact_relationship_' . $i];

			if($contact_name || $contact_email || $contact_phone || $contact_organization || $contact_relationship)
			{
				$rows[] = array('Name', $contact_name);
				$rows[] = array('Email', $contact_email);
				$rows[] = array('Phone', $contact_phone);
				$rows[] = array('Organization', $contact_organization);
				$rows[] = array('Relationship', $contact_relationship);
			}
			
		}


		$rows[] = array('Application Status:-', strtoupper($user_application['status']), 'head');

		
		/*$export = fopen($export_file, 'w');
		
		foreach ($rows as $row) 
		{
			fputcsv($export, $row);
		}
			
		fclose($export);*/

		$this->load->view('admin/export', ['application' => $rows, 'user' => $user_name]);
	}

	public function comment($from=NULL)
	{
		$user_service = Factory::get_service('user_service');
		$comment_service = Factory::get_service('comment_service');

		$user_id = $this->input->get_required_string('user_id');
		$admin = $this->user_session->get_session('admin');

		$public = $this->input->get_string('public');
		$public = $public == 'Y' ? 'Y' : 'N';

		$comment = array();
		$comment['user_id'] = $user_id;
		$comment['commenter_id'] = $admin['user_id'];
		$comment['role'] = $admin['role'];
		$comment['public'] = $public;
		$comment['comment'] = $this->input->get_required_string('comment');

		$sel_user = $user_service->get_user_by_id($user_id);
		$sel_user["comment"] = $this->input->get_required_string('comment');
		$this->notification_library->send_template_emails([$sel_user['email']] , 'The reviewer sent you new comment' , 'reviewer_comment' , $sel_user);
		$this->notification_library->send_template_sms($sel_user, 'reviewer_comment');

		$comment_id = $comment_service->save_comment($comment_id , $comment);

		$log_service = Factory::get_service('log_service');
		$log_service->save($user_id , $this->user_session->get_admin_id() , 'application_comment');

		$comments = $comment_service->get_user_comments($user_id);
		if ($from==='uc') {
			$this->redirect('panel/application/view/'.$user_id);
		}
		else {
			json_response($comments);
		}
	}

	public function sms() 
	{
		$result = $this->notification_library->send_sms([919033177887] , 'Test sms');
		if($result) {
			echo 'SMS sent';
		}
	}

	public function email() 
	{
		$result = $this->notification_library->send_email2('ehussain.in@gmail.com' , 'Some subject' , 'Some content');
	}

	public function comments()
	{	
		$comment_service = Factory::get_service('comment_service'); 

		$comments = $comment_service->get_all_comments();
		if($this->app_library->is_role_session('reviewer')) {
			$comments = $comment_service->get_role_comments('approver');
		} else if($this->app_library->is_role_session('approver')) {
			$comments = $comment_service->get_role_comments('reviewer');
		}
		

		$parse = array();
		$parse['comments'] = $comments;
		$this->layout->view('panel/application/comments' , $parse);
	}

	public function notifications()
	{	
		$user_id = $this->user_session->get_user_id();
		$notification_service = Factory::get_service('notification_service');
		$notifications = $notification_service->get_user_notifications($user_id);

		$parse = array();
		$parse['notifications'] = $notifications;
		$this->layout->view('panel/application/notifications' , $parse);
	}

	public function manage_comments($user_id)
	{
		$user_service = Factory::get_service('user_service');
		$comment_service = Factory::get_service('comment_service');
		$comments = $comment_service->get_user_comments($user_id);
		$user = $user_service->get_user($user_id);
		$this->layout->view('panel/application/manage_comments' , array('comments' => $comments, 'user_id'=>$user_id));
	}
}
