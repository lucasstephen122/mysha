<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SRx_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->layout->set_layout('layout/front/default');
	}

	public function index()
	{
		$this->app_library->validate_admin_session();
		$this->redirect('panel/application');
	}

	public function signin()
	{
		$this->user_session->remove_session('admin');

		$parse = array();
		$this->layout->view('admin/signin' , $parse);	
	}

	public function do_signin()
	{
		$user_service = Factory::get_service('user_service');

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$is_valid = $user_service->authenticate($email , $password , 'admin');

		if($is_valid)
		{
			$this->redirect("panel/application");
		}
		else
		{
			set_error_message('Invalid email or password');
			$this->redirect("admin/signin");
		}
	}

	public function signout()
	{
		session_unset();
		session_destroy();

		redirect("/");
	}

	public function applications()
	{
		$user_service = Factory::get_service('user_service');

		$this->app_library->validate_admin_session();		

		$filter = $this->input->get_string('filter');


		$criteria = new Criteria();
		$criteria->add_criteria(User_search_criteria::$TYPE , 'user');
		$criteria->add_criteria(User_search_criteria::$STATUS_NE , 'pending');
		$criteria->add_criteria(User_search_criteria::$ARCHIVE , 'N');
	
		if($filter == 'completed')		
		{
			$criteria->add_criteria(User_search_criteria::$PROGRESS , 100);	
		}
		else if($filter != '')
		{
			$criteria->add_criteria(User_search_criteria::$STATUS , $filter);	
		}

		$criteria->set_require_count(false);

		$search_result = $user_service->search_users($criteria);
		$users = $search_result['result'];

		$parse = array();
		$parse['users'] = $users;
		$parse['filter'] = $filter;
		$this->layout->view('admin/applications' , $parse);	
	}

	public function application()
	{
		$user_service = Factory::get_service('user_service');
		$user_id = $this->uri->segment(3);

		$user = array();
		$user['read']	= 'Y';
		$user_id = $user_service->save_user($user_id , $user);

		$user = $user_service->get_user($user_id);

		$parse = array();
		$parse['user'] = $user;
		$this->layout->view('admin/application' , $parse);	
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

	public function application_update()
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

		$user['application'] = $_REQUEST;
		$user['status'] = $this->input->get_string('status');
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

		$user_id = $user_service->save_user($user_id , $user);

		set_success_message('Your information is saved.');
		$this->redirect('admin/application/' . $user_id);
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
}
