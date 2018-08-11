<?php

    class App_library
    {
        private $ci;
        public function __construct()
        {
            $this->ci = &get_instance();
        }

        public function create_session($user_id)
        {
            $user_service = Factory::get_service('user/user_service');

            $user = $user_service->get_user_details($user_id);

            $this->ci->user_session->put_user($user);
        }

        public function is_valid_session()
        {
            $user = $this->ci->user_session->get_user();
            if(empty($user))
            {
                return false;
            }
            return true;
        }

        public function validate_session()
        {
            $user = $this->ci->user_session->get_user();
            if(empty($user))
            {
                $this->ci->user_session->put_session('login_next_url' , current_full_url());
                redirect('/');
            }
        }

        public function validate_admin_session()
        {
            $user = $this->ci->user_session->get_session('admin');
            if(empty($user))
            {
                redirect('admin/signin');
            }
        }

        public function validate_role_session($role)
        {
            $user = $this->ci->user_session->get_session('admin');
            if(empty($user)) {
                redirect('panel/application');
            }
            else if($user['role'] != $role) {
                redirect('panel/application');   
            }
        }

        public function is_role_session($role)
        {
            $user = $this->ci->user_session->get_session('admin');
            if(empty($user)) {
                return false;
            }
            else if($user['role'] != $role) {
                return false;
            }
            return true;
        }
    }
