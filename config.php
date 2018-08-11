<?php
global $config;

// $config['base_url'] = 'http://shaghaf.kkf.org.sa/v2/';
$config['base_url'] = 'http://localhost/v2/';
$config['environment'] = 'development';
$config['language']	= 'english';

$config['root_dir'] = dirname(__FILE__);
$config['data_dir'] = dirname(__FILE__).'/data/';
$config['disks_dir'] = dirname(__FILE__).'/data/files/';
$config['files_dir'] = dirname(__FILE__).'/data/files/';


$config['email'] = array
(
	'smtp_host' => 'smtp.mailgun.org',
	'smtp_port' => '587',
	'smtp_user' => 'notification@kkf.org.sa',
	'smtp_pass' => 'not@123',
	// 'email_from' => 'notification@kkf.org.sa',
	'email_from' => 'ehussain.travel@gmail.com',
	'email_from_name' => 'KKFoundation'
);

$config['database'] = array
(
	'host_name' => 'localhost',
	// 'user_name' => 'kkforgsa_shaghaf_v2',
	'user_name' => 'root',
	// 'password' => 'shaghaf_v2',
	'password' => '',
	'port' => 3306,
	'database_name' => 'kkforgsa_shaghaf_v2'
);

$config['mysql'] = array
(
	'hostname' => 'localhost',
	// 'username' => 'kkforgsa_shaghaf_v2',
	'username' => 'root',
	// 'password' => 'shaghaf_v2',
	'password' => '',
	'port' => 3306,
	'database' => 'kkforgsa_shaghaf_v2'
);

$config['admin_emails'] = ['ehussain.in@gmail.com'];

$config['log'] = array
(
	'type' => 'file',
	'path' => $config['data_dir'].'logs/',
);