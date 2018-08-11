<?php

	class SRx_Input extends CI_Input
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function has($index)
		{
			if(!isset($_REQUEST[$index]))
			{
				return false;
			}

			return true;
		}

		public function is_api_request()
		{
			return false;
		}

		public function get_request($index = NULL , $default = "" , $xss_clean = FALSE)
		{
			if(!isset($_REQUEST[$index]))
			{
				return $default;
			}

			if (!empty($_POST))
			{
				return $this->post($index, $xss_clean);
			}
			else
			{
				return $this->get($index, $xss_clean);
			}
		}

		public function get_string($index, $default = "" , $xss_clean = FALSE)
		{
			if(!isset($_REQUEST[$index]))
			{
				return $default;
			}

			$var = trim($this->get_post($index , $xss_clean));

			if (is_string($var))
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_NOT_STRING, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_required_string($index, $xss_clean = FALSE)
		{
			$var = $this->get_string($index, $xss_clean);

			if ($var != '')
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_REQUIRED, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_integer($index, $default = 0 , $xss_clean = FALSE)
		{
			if(!isset($_REQUEST[$index]))
			{
				return $default;
			}

			$var = trim($this->get_post($index, $xss_clean));

			if (is_integer((int) $var))
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_NOT_INTEGER, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_required_integer($index, $xss_clean = FALSE)
		{
			$var = $this->get_integer($index, $xss_clean);

			if ($var != '')
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_REQUIRED, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_boolean($index, $default = false , $xss_clean = FALSE)
		{
			if(!isset($_REQUEST[$index]))
			{
				return $default;
			}

			$var = $this->get_post($index, $xss_clean);

			if ($var == 'true' || $var == '1')
			{
				return true;
			}
			else if ($var == 'false' || $var == '0')
			{
				return false;
			}
			else if (is_bool((bool) $var))
			{
				return (bool)$var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_NOT_INTEGER, ExceptionHandler::$COMMON ,array('key' => $index));
			}
		}

		public function get_uuid($index, $xss_clean = FALSE)
		{
			$var = $this->get_string($index, $xss_clean);

			if ($var == '')
			{
				return $var;
			}
			else if (strlen($var) == '36')
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_NOT_ID, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_required_uuid($index, $xss_clean = FALSE)
		{
			$var = $this->get_uuid($index, $xss_clean);

			if ($var != '')
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_REQUIRED, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_public_id($index, $xss_clean = FALSE)
		{
			$var = $this->get_string($index, $xss_clean);

			if ($var == '')
			{
				return $var;
			}
			else if (preg_match('/^[a-zA-Z0-9]+([a-zA-Z0-9\-\.\_]*[a-zA-Z0-9]+)?$/i', $var))
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_NOT_PUBLIC_ID, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_required_public_id($index, $xss_clean = FALSE)
		{
			$var = $this->get_string($index, $xss_clean);

			if (preg_match('/^[a-zA-Z0-9]+([a-zA-Z0-9\-\.\_]*[a-zA-Z0-9]+)?$/i', $var))
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_REQUIRED, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}

		public function get_array($index, $default = array() , $xss_clean = FALSE)
		{
			if(!isset($_REQUEST[$index]))
			{
				return $default;
			}

			$var = $this->get_post($index , $xss_clean);

			if (is_array($var))
			{
				return $var;
			}
			else
			{
				throw new RequestException(RequestException::$EX_CODE_NOT_ARRAY, ExceptionHandler::$COMMON, array('key' => $index));
			}
		}
	}
