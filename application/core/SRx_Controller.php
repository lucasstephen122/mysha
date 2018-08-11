<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Doctrine\Common\Annotations\AnnotationReader;

/**
 *@Annotation
 */
class Track
{
    public $ignore = false;
    public $action = '';
    public $module = '';
    public $tags = '';
}

abstract class SRx_Base_Controller extends CI_Controller
{
	// Note: Only the widely used HTTP status codes are documented

	// Informational

	const HTTP_CONTINUE = 100;
	const HTTP_SWITCHING_PROTOCOLS = 101;
	const HTTP_PROCESSING = 102;            // RFC2518

	// Success

	/**
	 * The request has succeeded
	 */
	const HTTP_OK = 200;

	/**
	 * The server successfully created a new resource
	 */
	const HTTP_CREATED = 201;
	const HTTP_ACCEPTED = 202;
	const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;

	/**
	 * The server successfully processed the request, though no content is returned
	 */
	const HTTP_NO_CONTENT = 204;
	const HTTP_RESET_CONTENT = 205;
	const HTTP_PARTIAL_CONTENT = 206;
	const HTTP_MULTI_STATUS = 207;          // RFC4918
	const HTTP_ALREADY_REPORTED = 208;      // RFC5842
	const HTTP_IM_USED = 226;               // RFC3229

	// Redirection

	const HTTP_MULTIPLE_CHOICES = 300;
	const HTTP_MOVED_PERMANENTLY = 301;
	const HTTP_FOUND = 302;
	const HTTP_SEE_OTHER = 303;

	/**
	 * The resource has not been modified since the last request
	 */
	const HTTP_NOT_MODIFIED = 304;
	const HTTP_USE_PROXY = 305;
	const HTTP_RESERVED = 306;
	const HTTP_TEMPORARY_REDIRECT = 307;
	const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238

	// Client Error

	/**
	 * The request cannot be fulfilled due to multiple errors
	 */
	const HTTP_BAD_REQUEST = 400;

	/**
	 * The user is unauthorized to access the requested resource
	 */
	const HTTP_UNAUTHORIZED = 401;
	const HTTP_PAYMENT_REQUIRED = 402;

	/**
	 * The requested resource is unavailable at this present time
	 */
	const HTTP_FORBIDDEN = 403;

	/**
	 * The requested resource could not be found
	 *
	 * Note: This is sometimes used to mask if there was an UNAUTHORIZED (401) or
	 * FORBIDDEN (403) error, for security reasons
	 */
	const HTTP_NOT_FOUND = 404;

	/**
	 * The request method is not supported by the following resource
	 */
	const HTTP_METHOD_NOT_ALLOWED = 405;

	/**
	 * The request was not acceptable
	 */
	const HTTP_NOT_ACCEPTABLE = 406;
	const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
	const HTTP_REQUEST_TIMEOUT = 408;

	/**
	 * The request could not be completed due to a conflict with the current state
	 * of the resource
	 */
	const HTTP_CONFLICT = 409;
	const HTTP_GONE = 410;
	const HTTP_LENGTH_REQUIRED = 411;
	const HTTP_PRECONDITION_FAILED = 412;
	const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
	const HTTP_REQUEST_URI_TOO_LONG = 414;
	const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
	const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
	const HTTP_EXPECTATION_FAILED = 417;
	const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
	const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
	const HTTP_LOCKED = 423;                                                      // RFC4918
	const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
	const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
	const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
	const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
	const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
	const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585

	// Server Error

	/**
	 * The server encountered an unexpected error
	 *
	 * Note: This is a generic error message when no specific message
	 * is suitable
	 */
	const HTTP_INTERNAL_SERVER_ERROR = 500;

	/**
	 * The server does not recognise the request method
	 */
	const HTTP_NOT_IMPLEMENTED = 501;
	const HTTP_BAD_GATEWAY = 502;
	const HTTP_SERVICE_UNAVAILABLE = 503;
	const HTTP_GATEWAY_TIMEOUT = 504;
	const HTTP_VERSION_NOT_SUPPORTED = 505;
	const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
	const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
	const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
	const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
	const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

	/**
	 * This defines the rest format
	 * Must be overridden it in a controller so that it is set
	 *
	 * @var string|NULL
	 */
	public $rest_format = NULL;

	/**
	 * Defines the list of method properties such as limit, log and level
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of allowed HTTP methods
	 *
	 * @var array
	 */
	public $allowed_http_methods = ['get', 'delete', 'post', 'put', 'options', 'patch', 'head'];

	/**
	 * Contains details about the request
	 * Fields: body, format, method, ssl
	 * Note: This is a dynamic object (stdClass)
	 *
	 * @var object
	 */
	public $request = NULL;

	/**
	 * Contains details about the response
	 * Fields: format, lang
	 * Note: This is a dynamic object (stdClass)
	 *
	 * @var object
	 */
	public $response = NULL;

	/**
	 * The arguments for the GET request method
	 *
	 * @var array
	 */
	public $_get_args = [];

	/**
	 * The arguments for the POST request method
	 *
	 * @var array
	 */
	public $_post_args = [];

	/**
	 * The arguments for the PUT request method
	 *
	 * @var array
	 */
	public $_put_args = [];

	/**
	 * The arguments for the DELETE request method
	 *
	 * @var array
	 */
	public $_delete_args = [];

	/**
	 * The arguments for the PATCH request method
	 *
	 * @var array
	 */
	public $_patch_args = [];

	/**
	 * The arguments for the HEAD request method
	 *
	 * @var array
	 */
	public $_head_args = [];

	/**
	 * The arguments for the OPTIONS request method
	 *
	 * @var array
	 */
	public $_options_args = [];

	/**
	 * The arguments for the query parameters
	 *
	 * @var array
	 */
	public $_query_args = [];

	/**
	 * The arguments from GET, POST, PUT, DELETE, PATCH, HEAD and OPTIONS request methods combined
	 *
	 * @var array
	 */
	public $_args = [];
	public $_args_map = [];

	/**
	 * List all supported methods, the first will be the default format
	 *
	 * @var array
	 */
	public $_supported_formats = [
		'json' => 'application/json',
		'array' => 'application/json',
		'csv' => 'application/csv',
		'html' => 'text/html',
		'jsonp' => 'application/javascript',
		'php' => 'text/plain',
		'serialized' => 'application/vnd.php.serialized',
		'xml' => 'application/xml'
	];

	/**
	 * HTTP status codes and their respective description
	 * Note: Only the widely used HTTP status codes are used
	 *
	 * @var array
	 * @link http://www.restapitutorial.com/httpstatuscodes.html
	 */
	public $http_status_codes = [
		self::HTTP_OK => 'OK',
		self::HTTP_CREATED => 'CREATED',
		self::HTTP_NO_CONTENT => 'NO CONTENT',
		self::HTTP_NOT_MODIFIED => 'NOT MODIFIED',
		self::HTTP_BAD_REQUEST => 'BAD REQUEST',
		self::HTTP_UNAUTHORIZED => 'UNAUTHORIZED',
		self::HTTP_FORBIDDEN => 'FORBIDDEN',
		self::HTTP_NOT_FOUND => 'NOT FOUND',
		self::HTTP_METHOD_NOT_ALLOWED => 'METHOD NOT ALLOWED',
		self::HTTP_NOT_ACCEPTABLE => 'NOT ACCEPTABLE',
		self::HTTP_CONFLICT => 'CONFLICT',
		self::HTTP_INTERNAL_SERVER_ERROR => 'INTERNAL SERVER ERROR',
		self::HTTP_NOT_IMPLEMENTED => 'NOT IMPLEMENTED'
	];

	public $_request_log_id;
	public $_start_time;
	public $_start_rtime;
	public $_end_time;
	public $_end_rtime;

	public $_output;
	public $_http_code;

	public $_request_type;
	public $_entity_type;
	public $_entity_id;
	public $_user_id;
	public $_api_key;

	public $_track;

