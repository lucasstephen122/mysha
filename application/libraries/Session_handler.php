<?php 

    class Session_handler implements SessionHandlerInterface
    {
        public $ttl = 1800; // 30 minutes default
        protected $db;
        protected $prefix;
     
        public function __construct(Predis\Client $db, $prefix = 'PHPSESSID:') 
        {
            $this->db = $db;
            $this->prefix = $prefix;
        }
     
        public function open($savePath, $sessionName) 
        {
            // No action necessary because connection is injected
            // in constructor and arguments are not applicable.
        }
     
        public function close() 
        {
            $this->db = null;
            unset($this->db);
        }
     
        public function read($id) 
        {
            $id = $this->prefix . $id;
            $sessData = $this->db->get($id);            
            $this->db->expire($id, $this->ttl);            
            return $sessData;
        }
     
        public function write($id, $data) 
        {
            $id = $this->prefix . $id;
            $this->db->set($id, $data);
            $this->db->expire($id, $this->ttl);
        }
     
        public function destroy($id) 
        {
            $this->db->del($this->prefix . $id);
        }
     
        public function gc($maxLifetime) 
        {
            // no action necessary because using EXPIRE
        }
    }

    /*
    class Session_handler
    {
        private $session_dir;
        function open($save_path, $session_name)
        {
            global $config;     
            $this->session_dir = $config['session_dir'].'/';
            return(true);
        }
    
        function close()
        {
            return(true);
        }
    
        function read($id)
        {
            return (string) @file_get_contents($this->session_dir.'sess_'.$id);
        }
    
        function write($id, $sess_data)
        {
            if ($fp = @fopen($this->session_dir.'sess_'.$id, "w")) 
            {
                $return = fwrite($fp, $sess_data);
                fclose($fp);
                return $return;
            } 
            else 
            {
                return(false);
            }
        }
    
        function destroy($id)
        {
            return(@unlink($this->session_dir.'sess_'.$id));
        }
    
        function gc($maxlifetime)
        {
            try 
            {
                $ci = &get_instance();
                        
                foreach (glob($this->session_dir.'sess_*') as $filename) 
                {
                    if (filemtime($filename) + $maxlifetime < time()) 
                    {
                        $name = basename($filename);
                        $session_id = str_replace("sess_", "", $name);
                    
                        $ci->user_session->destroy($session_id);
                        @unlink($filename);
                    }
                }
                return true;
            }
            catch(Exception $e)
            {
                return true;
            }
        }
    }
    $handler = new Session_handler();   
    session_set_save_handler
    (
        array($handler, 'open'),
        array($handler, 'close'),
        array($handler, 'read'),
        array($handler, 'write'),
        array($handler, 'destroy'),
        array($handler, 'gc')
    );
    register_shutdown_function('session_write_close');
    /**/