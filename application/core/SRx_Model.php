<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SRx_Model extends CI_Model 
{
	public $mysql_connector;
	public $mongo_connector;
	public $connector;

	public function __construct()
	{
		parent::__construct();
		$this->connect();
	}

	public function connect()
	{
		$this->load->library('MySQLConnector');
		if(!$this->mysql_connector)
		{
			global $config;
			$this->mysql_connector = MySQLConnector::get_instance($config['mysql']);
		}

		/*
		$this->load->library('MongoConnector');
		if(!$this->mongo_connector)
		{
			global $config;
			$this->mongo_connector = MongoConnector::get_instance($config['mongo']);
		}		
		/**/

		$this->connector = $this->mysql_connector;
	}
}
