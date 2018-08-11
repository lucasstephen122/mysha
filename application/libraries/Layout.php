<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Layout
    {

    	var $obj;
        var $layout;

        function __construct($layout = "default")
        {
            $this->ci = &get_instance();
            $this->set_layout($layout);
        }

        function set_layout($layout)
        {
            $this->layout = $layout;
        }

        function view($view, $data=null, $return=false)
        {
            $data['base_url'] = $this->ci->config->item('base_url');
            $data['assets_url'] = $this->ci->config->item('base_url').'assets/';
            $data['session_user'] = $this->ci->user_session->get_user();
            $data['session_user_id'] = $this->ci->user_session->get_user_id();
            
            $data['layout_content'] = $this->ci->load->view($view, $data, true);
            
            if ($return)
            {
            	if($this->layout)
                	return $this->ci->load->view($this->layout, $data, true);
                else
                	return $data['layout_content'];
            }
            else
            {
            	if($this->layout)
                	$this->ci->load->view($this->layout, $data, false);
                else 
                	echo $data['layout_content'];
            }
        }

    }
