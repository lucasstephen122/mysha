<?php    

    class App_cache 
    {
        public static $instance = null;
        private $ci;

        public function __construct()
        {
            $this->ci = &get_instance();            
            // ini_set('session.save_path' , $this->ci->config->item('data_dir').'sessions/');            
            self::$instance = $this;
        }

        public function init()
        {
            if (php_sapi_name() != "cli") 
            {
                Logger::log('session' , '--------------------------------------------');
                $this->sweep_flash();
                $this->mark_flash();
                Logger::log('session' , 'Start : '.php_sapi_name().' : '.session_id());
                Logger::log('session' , 'URL : '.get_request_url());
            }
        }

        public static function get_instance()
        {
            if(self::$instance)
            {
                return self::$instance;
            }
            else 
            {
                self::$instance = new App_cache();
                return self::$instance;
            }
        }
        
        public function put($key , $value)
        {
            $_SESSION[$key] = $value;
        }
        
        public function get($key)
        {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
        }
        
        public function remove($key)
        {
            unset($_SESSION[$key]);
            // $this->ci->cache->delete($key);
        }

        public function put_session($key , $value)
        {
            $this->put($key , $value);
        }

        public function get_session($key)
        {
            return $this->get($key);
        }

        public function remvoe_session($key)
        {
            return $this->remove($key);
        }
        
        public function clear()
        {
            Logger::log('session' , 'End : '.php_sapi_name().' : '.session_id());
            session_destroy();      
            return;      
            unlink($this->ci->config->item('data_dir').'sessions/sess_'.session_id());
            Logger::log('session' , 'Content : ');
            Logger::log('session' , file_get_contents($this->ci->config->item('data_dir').'sessions/sess_'.session_id()));
            Logger::log('session' , '--------------------------------------------');

            // return $this->ci->cache->clear();
        }
        
        public function put_scope($scope , $key , $value)
        {
            $this->put($scope .':'. $key, $value);
        }
        
        public function get_scope($scope , $key)
        {
        	return $this->get($scope .':'. $key);
        }
    	
        public function remove_scope($scope , $key)
        {
            $this->remove($scope .':'. $key);
        }
        
        public function put_group($group , $key , $value)
        {
        	$keys = $this->get('_GRP_'.$group);
        	if($keys == null)
        		$keys = array();
        	$keys[$key] = "";
        	$this->put('_GRP_'.$group, $keys);
        	
        	$this->put_scope($group, $key, $value);
        }
        
        public function get_group($group , $key)
        {
        	return $this->get_scope($group, $key);
        }
        
        public function remove_group($group , $key = null)
        {
        	if($key == null)
        	{
        		$keys = $this->get('_GRP_'.$group);
                $keys = is_array($keys) ? $keys : array();
        		foreach($keys as $key => $value)
        		{
        			$this->remove_scope($group, $key);
        		}
        		$this->remove('_GRP_'.$group);
        	}
        	else
        	{
        		$keys = $this->get('_GRP_'.$group);
        		unset($keys[$key]);
        		
        		if(empty($keys))
        			$this->remove('_GRP_'.$group);
        		else 
        			$this->put('_GRP_'.$group , $keys);

        		$this->remove_scope($group, $key);	
        	}
        }
        
        public function put_flash($key , $value)
        {
        	$keys = $this->get('_FLASH_NEW_');
        	if($keys == null)
        		$keys = array();
        	$keys[$key]	= "";
        	$this->put('_FLASH_NEW_' , $keys);
        	
        	$this->put_scope('_FLASH_' , $key , $value);
        }
        
        public function get_flash($key)
        {
        	return $this->get_scope('_FLASH_', $key);
        }

        public function sweep_flash()
        {
        	$keys = $this->get('_FLASH_OLD_');
        	
        	if($keys != null)
        	{
	        	foreach($keys as $key => $value)
	        	{
	        		$this->remove_scope('_FLASH_', $key);
	        	}
        	}
        	$this->remove('_FLASH_OLD_');
        }
        
        public function mark_flash()
        {

        	$keys = $this->get('_FLASH_NEW_');
        	$this->put('_FLASH_OLD_' , $keys);
        	$this->remove('_FLASH_NEW_');
        }
        
        public function keep_flash($key)
        {
        	$oldKeys = $this->get('_FLASH_OLD_');
        	unset($oldKeys[$key]);
        	$this->put('_FLASH_OLD_');
        	
        	$newKeys = $this->get('_FLASH_NEW_');
        	if($newKeys == null)
        		$newKeys = array();
        	$newKeys[$key] = "";
        	$this->put('_FLASH_NEW_' , $newKeys);	
        }
    }