	public function __construct()
	{
		parent::__construct();

		// Disable XML Entity (security vulnerability)
		libxml_disable_entity_loader(TRUE);

		// Check to see if PHP is equal to or greater than 5.4.x
		if (is_php('5.4') === FALSE)
		{
			// CodeIgniter 3 is recommended for v5.4 or above
			throw new Exception('Using PHP v' . PHP_VERSION . ', though PHP v5.4 or greater is required');
		}

		// Set the default value of global xss filtering. Same approach as CodeIgniter 3
		$this->_enable_xss = ($this->config->item('global_xss_filtering') === TRUE);

		// Don't try to parse template variables like {elapsed_time} and {memory_usage}
		// when output is displayed for not damaging data accidentally
		$this->output->parse_exec_vars = FALSE;

		// Start the timer for how long the request takes
		$this->_start_rtime = microtime(TRUE);

		// Start the timer for how long the request takes
		$this->_start_time = now();
		$this->_start_rtime = microtime(TRUE);

		// At present the library is bundled with REST_Controller 2.5+, but will eventually be part of CodeIgniter (no citation)
		$this->load->library('format');

		// Determine supported output formats from configiguration.
		$supported_formats = ['json' , 'xml' , 'html'];

		// Validate the configuration setting output formats
		if (empty($supported_formats))
		{
			$supported_formats = [];
		}

		if (!is_array($supported_formats))
		{
			$supported_formats = [$supported_formats];
		}

		// Add silently the default output format if it is missing.
		$default_format = $this->_get_default_output_format();
		if (!in_array($default_format, $supported_formats))
		{
			$supported_formats[] = $default_format;
		}

		// Now update $this->_supported_formats
		$this->_supported_formats = array_intersect_key($this->_supported_formats, array_flip($supported_formats));

		// Initialise the response, request and rest objects
		$this->request = new stdClass();
		$this->response = new stdClass();
		$this->rest = new stdClass();

		// Determine whether the connection is HTTPS
		$this->request->ssl = is_https();

		// How is this request being made? GET, POST, PATCH, DELETE, INSERT, PUT, HEAD or OPTIONS
		$this->request->method = $this->_detect_method();

		// Create an argument container if it doesn't exist e.g. _get_args
		if (isset($this->{'_' . $this->request->method . '_args'}) === FALSE)
		{
			$this->{'_' . $this->request->method . '_args'} = [];
		}

		// Set up the query parameters
		$this->_parse_query();

		// Set up the GET variables
		$this->_get_args = array_merge($this->_get_args, $this->uri->ruri_to_assoc());

		// Try to find a format for the request (means we have a request body)
		$this->request->format = $this->_detect_input_format();

		// Not all methods have a body attached with them
		$this->request->body = NULL;

		$this->{'_parse_' . $this->request->method}();

		// Now we know all about our request, let's try and parse the body if it exists
		if ($this->request->format && $this->request->body)
		{
			$this->request->body = $this->format->factory($this->request->body, $this->request->format)->to_array();
			// Assign payload arguments to proper method container
			$this->{'_' . $this->request->method . '_args'} = $this->request->body;
		}

		// Merge both for one mega-args variable
		$this->_args = array_merge(
			$this->_get_args,
			$this->_options_args,
			$this->_patch_args,
			$this->_head_args,
			$this->_put_args,
			$this->_post_args,
			$this->_delete_args,
			$this->{'_' . $this->request->method . '_args'}
		);

		$this->_args_map = [
			'get' => $this->_get_args,
			'options' => $this->_options_args,
			'patch' => $this->_patch_args,
			'head' => $this->_head_args,
			'put' => $this->_put_args,
			'post' => $this->_post_args,
			'delete' => $this->_delete_args,
			$this->request->method => $this->{'_' . $this->request->method . '_args'}
		];

		// Which format should the data be returned in?
		$this->response->format = $this->_detect_output_format();

		// Which language should the data be returned in?
		$this->response->lang = $this->_detect_lang();

		$this->_detect_tracking();

		$this->_detect_api_key();

		$this->_track_request();
	}

	public function __destruct()
    {

    }

    public function response_layout($layout)
    {
    	$this->layout->set_layout($layout);
    }

    public function response_view($view , $data = null , $return = false)
    {
    	if($return)
    	{
    		return $this->layout->view($view , $data , true);
    	}
    	else
    	{
    		$this->response($this->layout->view($view , $data , true));
    	}
    }

    public function redirect_back($uri = '')
	{
		$this->_http_code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 : 307;
		$this->_output = $uri;
		$this->_end_time = now();
        $this->_end_rtime = microtime(TRUE);

        $this->_track_response();

		return_redirect($uri);
	}

    public function redirect($uri = '', $method = 'auto', $code = NULL)
	{
		$this->_http_code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 : 307;
		$this->_output = $uri;
		$this->_end_time = now();
        $this->_end_rtime = microtime(TRUE);

        $this->_track_response();
        redirect(base_url().$uri , $method , $code);
	}
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data Data to output to the user
	 * @param int|NULL $http_code HTTP status code
	 * @param bool $continue TRUE to flush the response to the client and continue
	 * running the script; otherwise, exit
	 */
	public function response($data = NULL, $http_code = NULL, $continue = FALSE)
	{
		// If the HTTP status is not NULL, then cast as an integer
		if ($http_code !== NULL)
		{
			// So as to be safe later on in the process
			$http_code = (int) $http_code;
		}

		// Set the output as NULL by default
		$output = NULL;

		// If data is NULL and no HTTP status code provided, then display, error and exit
		if ($data === NULL && $http_code === NULL)
		{
			$http_code = self::HTTP_NOT_FOUND;
		}

		// If data is not NULL and a HTTP status code provided, then continue
		elseif ($data !== NULL)
		{
			// If the format method exists, call and return the output in that format
			if (method_exists($this->format, 'to_' . $this->response->format))
			{
				// Set the format header
				$this->output->set_content_type($this->_supported_formats[$this->response->format], strtolower($this->config->item('charset')));
				$output = $this->format->factory($data)->{'to_' . $this->response->format}();

				// An array must be parsed as a string, so as not to cause an array to string error
				// Json is the most appropriate form for such a datatype
				if ($this->response->format === 'array')
				{
					$output = $this->format->factory($output)->{'to_json'}();
				}
			}
			else
			{
				// If an array or object, then parse as a json, so as to be a 'string'
				if (is_array($data) || is_object($data))
				{
					$data = $this->format->factory($data)->{'to_json'}();
				}

				// Format is not supported, so output the raw data as a string
				$output = $data;
			}
		}

		// If not greater than zero, then set the HTTP status code as 200 by default
		// Though perhaps 500 should be set instead, for the developer not passing a
		// correct HTTP status code
		$http_code > 0 || $http_code = self::HTTP_OK;

		$this->output->set_status_header($http_code);

		// Output the data
		$this->output->set_output($output);

		$this->_http_code = $http_code;
		$this->_output = $output;
		$this->_end_time = now();
        $this->_end_rtime = microtime(TRUE);

        $this->_track_response();

		if ($continue === FALSE)
		{
			// Display the data and exit execution
			$this->output->_display();
			exit;
		}
		exit;
		// Otherwise dump the output automatically
	}

	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 * within the buffers of the Output class. The response is sent to the client
	 * lately by the framework, after the current controller's method termination.
	 * All the hooks after the controller's method termination are executable
	 *
	 * @access public
	 * @param array|NULL $data Data to output to the user
	 * @param int|NULL $http_code HTTP status code
	 */
	public function set_response($data = NULL, $http_code = NULL)
	{
		$this->response($data, $http_code, TRUE);
	}


	/**
	 * Detect tracking
	 *
	 * @access public
	 * @return bool
	 */
	public function _detect_tracking()
	{
		$controller = ucfirst($this->router->fetch_class());
		$path = $this->router->fetch_directory().$controller;
		$method = $this->router->fetch_method();

		$annotation_reader = new AnnotationReader();

		$this->_track = null;

		// Get class annotation
		$reflection_class = new ReflectionClass($controller);
		$class_annotations = $annotation_reader->getClassAnnotations($reflection_class);

		foreach ($class_annotations as $annotation)
		{
			if($annotation instanceof Track)
			{
				$class_annotation = $annotation;
			}
		}

		if($class_annotation)
		{
			$this->_track = $class_annotation;
		}

		// Method Annotations
		$reflection_method = new ReflectionMethod($controller, $method);
		$method_annotations = $annotation_reader->getMethodAnnotations($reflection_method);

		foreach ($method_annotations as $annotation)
		{
			if($annotation instanceof Track)
			{
				$method_annotation = $annotation;
			}
		}

		if($method_annotation)
		{
			$this->_track = $method_annotation;
		}

		if(!$this->_track)
		{
			$this->_track = new Track();
			$this->_track->ignore = false;
		}

		if(!$this->_track->action)
		{
			$this->_track->action = $this->router->fetch_directory().$this->router->fetch_class().'/'.$this->router->fetch_method();
		}

		if(!$this->_track->module)
		{
			$this->_track->module = substr($this->router->fetch_directory() , 0 , -1);

			if(!$this->_track->module)
			{
				$this->_track->module = $this->router->fetch_class();
			}
		}

		if(!$this->_track->tags)
		{
			$tags = $this->_track->module ? explode('/' , $this->_track->module) : array();
			$tags[] = $this->router->fetch_class();
			$tags[] = $this->router->fetch_method();
			$this->_track->tags = implode(',' , $tags);
		}
	}

