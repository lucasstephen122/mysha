<?php
	class Setting_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('Setting_model' , 'setting_model');
		}

		public function save($key , $value)
		{
			$setting = $this->ci->setting_model->get($key);
			if($setting) {
				$this->update_setting($setting['setting_id'] , ['value' => $value]);
			} else {
				$this->add_setting(['key' => $key, 'value' => $value]);
			}
		}

		public function save_setting($setting_id , $setting)
		{
			if($setting_id == "")
			{
				$setting_id = $this->add_setting($setting);
			}
			else
			{
				$this->update_setting($setting_id , $setting);
			}
			return $setting_id;
		}

		public function add_setting($setting)
		{
			$setting['created_by'] = $this->ci->user_session->get_user_id();
			$setting['updated_by'] = $this->ci->user_session->get_user_id();

			$setting_id = $this->ci->setting_model->add_setting($setting);
			return $setting_id;
		}

		public function update_setting($setting_id , $setting)
		{
			$setting['updated_by'] = $this->ci->user_session->get_user_id();

			$this->ci->setting_model->update_setting($setting_id , $setting);
			return $setting_id;
		}

		public function get_setting($setting_id)
		{
			return $this->ci->setting_model->get_setting($setting_id);
		}

		public function get_user_settings($user_id)
		{
			$settings = $this->ci->setting_model->get_user_settings($user_id);
			$settings = $this->get_settings_objects($settings);
			return $settings;
		}

		public function get_recent_settings()
		{
			$criteria = new Criteria();
			$criteria->add_criteria(Setting_search_criteria::$ARCHIVE , 'N');
			$criteria->set_sort(Setting_sort_criteria::$AUTO_ID, false);
			$criteria->set_start_index(0);
			$criteria->set_count(10);
			$settings = $this->search_settings($criteria);
			$settings = $settings['result'];
			$settings = $this->get_settings_objects($settings);
			return $settings;
		}

		public function get_setting_details($setting_id)
		{
			$setting = $this->get_setting($setting_id);
			return $setting;
		}

		public function get_setting_map($setting_ids)
		{
			$settings =  $this->ci->setting_model->get_settings($setting_ids);
			return $this->ci->util->get_map('setting_id' , $settings);
		}

		public function get_settings()
		{
			$settings =  $this->ci->setting_model->get_settings();
			$settings = $this->ci->util->get_map('key' , $settings);
			$settings_map = [];
			foreach ($settings as $setting) {
				$settings_map[$setting['key']] = $setting['value'];
			}
			return $settings_map;
		}

		public function delete_setting($setting_id)
		{
			return $this->ci->setting_model->delete_setting($setting_id);
		}

		public function search_settings($criterias)
		{
			return $this->ci->setting_model->search_settings($criterias);
		}

		public function get_settings_objects($settings)
		{
			$user_service = Factory::get_service('user_service');
			for($i = 0 ; $i < count($settings) ; $i ++) {
				$settings[$i]['actor'] = $user_service->get_user($settings[$i]['actor_id']);
				switch ($settings[$i]['type']) {
					case 'application_update': 
						$settings[$i]['message'] = "Application information is updated";
						break;
					case 'application_status_update': 
						$settings[$i]['message'] = "Application status is changed from '".ucwords($settings[$i]['old_value'])."' to '".ucwords($settings[$i]['new_value'])."'.";
						break;	
					case 'application_status_edit_update': 
						$settings[$i]['message'] = "Application edit status is changed from '".ucwords($settings[$i]['old_value'])."' to '".ucwords($settings[$i]['new_value'])."'.";
						break;		
					case 'application_comment': 
						$settings[$i]['message'] = "Comment added on application.";
						break;			
				}
			}
			return $settings;
		}
	}
