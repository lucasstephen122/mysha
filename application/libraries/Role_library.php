<?php

    class Role_library
    {
        private $ci;
        private $user;
        private $roles;
        private $activities;

        public function __construct()
        {
            $this->ci = &get_instance();
            $this->user = $this->ci->user_session->get_user();
            $this->roles = $this->user['roles'];
            $this->activities = $this->user['activities'];
        }

        public function setup()
        {
            $this->user = $this->ci->user_session->get_user();
            $this->activities = $this->user['activities'];
        }
        
        public function has_activity($activity)
        {
            return in_array($activity , $this->activities);
        }

        public function has_role($role_id)
        {
            return in_array($role_id , $this->roles);
        }

        public function has_any_activity($activities)
        {
        	foreach ($activities as $activity) 
        	{
        		if(in_array($activity , $this->activities))
        		{
        			return true;
        		}
        	}

        	return false;
        }

        public function has_all_activity($activities)
    	{
			foreach ($activities as $activity) 
			{
				if(!in_array($activity , $this->activities))
				{
					return false;
				}	
			}

			return true;
    	}

    	public function validate_activity($activity)
    	{
    		if(!$this->has_activity($activity))
    		{
    			$this->block_activity();
    		}
    	}

    	public function validate_any_activity($activities)
    	{
    		if(!$this->has_any_activity($activities))
    		{
    			$this->block_activity();
    		}
    	}

    	public function validate_all_activity($activities)
    	{
    		if(!$this->has_all_activity($activities))
    		{
    			$this->block_activity();
    		}
    	}

        public function block_activity()
        {
            set_error_message('You are not allowed to perform this action. Please contact administrator.');
            redirect(base_url());
        }
    }
