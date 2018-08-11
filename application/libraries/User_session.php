<?php
	class User_session
	{
		var $app_cache;
		public static $instance = null;

		public function __construct()
		{			
			$this->app_cache = App_cache::get_instance();
			self::$instance = $this;
		}

		public static function get_instance()
		{
			if(self::$instance)
			{
				return self::$instance;
			}
			else 
			{
				self::$instance = new User_session();
				return self::$instance;
			}
		}
		
		public function init()
		{
			$this->start();
		}
		
		public function start()
		{
		} 
		
		public function destroy($session_id = "")
		{
			if($session_id == "")
			{
				$session_id = $this->session_id();
			}

			$this->app_cache->remove_group($session_id);
			$this->remove_user();
			$this->app_cache->clear();
		} 
		
		public function session_id()
		{
			return session_id();
		}
		
		public function unlock()
		{
			// session_write_close();
		}
		
		public function put_session($key , $value)
		{
			$this->app_cache->put_session($key , $value);
		}
		
		public function get_session($key)
		{
			return $this->app_cache->get_session($key);		
		}
		
		public function remove_session($key)
		{
			$this->app_cache->remvoe_session($key);
		}
		
		public function put_user($user)
		{
			$this->put_session('user' , $user);	
		}
		
		public function get_user()
		{
			return $this->get_session('user');
		}

		public function remove_user()
		{
			return $this->remove_session('user');
		}

		public function get_user_id()
		{
			$user = $this->get_user();
			return $user['user_id'];
		}

		public function get_admin_id()
		{
			$admin = $this->get_session('admin');
			return $admin['user_id'];
		}
		
		public function get_email()
		{
			$user = $this->get_user();
			return $user['email'];
		}

		public function get_timezone()
		{
			$user = $this->get_user();
			return $user['data']['timezone'] != "" ? $user['data']['timezone'] : 'GMT';
		}

		public function get_date_format()
		{
			$user = $this->get_user();
			return $user['data']['date_format'] != "" ? $user['data']['date_format'] : 'hh:mm A, MM-DD-YYYY';
		}

		public function get_entity_type()
		{
			$user = $this->get_user();
			return $user['entity_type'];
		}

		public function get_entity_id()
		{
			$user = $this->get_user();
			return $user['entity_id'];
		}

		public function get_entity()
		{
			$user = $this->get_user();
			return $user['entity'];
		}

		public function set_user_id($user_id)
		{
			$user = $this->get_user();
			$user['user_id'] = $user_id;
			$this->put_user($user);
		}

		public function is_alive()
		{
			$user_id = $this->get_user_id();
			if($user_id != "")
			{
				return true;
			}		
			else 
			{
				return false;
			}
		}	
	}