<?php

	function get_display_name($user)
	{
		return $user['full_name'];
	}

	function get_user_photo_url($photo_id)
	{
		$ci = &get_instance();
		return $photo_id != "" ? $ci->attachment_library->render_url($photo_id) : base_url().'assets/admin/images/default_photo.jpg';
	}

	function get_status_text($status)
	{
		switch((int)$status)
		{
			case 10 : return 'draft';
			case 20 : return 'submitted';
			case 30 : return 'approved';
			case 40 : return 'rejected';
			case 50 : return 'published';
			case 60 : return 'blocked';
			case 70 : return 'active';
		}
	}

	function get_status_class($status)
	{
		switch((int)$status)
		{
			case 10 : return 'default';
			case 20 : return 'primary';
			case 30 : return 'success';
			case 40 : return 'danger';
			case 50 : return 'info';
			case 60 : return 'inverse';
			case 70 : return 'success';
		}
	}

	function parse_date($date)
	{
		$parts = explode('/' , $date);
		return $parts[2].'-'.$parts[0].'-'.$parts[1];
	}

	function prepare_date($date)
	{
		$date = new DateTime($date);
  		return date_format($date, 'm/d/Y');
	}

	function format_date($date)
	{
		$date = new DateTime($date);
  		return date_format($date, 'Y/m/d');
	}

	function format_time($date)
	{
		$date = new DateTime($date);
  		return date_format($date, 'H:i a');
	}

	function format_date_time($date)
	{
		$date = new DateTime($date);
  		return date_format($date, 'Y/m/d H:i a');
	}

	function get_address_string($address , $empty_text = "")
	{
		$address_line = '';
		if($address['address1'])
		{
			$address_line .= $address['address1'].', ';
		}

		if($address['address2'])
		{
			$address_line .= $address['address2'].',<br/>';
		}

		if($address['city'])
		{
			$address_line .= $address['city'].', ';
		}

		if($address['state'])
		{
			$address_line .= $address['state'].', ';
		}

		if($address['country'])
		{
			// $address_line .= $address['country'].', ';
		}

		if($address['zipcode'])
		{
			$address_line .= $address['zipcode'];
		}

		return $address_line ? $address_line : $empty_text;
	}

	function get_address_line($address)
	{
		$address_line = '';
		if($address['address1'])
		{
			$address_line .= $address['address1'].', ';
		}

		if($address['address2'])
		{
			$address_line .= $address['address2'].', ';
		}

		if($address['city'])
		{
			$address_line .= $address['city'].', ';
		}

		if($address['state'])
		{
			$address_line .= $address['state'].', ';
		}

		if($address['country'])
		{
			$address_line .= $address['country'].', ';
		}

		if($address['zipcode'])
		{
			$address_line .= $address['zipcode'].'.';
		}

		return $address_line;
	}

	function get_address_line1($address)
	{
		$address_line = '';
		if($address['address1'])
		{
			$address_line .= $address['address1'].', ';
		}

		if($address['address2'])
		{
			$address_line .= $address['address2'].', ';
		}

		return substr($address_line, 0, -2);
	}

    function is_module($module)
    {
        if(get_module() == $module)
        {
            return true;
        }

        return false;
    }

	function get_module()
	{
		global $config;
		return $config['domains'][$_SERVER['HTTP_HOST']];
	}

	function get_module_url($module)
	{
		global $config;
		$domains_map = $config['domains_map'];
		return 'http://'.$domains_map[strtoupper($module)];
	}