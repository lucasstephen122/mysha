<?php
    use Aws\S3\S3Client;

    class App_initializer extends CI_Hooks
    {
        public $ci;
    	public function __construct()
        {
            $this->ci = &get_instance();
        }

        public function init_session()
        {
            /*
            include_once dirname(__FILE__).'/../libraries/Session_handler.php';

            global $config;
            $redis_config = $config['redis'];

            $db = new Predis\Client(array(
                "scheme" => "tcp",
                "host" => $redis_config['host'],
                "port" => $redis_config['port'],
                'password' => $redis_config['password'],
            ));
            $sessHandler = new Session_handler($db);
            session_set_save_handler($sessHandler);
            /**/

            session_start();
        }

        public function init_cookie()
        {

        }

        public function init_file_system()
        {
            global $config;

            $aws_config = $config['aws'];
            $client = S3Client::factory(array(
                'credentials' => array(
                    'key'    => $aws_config['key'],
                    'secret' => $aws_config['secret'],
                )
            ));

            $client->registerStreamWrapper();
        }

        public function init_app()
        {
            global $config;
            Logger::log('config' , $config);

        	include_once dirname(__FILE__).'/../exceptions/exceptions.php';

            if (in_array(strtolower(ini_get('magic_quotes_gpc')), array('1', 'on')))
            {
                $_GET = array_map( 'stripslashes_deep', $_GET );
                $_COOKIE = array_map( 'stripslashes_deep', $_COOKIE );
                $_REQUEST = array_map( 'stripslashes_deep', $_REQUEST );
            }

        	if(isset($_SESSION["is_app_initialized"]))
        	{
        		$_SESSION["is_app_initialized"] = true;
        	}

            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                $_SESSION['return_uri'] = "";
            }

            if(isset($_REQUEST['return_uri']) && $_REQUEST['return_uri'] != "")
            {
                $_SESSION['return_uri'] = $_REQUEST['return_uri'];
            }
        }

        public function init_brand()
        {
            $this->ci = &get_instance();
            $user_id = $this->ci->user_session->get_user_id();
            if($user_id)
            {
                // $brand_service = Factory::get_service('common/brand_service');
                // $brand_service->setup_user($user_id);
            }
        }

        public function init_exception()
        {
        	Factory::get_service('common/error_service');
        }
    }