	/**
	 * See if the user has provided an API key
	 *
	 * @access public
	 * @return bool
	 */
	public function _detect_api_key()
	{
		$api_key_var = 'X-SAMPLIFYRX-KEY';
		$api_key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_var));

		$key = isset($this->_args[$api_key_var]) ? $this->_args[$api_key_var] : $this->input->server($api_key_name);
		if ($key)
		{
			$api_key_service = Factory::get_service('rest/api_key_service');
			$api_key = $api_key_service->get_by_key($key);

			$this->_entity_type = $api_key['entity_type'];
			$this->_entity_id = $api_key['entity_id'];
			$this->_user_id = $api_key['user_id'];
			$this->_api_key = $api_key['key'];
			$this->_request_type = 'api';

			if (empty($api_key['is_private_key']) === FALSE)
			{
				if (isset($api_key['ip_addresses']))
				{
					$list_ip_addresses = explode(',', $api_key['ip_addresses']);
					$found_address = FALSE;

					foreach ($list_ip_addresses as $ip_address)
					{
						if ($this->input->ip_address() === trim($ip_address))
						{
							$found_address = TRUE;
							break;
						}
					}

					return $found_address;
				}
				else
				{
					return FALSE;
				}
			}
			return TRUE;
		}
		else
		{
			$is_alive = $this->user_session->is_alive();
			if($is_alive)
			{
				$user = $this->user_session->get_user();
				$this->_entity_type = $user['entity_type'];
				$this->_entity_id = $user['entity_id'];
				$this->_user_id = $user['user_id'];
				$this->_api_key = '';
				$this->_request_type = 'app';
			}

			return false;
		}

		// No key has been sent
		return FALSE;
	}

	/**
     * Get the input format e.g. json or xml
     *
     * @access public
     * @return string|NULL Supported input format; otherwise, NULL
     */
    public function _detect_input_format()
    {
        // Get the CONTENT-TYPE value from the SERVER variable
        $content_type = $this->input->server('CONTENT_TYPE');

        if (empty($content_type) === FALSE)
        {
            // Check all formats against the HTTP_ACCEPT header
            foreach ($this->_supported_formats as $key => $value)
            {
                // $key = format e.g. csv
                // $value = mime type e.g. application/csv

                // If a semi-colon exists in the string, then explode by ; and get the value of where
                // the current array pointer resides. This will generally be the first element of the array
                $content_type = (strpos($content_type, ';') !== FALSE ? current(explode(';', $content_type)) : $content_type);

                // If both the mime types match, then return the format
                if ($content_type === $value)
                {
                    return $key;
                }
            }
        }

        return NULL;
    }

    /**
     * Gets the default format from the configuration. Fallbacks to 'json'.
     * if the corresponding configuration option $config['rest_default_format']
     * is missing or is empty.
     *
     * @access public
     * @return string The default supported input format
     */
    public function _get_default_output_format()
    {
        $default_format = (string) $this->config->item('rest_default_format');
        return $default_format === '' ? 'json' : $default_format;
    }

    /**
     * Detect which format should be used to output the data
     *
     * @access public
     * @return mixed|NULL|string Output format
     */
    public function _detect_output_format()
    {
        // Concatenate formats to a regex pattern e.g. \.(csv|json|xml)
        $pattern = '/\.(' . implode('|', array_keys($this->_supported_formats)) . ')($|\/)/';
        $matches = [];

        // Check if a file extension is used e.g. http://example.com/api/index.json?param1=param2
        if (preg_match($pattern, $this->uri->uri_string(), $matches))
        {
            return $matches[1];
        }

        // Get the format parameter named as 'format'
        if (isset($this->_get_args['format']))
        {
            $format = strtolower($this->_get_args['format']);

            if (isset($this->_supported_formats[$format]) === TRUE)
            {
                return $format;
            }
        }

        // Get the HTTP_ACCEPT server variable
        $http_accept = $this->input->server('HTTP_ACCEPT');
        // Otherwise, check the HTTP_ACCEPT server variable
        if ($http_accept !== NULL)
        {
            // Check all formats against the HTTP_ACCEPT header
            foreach (array_keys($this->_supported_formats) as $format)
            {
                // Has this format been requested?
                if (strpos($http_accept, $format) !== FALSE)
                {
                    if ($format !== 'html' && $format !== 'xml')
                    {
                        // If not HTML or XML assume it's correct
                        return $format;
                    }
                    elseif ($format === 'html'/* && strpos($http_accept, 'xml') === FALSE/**/)
                    {
                        // HTML or XML have shown up as a match
                        // If it is truly HTML, it wont want any XML
                        return $format;
                    }
                    else if ($format === 'xml' && strpos($http_accept, 'html') === FALSE)
                    {
                        // If it is truly XML, it wont want any HTML
                        return $format;
                    }
                }
            }
        }

        // Check if the controller has a default format
        if (empty($this->rest_format) === FALSE)
        {
            return $this->rest_format;
        }

        // Obtain the default format from the configuration
        return $this->_get_default_output_format();
    }

    /**
     * Get the HTTP request string e.g. get or post
     *
     * @access public
     * @return string|NULL Supported request method as a lowercase string; otherwise, NULL if not supported
     */
    public function _detect_method()
    {
        // Declare a variable to store the method
        $method = NULL;

        // Determine whether the 'enable_emulate_request' setting is enabled
        if ($this->config->item('enable_emulate_request') === TRUE)
        {
            $method = $this->input->post('_method');
            if ($method === NULL)
            {
                $method = $this->input->server('HTTP_X_HTTP_METHOD_OVERRIDE');
            }

            $method = strtolower($method);
        }

        if (empty($method))
        {
            // Get the request method as a lowercase string
            $method = $this->input->method();
        }

        return in_array($method, $this->allowed_http_methods) && method_exists($this, '_parse_' . $method) ? $method : 'get';
    }

	public function result($result , $message = '')
	{
		return array(
				'status'        =>  true,
				'result'        =>  $result,
				'message'       =>  $message
		);
	}

	public function error($result , $message = '' , $errorCode = 0 , $handler = '')
	{
		return array(
				'status'        =>  false,
				'error_code'    =>  $errorCode,
				'result'        =>  $result,
				'message'       =>  $message,
				'handler'       =>  $handler
		);
	}

	public function _track_request()
	{
		if(!$this->_track->ignore)
		{
			// $request_log_service = Factory::get_service('report/request_log_service');

			$request_log = array();
			$request_log['entity_type'] = $this->_entity_type;
			$request_log['entity_id'] = $this->_entity_id;
			$request_log['user_id'] = $this->_user_id;
			$request_log['uri'] = $this->uri->uri_string();
			$request_log['controller'] = $this->router->fetch_directory().ucfirst($this->router->fetch_class());
			$request_log['method'] = $this->router->fetch_method();
			$request_log['action'] = $this->_track->action;
			$request_log['module'] = $this->_track->module;
			$request_log['tags'] = $this->_track->tags ? explode(',' , $this->_track->tags) : array();
			$request_log['request_type'] = $this->_request_type;
			$request_log['request_method'] = $this->request->method;
			$request_log['request'] = $this->_args_map ? json_encode($this->_args_map) : '{}';
			$request_log['response_code'] = 0;
			$request_log['response'] = NULL;
			$request_log['started_on'] = $this->_start_time;
			$request_log['ended_on'] = 0;
			$request_log['request_time'] = 0;
			$request_log['api_key'] = isset($this->_api_key) ? $this->_api_key : '';
			$request_log['ip_address'] = $this->input->ip_address();

			// $this->_request_log_id = $request_log_service->add_request_log($request_log);
		}
	}

	public function _track_response()
	{
		if(!$this->_track->ignore && $this->_request_log_id)
		{
			// $request_log_service = Factory::get_service('report/request_log_service');

			$request_log = array();
			$request_log['response_code'] = $this->_http_code;
			$request_log['response_type'] = $this->response->format;
			$request_log['response'] = ''; //$this->_output;
			$request_log['ended_on'] = $this->_end_time;
			$request_log['request_time'] = $this->_end_rtime - $this->_start_rtime;

			// $request_log_service->update_request_log($this->_request_log_id , $request_log);
		}
	}

	/**
	 * Preferred return language
	 *
	 * @access public
	 * @return string|NULL The language code
	 */
	public function _detect_lang()
	{
		$lang = $this->input->server('HTTP_ACCEPT_LANGUAGE');
		if ($lang === NULL)
		{
			return NULL;
		}

		// It appears more than one language has been sent using a comma delimiter
		if (strpos($lang, ',') !== FALSE)
		{
			$langs = explode(',', $lang);

			$return_langs = [];
			foreach ($langs as $lang)
			{
				// Remove weight and trim leading and trailing whitespace
				list($lang) = explode(';', $lang);
				$return_langs[] = trim($lang);
			}

			return $return_langs;
		}

		// Otherwise simply return as a string
		return $lang;
	}

	/**
	 * Parse the GET request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_get()
	{
		// Merge both the URI segments and query parameters
		$this->_get_args = array_merge($this->_get_args, $this->_query_args);
	}

	/**
	 * Parse the POST request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_post()
	{
		$this->_post_args = $_POST;

		if ($this->request->format)
		{
			$this->request->body = $this->input->raw_input_stream;
		}
	}

	/**
	 * Parse the PUT request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_put()
	{
		if ($this->request->format)
		{
			$this->request->body = $this->input->raw_input_stream;
		}
		else if ($this->input->method() === 'put')
		{
		   // If no filetype is provided, then there are probably just arguments
		   $this->_put_args = $this->input->input_stream();
		}
	}

	/**
	 * Parse the HEAD request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_head()
	{
		// Parse the HEAD variables
		parse_str(parse_url($this->input->server('REQUEST_URI'), PHP_URL_QUERY), $head);

		// Merge both the URI segments and HEAD params
		$this->_head_args = array_merge($this->_head_args, $head);
	}

	/**
	 * Parse the OPTIONS request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_options()
	{
		// Parse the OPTIONS variables
		parse_str(parse_url($this->input->server('REQUEST_URI'), PHP_URL_QUERY), $options);

		// Merge both the URI segments and OPTIONS params
		$this->_options_args = array_merge($this->_options_args, $options);
	}

	/**
	 * Parse the PATCH request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_patch()
	{
		// It might be a HTTP body
		if ($this->request->format)
		{
			$this->request->body = $this->input->raw_input_stream;
		}
		else if ($this->input->method() === 'patch')
		{
			// If no filetype is provided, then there are probably just arguments
			$this->_patch_args = $this->input->input_stream();
		}
	}

	/**
	 * Parse the DELETE request arguments
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_delete()
	{
		// These should exist if a DELETE request
		if ($this->input->method() === 'delete')
		{
			$this->_delete_args = $this->input->input_stream();
		}
	}

	/**
	 * Parse the query parameters
	 *
	 * @access public
	 * @return void
	 */
	public function _parse_query()
	{
		$this->_query_args = $this->input->get();
	}

	// INPUT FUNCTION --------------------------------------------------------------

	/**
	 * Retrieve a value from a GET request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the GET request
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the GET request; otherwise, NULL
	 */
	public function _get($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_get_args;
		}

		return isset($this->_get_args[$key]) ? $this->_xss_clean($this->_get_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from a OPTIONS request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the OPTIONS request.
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the OPTIONS request; otherwise, NULL
	 */
	public function _options($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_options_args;
		}

		return isset($this->_options_args[$key]) ? $this->_xss_clean($this->_options_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from a HEAD request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the HEAD request
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the HEAD request; otherwise, NULL
	 */
	public function _head($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_head_args;
		}

		return isset($this->_head_args[$key]) ? $this->_xss_clean($this->_head_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from a POST request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the POST request
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the POST request; otherwise, NULL
	 */
	public function _post($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_post_args;
		}

		return isset($this->_post_args[$key]) ? $this->_xss_clean($this->_post_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from a PUT request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the PUT request
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the PUT request; otherwise, NULL
	 */
	public function _put($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_put_args;
		}

		return isset($this->_put_args[$key]) ? $this->_xss_clean($this->_put_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from a DELETE request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the DELETE request
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the DELETE request; otherwise, NULL
	 */
	public function _delete($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_delete_args;
		}

		return isset($this->_delete_args[$key]) ? $this->_xss_clean($this->_delete_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from a PATCH request
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the PATCH request
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the PATCH request; otherwise, NULL
	 */
	public function _patch($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_patch_args;
		}

		return isset($this->_patch_args[$key]) ? $this->_xss_clean($this->_patch_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Retrieve a value from the query parameters
	 *
	 * @access public
	 * @param NULL $key Key to retrieve from the query parameters
	 * If NULL an array of arguments is returned
	 * @param NULL $xss_clean Whether to apply XSS filtering
	 * @return array|string|NULL Value from the query parameters; otherwise, NULL
	 */
	public function _query($key = NULL, $xss_clean = NULL)
	{
		if ($key === NULL)
		{
			return $this->_query_args;
		}

		return isset($this->_query_args[$key]) ? $this->_xss_clean($this->_query_args[$key], $xss_clean) : NULL;
	}

	/**
	 * Sanitizes data so that Cross Site Scripting Hacks can be
	 * prevented
	 *
	 * @access public
	 * @param  string $value Input data
	 * @param  bool $xss_clean Whether to apply XSS filtering
	 * @return string
	 */
	public function _xss_clean($value, $xss_clean)
	{
		is_bool($xss_clean) || $xss_clean = $this->_enable_xss;

		return $xss_clean === TRUE ? $this->security->xss_clean($value) : $value;
	}
}

class SRx_Controller extends SRx_Base_Controller
{

}


/**
 * CodeIgniter Rest Controller
 * A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 * @version         3.0.0
 */
class SRx_Restful_Controller extends SRx_Base_Controller
{
	/**
	 * Contains details about the REST API
	 * Fields: db, ignore_limits, key, level, user_id
	 * Note: This is a dynamic object (stdClass)
	 *
	 * @var object
	 */
	public $rest = NULL;

	/**
	 * The insert_id of the log entry (if we have one)
	 *
	 * @var string
	 */
	public $_insert_id = '';

	/**
	 * If the request is allowed based on the API key provided
	 *
	 * @var bool
	 */
	public $_allow = TRUE;

	/**
	 * The LDAP Distinguished Name of the User post authentication
	 *
	 * @var string
	 */
	public $_user_ldap_dn = '';

	/**
	 * Information about the current API user
	 *
	 * @var object
	 */
	public $_apiuser;

	/**
	 * Enable XSS flag
	 * Determines whether the XSS filter is always active when
	 * GET, OPTIONS, HEAD, POST, PUT, DELETE and PATCH data is encountered.
	 * Set automatically based on config setting
	 *
	 * @var bool
	 */
	public $_enable_xss = FALSE;

	/**
	 * Extend this function to apply additional checking early on in the process
	 *
	 * @access public
	 * @return void
	 */
	public function early_checks()
	{
	}

	/**
	 * Constructor for the REST API
	 *
	 * @access public
	 * @param string $config Configuration filename minus the file extension
	 * e.g: my_rest.php is passed as 'my_rest'
	 * @return void
	 */
	public function __construct($config = 'rest')
	{
		parent::__construct();

		// Disable XML Entity (security vulnerability)
		libxml_disable_entity_loader(TRUE);

		// Check to see if PHP is equal to or greater than 5.4.x
		if (is_php('5.4') === FALSE)
		{
			// CodeIgniter 3 is recommended for v5.4 or above
			throw new Exception('Using PHP v' . PHP_VERSION . ', though PHP v5.4 or greater is required');
		}

		// Check to see if this is CI 3.x
		if (explode('.', CI_VERSION, 2)[0] < 3)
		{
			throw new Exception('REST Server requires CodeIgniter 3.x');
		}

		// Set the default value of global xss filtering. Same approach as CodeIgniter 3
		$this->_enable_xss = ($this->config->item('global_xss_filtering') === TRUE);

		// Don't try to parse template variables like {elapsed_time} and {memory_usage}
		// when output is displayed for not damaging data accidentally
		$this->output->parse_exec_vars = FALSE;

		// Start the timer for how long the request takes
		$this->_start_rtime = microtime(TRUE);

		// Load the rest.php configuration file
		$this->load->config($config);

		// At present the library is bundled with REST_Controller 2.5+, but will eventually be part of CodeIgniter (no citation)
		$this->load->library('format');

		// Determine supported output formats from configiguration.
		$supported_formats = $this->config->item('rest_supported_formats');

		// Validate the configuration setting output formats
		if (empty($supported_formats))
		{
			$supported_formats = [];
		}

		if (!is_array($supported_formats))
		{
			$supported_formats = [$supported_formats];
		}

		// Add silently the default output format if it is missing.
		$default_format = $this->_get_default_output_format();
		if (!in_array($default_format, $supported_formats))
		{
			$supported_formats[] = $default_format;
		}

		// Now update $this->_supported_formats
		$this->_supported_formats = array_intersect_key($this->_supported_formats, array_flip($supported_formats));

		// Get the language
		$language = $this->config->item('rest_language');
		if ($language === NULL)
		{
			$language = 'english';
		}

		// Load the language file
		$this->lang->load('rest_controller', $language);

		// Initialise the response, request and rest objects
		$this->request = new stdClass();
		$this->response = new stdClass();
		$this->rest = new stdClass();

		// Check to see if the current IP address is blacklisted
		if ($this->config->item('rest_ip_blacklist_enabled') === TRUE)
		{
			$this->_check_blacklist_auth();
		}

		// Determine whether the connection is HTTPS
		$this->request->ssl = is_https();

		// How is this request being made? GET, POST, PATCH, DELETE, INSERT, PUT, HEAD or OPTIONS
		$this->request->method = $this->_detect_method();

		// Create an argument container if it doesn't exist e.g. _get_args
		if (isset($this->{'_' . $this->request->method . '_args'}) === FALSE)
		{
			$this->{'_' . $this->request->method . '_args'} = [];
		}

		// Set up the query parameters
		$this->_parse_query();

		// Set up the GET variables
		$this->_get_args = array_merge($this->_get_args, $this->uri->ruri_to_assoc());

		// Try to find a format for the request (means we have a request body)
		$this->request->format = $this->_detect_input_format();

		// Not all methods have a body attached with them
		$this->request->body = NULL;

		$this->{'_parse_' . $this->request->method}();

		// Now we know all about our request, let's try and parse the body if it exists
		if ($this->request->format && $this->request->body)
		{
			$this->request->body = $this->format->factory($this->request->body, $this->request->format)->to_array();
			// Assign payload arguments to proper method container
			$this->{'_' . $this->request->method . '_args'} = $this->request->body;
		}

		// Merge both for one mega-args variable
		$this->_args = array_merge(
			$this->_get_args,
			$this->_options_args,
			$this->_patch_args,
			$this->_head_args,
			$this->_put_args,
			$this->_post_args,
			$this->_delete_args,
			$this->{'_' . $this->request->method . '_args'}
		);

		// Which format should the data be returned in?
		$this->response->format = $this->_detect_output_format();

		// Which language should the data be returned in?
		$this->response->lang = $this->_detect_lang();

		// Extend this function to apply additional checking early on in the process
		$this->early_checks();

		// Load DB if its enabled
		if ($this->config->item('rest_database_group') && ($this->config->item('rest_enable_keys')))
		{
			$this->rest->db = $this->load->database($this->config->item('rest_database_group'), TRUE);
		}

		// Use whatever database is in use (isset returns FALSE)
		elseif (property_exists($this, 'db'))
		{
			$this->rest->db = $this->db;
		}

		// Check if there is a specific auth type for the current class/method
		// _auth_override_check could exit so we need $this->rest->db initialized before
		$this->auth_override = $this->_auth_override_check();

		// Checking for keys? GET TO WorK!
		// Skip keys test for $config['auth_override_class_method']['class'['method'] = 'none'
		if ($this->config->item('rest_enable_keys') && $this->auth_override !== TRUE)
		{
			$this->_allow = $this->_detect_api_key();
		}

		// Only allow ajax requests
		if ($this->input->is_ajax_request() === FALSE && $this->config->item('rest_ajax_only'))
		{
			// Display an error response
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_ajax_only')
				], self::HTTP_NOT_ACCEPTABLE);
		}

		// When there is no specific override for the current class/method, use the default auth value set in the config
		if ($this->auth_override === FALSE && !($this->config->item('rest_enable_keys') && $this->_allow === TRUE))
		{
			$rest_auth = strtolower($this->config->item('rest_auth'));
			switch ($rest_auth)
			{
				case 'basic':
					$this->_prepare_basic_auth();
					break;
				case 'digest':
					$this->_prepare_digest_auth();
					break;
				case 'session':
					$this->_check_php_session();
					break;
			}
			if ($this->config->item('rest_ip_whitelist_enabled') === TRUE)
			{
				$this->_check_whitelist_auth();
			}
		}
	}

	/**
	 * Deconstructor
	 *
	 * @author Chris Kacerguis
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{
		// Get the current timestamp
		$this->_end_rtime = microtime(TRUE);
	}

	/**
	 * Requests are not made to methods directly, the request will be for
	 * an "object". This simply maps the object and method to the correct
	 * Controller method
	 *
	 * @access public
	 * @param  string $object_called
	 * @param  array $arguments The arguments passed to the controller method
	 */
	public function _remap($object_called, $arguments)
	{
		// Should we answer if not over SSL?
		if ($this->config->item('force_https') && $this->request->ssl === FALSE)
		{
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_unsupported')
				], self::HTTP_FORBIDDEN);
		}

		// Remove the supported format from the function name e.g. index.json => index
		$object_called = preg_replace('/^(.*)\.(?:' . implode('|', array_keys($this->_supported_formats)) . ')$/', '$1', $object_called);

		$controller_method = $object_called . '_' . $this->request->method;

		/**/
		// Change : Start

		switch($this->request->method)
		{
			case 'get' :
				if(method_exists($this, $object_called))
				{
					$controller_method = $object_called;
				}
				else
				{
					array_unshift($arguments , $object_called);
					$controller_method = 'read';
				}
				break;

			case 'post' :
			case 'put' :
				if(method_exists($this, $object_called))
				{
					$controller_method = $object_called;
				}
				else
				{
					array_unshift($arguments , $object_called);
					$controller_method = 'update';
				}
				break;

			case 'delete' :
				if($object_called == 'index')
				{
					$controller_method = 'unknown';
				}
				else
				{
					array_unshift($arguments , $object_called);
					$controller_method = 'destroy';
				}
				break;
		}
		// Change : End
		/**/

		// debug($object_called , false);
		// debug($arguments , false);
		// debug($controller_method , false);
		// debug(method_exists($this, $controller_method));

		// Do we want to log this method (if allowed by config)?
		$log_method = !(isset($this->methods[$controller_method]['log']) && $this->methods[$controller_method]['log'] === FALSE);

		// Use keys for this method?
		$use_key = !(isset($this->methods[$controller_method]['key']) && $this->methods[$controller_method]['key'] === FALSE);

		// They provided a key, but it wasn't valid, so get them out of here
		if ($this->config->item('rest_enable_keys') && $use_key && $this->_allow === FALSE)
		{
			if ($this->config->item('rest_enable_logging') && $log_method)
			{
				$this->_log_request();
			}

			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => sprintf($this->lang->line('text_rest_invalid_api_key'), $this->rest->key)
				], self::HTTP_FORBIDDEN);
		}

		// Check to see if this key has access to the requested controller
		if ($this->config->item('rest_enable_keys') && $use_key && empty($this->rest->key) === FALSE && $this->_check_access() === FALSE)
		{
			if ($this->config->item('rest_enable_logging') && $log_method)
			{
				$this->_log_request();
			}

			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_api_key_unauthorized')
				], self::HTTP_UNAUTHORIZED);
		}

		// Sure it exists, but can they do anything with it?
		if (method_exists($this, $controller_method) === FALSE)
		{
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_unknown_method')
				], self::HTTP_NOT_FOUND);
		}

		// Doing key related stuff? Can only do it if they have a key right?
		if ($this->config->item('rest_enable_keys') && empty($this->rest->key) === FALSE)
		{
			// Check the limit
			if ($this->config->item('rest_enable_limits') && $this->_check_limit($controller_method) === FALSE)
			{
				$response = [$this->config->item('rest_status_field_name') => FALSE, $this->config->item('rest_message_field_name') => $this->lang->line('text_rest_api_key_time_limit')];
				$this->response($response, self::HTTP_UNAUTHORIZED);
			}

			// If no level is set use 0, they probably aren't using permissions
			$level = isset($this->methods[$controller_method]['level']) ? $this->methods[$controller_method]['level'] : 0;

			// If no level is set, or it is lower than/equal to the key's level
			$authorized = $level <= $this->rest->level;

			// IM TELLIN!
			if ($this->config->item('rest_enable_logging') && $log_method)
			{
				$this->_log_request($authorized);
			}

			// They don't have good enough perms
			$response = [$this->config->item('rest_status_field_name') => FALSE, $this->config->item('rest_message_field_name') => $this->lang->line('text_rest_api_key_permissions')];
			$authorized || $this->response($response, self::HTTP_UNAUTHORIZED);
		}

		// No key stuff, but record that stuff is happening
		elseif ($this->config->item('rest_enable_logging') && $log_method)
		{
			$this->_log_request($authorized = TRUE);
		}

		// Call the controller method and passed arguments
		try
		{
			call_user_func_array([$this, $controller_method], $arguments);
		}
		catch (Exception $ex)
		{
			$error_service = Factory::get_service('common/error_service');
			$error_service->on_exception($ex);
			exit;
			/*
			// If the method doesn't exist, then the error will be caught and an error response shown
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => [
						'classname' => get_class($ex),
						'message' => $ex->getMessage()
					]
				], self::HTTP_INTERNAL_SERVER_ERROR);
			/**/
		}
	}

	/**
	 * Add the request to the log table
	 *
	 * @access public
	 * @param bool $authorized TRUE the user is authorized; otherwise, FALSE
	 * @return bool TRUE the data was inserted; otherwise, FALSE
	 */
	public function _log_request($authorized = FALSE)
	{
		// Insert the request into the log table
		$is_inserted = $this->rest->db
			->insert(
				$this->config->item('rest_logs_table'), [
				'uri' => $this->uri->uri_string(),
				'method' => $this->request->method,
				'params' => $this->_args ? ($this->config->item('rest_logs_json_params') === TRUE ? json_encode($this->_args) : serialize($this->_args)) : NULL,
				'api_key' => isset($this->rest->key) ? $this->rest->key : '',
				'ip_address' => $this->input->ip_address(),
				'time' => time(),
				'authorized' => $authorized
			]);

		// Get the last insert id to update at a later stage of the request
		$this->_insert_id = $this->rest->db->insert_id();

		return $is_inserted;
	}

	/**
	 * Check if the requests to a controller method exceed a limit
	 *
	 * @access public
	 * @param  string $controller_method The method being called
	 * @return bool TRUE the call limit is below the threshold; otherwise, FALSE
	 */
	public function _check_limit($controller_method)
	{
		// They are special, or it might not even have a limit
		if (empty($this->rest->ignore_limits) === FALSE)
		{
			// Everything is fine
			return TRUE;
		}

		switch ($this->config->item('rest_limits_method'))
		{
		  case 'API_KEY':
			$limited_uri = 'api-key:' . (isset($this->rest->key) ? $this->rest->key : '');
			$limited_method_name = isset($this->rest->key) ? $this->rest->key : '';
			break;

		  case 'METHOD_NAME':
			$limited_uri = 'method-name:' . $controller_method;
			$limited_method_name =  $controller_method;
			break;

		  case 'ROUTED_URL':
		  default:
			$limited_uri = $this->uri->ruri_string();
			if (strpos(strrev($limited_uri), strrev($this->response->format)) === 0)
			{
				$limited_uri = substr($limited_uri,0, -strlen($this->response->format) - 1);
			}
			$limited_uri = 'uri:' . $limited_uri . ':' . $this->request->method; // It's good to differentiate GET from PUT
			$limited_method_name = $controller_method;
			break;
		}

		if (isset($this->methods[$limited_method_name]['limit']) === FALSE )
		{
			// Everything is fine
			return TRUE;
		}

		// How many times can you get to this method in a defined time_limit (default: 1 hour)?
		$limit = $this->methods[$limited_method_name]['limit'];

		$time_limit = (isset($this->methods[$limited_method_name]['time']) ? $this->methods[$limited_method_name]['time'] : 3600); // 3600 = 60 * 60

		// Get data about a keys' usage and limit to one row
		$result = $this->rest->db
			->where('uri', $limited_uri)
			->where('api_key', $this->rest->key)
			->get($this->config->item('rest_limits_table'))
			->row();

		// No calls have been made for this key
		if ($result === NULL)
		{
			// Create a new row for the following key
			$this->rest->db->insert($this->config->item('rest_limits_table'), [
				'uri' => $limited_uri,
				'api_key' => isset($this->rest->key) ? $this->rest->key : '',
				'count' => 1,
				'hour_started' => time()
			]);
		}

		// Been a time limit (or by default an hour) since they called
		elseif ($result->hour_started < (time() - $time_limit))
		{
			// Reset the started period and count
			$this->rest->db
				->where('uri', $limited_uri)
				->where('api_key', isset($this->rest->key) ? $this->rest->key : '')
				->set('hour_started', time())
				->set('count', 1)
				->update($this->config->item('rest_limits_table'));
		}

		// They have called within the hour, so lets update
		else
		{
			// The limit has been exceeded
			if ($result->count >= $limit)
			{
				return FALSE;
			}

			// Increase the count by one
			$this->rest->db
				->where('uri', $limited_uri)
				->where('api_key', $this->rest->key)
				->set('count', 'count + 1', FALSE)
				->update($this->config->item('rest_limits_table'));
		}

		return TRUE;
	}

	/**
	 * Check if there is a specific auth type set for the current class/method/HTTP-method being called
	 *
	 * @access public
	 * @return bool
	 */
	public function _auth_override_check()
	{
		// Assign the class/method auth type override array from the config
		$auth_override_class_method = $this->config->item('auth_override_class_method');

		// Check to see if the override array is even populated
		if (!empty($auth_override_class_method))
		{
			// check for wildcard flag for rules for classes
			if (!empty($auth_override_class_method[$this->router->class]['*'])) // Check for class overrides
			{
				// None auth override found, prepare nothing but send back a TRUE override flag
				if ($auth_override_class_method[$this->router->class]['*'] === 'none')
				{
					return TRUE;
				}

				// Basic auth override found, prepare basic
				if ($auth_override_class_method[$this->router->class]['*'] === 'basic')
				{
					$this->_prepare_basic_auth();

					return TRUE;
				}

				// Digest auth override found, prepare digest
				if ($auth_override_class_method[$this->router->class]['*'] === 'digest')
				{
					$this->_prepare_digest_auth();

					return TRUE;
				}

				// Session auth override found, check session
				if ($auth_override_class_method[$this->router->class]['*'] === 'session')
				{
					$this->_check_php_session();

					return TRUE;
				}

				// Whitelist auth override found, check client's ip against config whitelist
				if ($auth_override_class_method[$this->router->class]['*'] === 'whitelist')
				{
					$this->_check_whitelist_auth();

					return TRUE;
				}
			}

			// Check to see if there's an override value set for the current class/method being called
			if (!empty($auth_override_class_method[$this->router->class][$this->router->method]))
			{
				// None auth override found, prepare nothing but send back a TRUE override flag
				if ($auth_override_class_method[$this->router->class][$this->router->method] === 'none')
				{
					return TRUE;
				}

				// Basic auth override found, prepare basic
				if ($auth_override_class_method[$this->router->class][$this->router->method] === 'basic')
				{
					$this->_prepare_basic_auth();

					return TRUE;
				}

				// Digest auth override found, prepare digest
				if ($auth_override_class_method[$this->router->class][$this->router->method] === 'digest')
				{
					$this->_prepare_digest_auth();

					return TRUE;
				}

				// Session auth override found, check session
				if ($auth_override_class_method[$this->router->class][$this->router->method] === 'session')
				{
					$this->_check_php_session();

					return TRUE;
				}

				// Whitelist auth override found, check client's ip against config whitelist
				if ($auth_override_class_method[$this->router->class][$this->router->method] === 'whitelist')
				{
					$this->_check_whitelist_auth();

					return TRUE;
				}
			}
		}

		// Assign the class/method/HTTP-method auth type override array from the config
		$auth_override_class_method_http = $this->config->item('auth_override_class_method_http');

		// Check to see if the override array is even populated
		if (!empty($auth_override_class_method_http))
		{
			// check for wildcard flag for rules for classes
			if(!empty($auth_override_class_method_http[$this->router->class]['*'][$this->request->method]))
			{
				// None auth override found, prepare nothing but send back a TRUE override flag
				if ($auth_override_class_method_http[$this->router->class]['*'][$this->request->method] === 'none')
				{
					return TRUE;
				}

				// Basic auth override found, prepare basic
				if ($auth_override_class_method_http[$this->router->class]['*'][$this->request->method] === 'basic')
				{
					$this->_prepare_basic_auth();

					return TRUE;
				}

				// Digest auth override found, prepare digest
				if ($auth_override_class_method_http[$this->router->class]['*'][$this->request->method] === 'digest')
				{
					$this->_prepare_digest_auth();

					return TRUE;
				}

				// Session auth override found, check session
				if ($auth_override_class_method_http[$this->router->class]['*'][$this->request->method] === 'session')
				{
					$this->_check_php_session();

					return TRUE;
				}

				// Whitelist auth override found, check client's ip against config whitelist
				if ($auth_override_class_method_http[$this->router->class]['*'][$this->request->method] === 'whitelist')
				{
					$this->_check_whitelist_auth();

					return TRUE;
				}
			}

			// Check to see if there's an override value set for the current class/method/HTTP-method being called
			if(!empty($auth_override_class_method_http[$this->router->class][$this->router->method][$this->request->method]))
			{
				// None auth override found, prepare nothing but send back a TRUE override flag
				if ($auth_override_class_method_http[$this->router->class][$this->router->method][$this->request->method] === 'none')
				{
					return TRUE;
				}

				// Basic auth override found, prepare basic
				if ($auth_override_class_method_http[$this->router->class][$this->router->method][$this->request->method] === 'basic')
				{
					$this->_prepare_basic_auth();

					return TRUE;
				}

				// Digest auth override found, prepare digest
				if ($auth_override_class_method_http[$this->router->class][$this->router->method][$this->request->method] === 'digest')
				{
					$this->_prepare_digest_auth();

					return TRUE;
				}

				// Session auth override found, check session
				if ($auth_override_class_method_http[$this->router->class][$this->router->method][$this->request->method] === 'session')
				{
					$this->_check_php_session();

					return TRUE;
				}

				// Whitelist auth override found, check client's ip against config whitelist
				if ($auth_override_class_method_http[$this->router->class][$this->router->method][$this->request->method] === 'whitelist')
				{
					$this->_check_whitelist_auth();

					return TRUE;
				}
			}
		}
		return FALSE;
	}

	/**
	 * Retrieve the validation errors
	 *
	 * @access public
	 * @return array
	 */
	public function validation_errors()
	{
		$string = strip_tags($this->form_validation->error_string());

		return explode(PHP_EOL, trim($string, PHP_EOL));
	}

	// SECURITY FUNCTIONS ---------------------------------------------------------

	/**
	 * Perform LDAP Authentication
	 *
	 * @access public
	 * @param  string $username The username to validate
	 * @param  string $password The password to validate
	 * @return bool
	 */
	public function _perform_ldap_auth($username = '', $password = NULL)
	{
		if (empty($username))
		{
			log_message('debug', 'LDAP Auth: failure, empty username');
			return FALSE;
		}

		log_message('debug', 'LDAP Auth: Loading configuration');

		$this->config->load('ldap.php', TRUE);

		$ldap = [
			'timeout' => $this->config->item('timeout', 'ldap'),
			'host' => $this->config->item('server', 'ldap'),
			'port' => $this->config->item('port', 'ldap'),
			'rdn' => $this->config->item('binduser', 'ldap'),
			'pass' => $this->config->item('bindpw', 'ldap'),
			'basedn' => $this->config->item('basedn', 'ldap'),
		];

		log_message('debug', 'LDAP Auth: Connect to ' . (isset($ldaphost) ? $ldaphost : '[ldap not configured]'));

		// Connect to the ldap server
		$ldapconn = ldap_connect($ldap['host'], $ldap['port']);
		if ($ldapconn)
		{
			log_message('debug', 'Setting timeout to ' . $ldap['timeout'] . ' seconds');

			ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, $ldap['timeout']);

			log_message('debug', 'LDAP Auth: Binding to ' . $ldap['host'] . ' with dn ' . $ldap['rdn']);

			// Binding to the ldap server
			$ldapbind = ldap_bind($ldapconn, $ldap['rdn'], $ldap['pass']);

			// Verify the binding
			if ($ldapbind === FALSE)
			{
				log_message('error', 'LDAP Auth: bind was unsuccessful');
				return FALSE;
			}

			log_message('debug', 'LDAP Auth: bind successful');
		}

		// Search for user
		if (($res_id = ldap_search($ldapconn, $ldap['basedn'], "uid=$username")) === FALSE)
		{
			log_message('error', 'LDAP Auth: User ' . $username . ' not found in search');
			return FALSE;
		}

		if (ldap_count_entries($ldapconn, $res_id) !== 1)
		{
			log_message('error', 'LDAP Auth: Failure, username ' . $username . 'found more than once');
			return FALSE;
		}

		if (($entry_id = ldap_first_entry($ldapconn, $res_id)) === FALSE)
		{
			log_message('error', 'LDAP Auth: Failure, entry of search result could not be fetched');
			return FALSE;
		}

		if (($user_dn = ldap_get_dn($ldapconn, $entry_id)) === FALSE)
		{
			log_message('error', 'LDAP Auth: Failure, user-dn could not be fetched');
			return FALSE;
		}

		// User found, could not authenticate as user
		if (($link_id = ldap_bind($ldapconn, $user_dn, $password)) === FALSE)
		{
			log_message('error', 'LDAP Auth: Failure, username/password did not match: ' . $user_dn);
			return FALSE;
		}

		log_message('debug', 'LDAP Auth: Success ' . $user_dn . ' authenticated successfully');

		$this->_user_ldap_dn = $user_dn;

		ldap_close($ldapconn);

		return TRUE;
	}

	/**
	 * Perform Library Authentication - Override this function to change the way the library is called
	 *
	 * @access public
	 * @param  string $username The username to validate
	 * @param  string $password The password to validate
	 * @return bool
	 */
	public function _perform_library_auth($username = '', $password = NULL)
	{
		if (empty($username))
		{
			log_message('error', 'Library Auth: Failure, empty username');
			return FALSE;
		}

		$auth_library_class = strtolower($this->config->item('auth_library_class'));
		$auth_library_function = strtolower($this->config->item('auth_library_function'));

		if (empty($auth_library_class))
		{
			log_message('debug', 'Library Auth: Failure, empty auth_library_class');
			return FALSE;
		}

		if (empty($auth_library_function))
		{
			log_message('debug', 'Library Auth: Failure, empty auth_library_function');
			return FALSE;
		}

		if (is_callable([$auth_library_class, $auth_library_function]) === FALSE)
		{
			$this->load->library($auth_library_class);
		}

		return $this->{$auth_library_class}->$auth_library_function($username, $password);
	}

	/**
	 * Check if the user is logged in
	 *
	 * @access public
	 * @param  string $username The user's name
	 * @param  bool|string $password The user's password
	 * @return bool
	 */
	public function _check_login($username = NULL, $password = FALSE)
	{
		if (empty($username))
		{
			return FALSE;
		}

		$auth_source = strtolower($this->config->item('auth_source'));
		$rest_auth = strtolower($this->config->item('rest_auth'));
		$valid_logins = $this->config->item('rest_valid_logins');

		if (!$this->config->item('auth_source') && $rest_auth === 'digest')
		{
			// For digest we do not have a password passed as argument
			return md5($username . ':' . $this->config->item('rest_realm') . ':' . (isset($valid_logins[$username]) ? $valid_logins[$username] : ''));
		}

		if ($password === FALSE)
		{
			return FALSE;
		}

		if ($auth_source === 'ldap')
		{
			log_message('debug', "Performing LDAP authentication for $username");

			return $this->_perform_ldap_auth($username, $password);
		}

		if ($auth_source === 'library')
		{
			log_message('debug', "Performing Library authentication for $username");

			return $this->_perform_library_auth($username, $password);
		}

		if (array_key_exists($username, $valid_logins) === FALSE)
		{
			return FALSE;
		}

		if ($valid_logins[$username] !== $password)
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Check to see if the user is logged in with a PHP session key
	 *
	 * @access public
	 * @return void
	 */
	public function _check_php_session()
	{
		// Get the auth_source config item
		$key = $this->config->item('auth_source');

		// If falsy, then the user isn't logged in
		if (!$this->session->userdata($key))
		{
			// Display an error response
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_unauthorized')
				], self::HTTP_UNAUTHORIZED);
		}
	}

	/**
	 * Prepares for basic authentication
	 *
	 * @access public
	 * @return void
	 */
	public function _prepare_basic_auth()
	{
		// If whitelist is enabled it has the first chance to kick them out
		if ($this->config->item('rest_ip_whitelist_enabled'))
		{
			$this->_check_whitelist_auth();
		}

		// Returns NULL if the SERVER variables PHP_AUTH_USER and HTTP_AUTHENTICATION don't exist
		$username = $this->input->server('PHP_AUTH_USER');
		$http_auth = $this->input->server('HTTP_AUTHENTICATION');

		$password = NULL;
		if ($username !== NULL)
		{
			$password = $this->input->server('PHP_AUTH_PW');
		}
		elseif ($http_auth !== NULL)
		{
			// If the authentication header is set as basic, then extract the username and password from
			// HTTP_AUTHORIZATION e.g. my_username:my_password. This is passed in the .htaccess file
			if (strpos(strtolower($http_auth), 'basic') === 0)
			{
				// Search online for HTTP_AUTHORIZATION workaround to explain what this is doing
				list($username, $password) = explode(':', base64_decode(substr($this->input->server('HTTP_AUTHORIZATION'), 6)));
			}
		}

		// Check if the user is logged into the system
		if ($this->_check_login($username, $password) === FALSE)
		{
			$this->_force_login();
		}
	}

	/**
	 * Prepares for digest authentication
	 *
	 * @access public
	 * @return void
	 */
	public function _prepare_digest_auth()
	{
		// If whitelist is enabled it has the first chance to kick them out
		if ($this->config->item('rest_ip_whitelist_enabled'))
		{
			$this->_check_whitelist_auth();
		}

		// We need to test which server authentication variable to use,
		// because the PHP ISAPI module in IIS acts different from CGI
		$digest_string = $this->input->server('PHP_AUTH_DIGEST');
		if ($digest_string === NULL)
		{
			$digest_string = $this->input->server('HTTP_AUTHORIZATION');
		}

		$unique_id = uniqid();

		// The $_SESSION['error_prompted'] variable is used to ask the password
		// again if none given or if the user enters wrong auth information
		if (empty($digest_string))
		{
			$this->_force_login($unique_id);
		}

		// We need to retrieve authentication data from the $digest_string variable
		$matches = [];
		preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)=[\'"]?([^\'",]+)@', $digest_string, $matches);
		$digest = (empty($matches[1]) || empty($matches[2])) ? [] : array_combine($matches[1], $matches[2]);

		// For digest authentication the library function should return already stored md5(username:restrealm:password) for that username @see rest.php::auth_library_function config
		$username = $this->_check_login($digest['username'], TRUE);
		if (array_key_exists('username', $digest) === FALSE || $username === FALSE)
		{
			$this->_force_login($unique_id);
		}

		$md5 = md5(strtoupper($this->request->method) . ':' . $digest['uri']);
		$valid_response = md5($username . ':' . $digest['nonce'] . ':' . $digest['nc'] . ':' . $digest['cnonce'] . ':' . $digest['qop'] . ':' . $md5);

		// Check if the string don't compare (case-insensitive)
		if (strcasecmp($digest['response'], $valid_response) !== 0)
		{
			// Display an error response
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_invalid_credentials')
				], self::HTTP_UNAUTHORIZED);
		}
	}

	/**
	 * Checks if the client's ip is in the 'rest_ip_blacklist' config and generates a 401 response
	 *
	 * @access public
	 * @return void
	 */
	public function _check_blacklist_auth()
	{
		// Match an ip address in a blacklist e.g. 127.0.0.0, 0.0.0.0
		$pattern = sprintf('/(?:,\s*|^)\Q%s\E(?=,\s*|$)/m', $this->input->ip_address());

		// Returns 1, 0 or FALSE (on error only). Therefore implicitly convert 1 to TRUE
		if (preg_match($pattern, $this->config->item('rest_ip_blacklist')))
		{
			// Display an error response
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_ip_denied')
				], self::HTTP_UNAUTHORIZED);
		}
	}

	/**
	 * Check if the client's ip is in the 'rest_ip_whitelist' config and generates a 401 response
	 *
	 * @access public
	 * @return void
	 */
	public function _check_whitelist_auth()
	{
		$whitelist = explode(',', $this->config->item('rest_ip_whitelist'));

		array_push($whitelist, '127.0.0.1', '0.0.0.0');

		foreach ($whitelist as &$ip)
		{
			// As $ip is a reference, trim leading and trailing whitespace, then store the new value
			// using the reference
			$ip = trim($ip);
		}

		if (in_array($this->input->ip_address(), $whitelist) === FALSE)
		{
			$this->response([
					$this->config->item('rest_status_field_name') => FALSE,
					$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_ip_unauthorized')
				], self::HTTP_UNAUTHORIZED);
		}
	}

	/**
	 * Force logging in by setting the WWW-Authenticate header
	 *
	 * @access public
	 * @param string $nonce A server-specified data string which should be uniquely generated
	 * each time
	 * @return void
	 */
	public function _force_login($nonce = '')
	{
		$rest_auth = $this->config->item('rest_auth');
		$rest_realm = $this->config->item('rest_realm');
		if (strtolower($rest_auth) === 'basic')
		{
			// See http://tools.ietf.org/html/rfc2617#page-5
			header('WWW-Authenticate: Basic realm="' . $rest_realm . '"');
		}
		elseif (strtolower($rest_auth) === 'digest')
		{
			// See http://tools.ietf.org/html/rfc2617#page-18
			header(
				'WWW-Authenticate: Digest realm="' . $rest_realm
				. '", qop="auth", nonce="' . $nonce
				. '", opaque="' . md5($rest_realm) . '"');
		}

		// Display an error response
		$this->response([
				$this->config->item('rest_status_field_name') => FALSE,
				$this->config->item('rest_message_field_name') => $this->lang->line('text_rest_unauthorized')
			], self::HTTP_UNAUTHORIZED);
	}

	/**
	 * Check to see if the API key has access to the controller and methods
	 *
	 * @access public
	 * @return bool TRUE the API key has access; otherwise, FALSE
	 */
	public function _check_access()
	{
		// If we don't want to check access, just return TRUE
		if ($this->config->item('rest_enable_access') === FALSE)
		{
			return TRUE;
		}

		// Fetch controller based on path and controller name
		$controller = implode(
			'/', [
			$this->router->directory,
			$this->router->class
		]);

		// Remove any double slashes for safety
		$controller = str_replace('//', '/', $controller);

		// Query the access table and get the number of results
		return $this->rest->db
			->where('key', $this->rest->key)
			->where('controller', $controller)
			->get($this->config->item('rest_access_table'))
			->num_rows() > 0;
	}

}
