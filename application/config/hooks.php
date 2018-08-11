<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['pre_controller'][] = array
(
		'class'    => 'App_initializer',
		'function' => 'init_session',
		'filename' => 'app_initializer.php',
		'filepath' => 'hooks',
		'params'   => array()
);

/*
$hook['pre_controller'][] = array
(
		'class'    => 'App_initializer',
		'function' => 'init_file_system',
		'filename' => 'app_initializer.php',
		'filepath' => 'hooks',
		'params'   => array()
);
/**/

$hook['post_controller_constructor'][] = array
(
		'class'    => 'App_initializer',
		'function' => 'init_exception',
		'filename' => 'app_initializer.php',
		'filepath' => 'hooks',
		'params'   => array()
);

$hook['post_controller_constructor'][] = array
(
		'class'    => 'App_initializer',
		'function' => 'init_cookie',
		'filename' => 'app_initializer.php',
		'filepath' => 'hooks',
		'params'   => array()
);

$hook['post_controller_constructor'][] = array
(
		'class'    => 'App_initializer',
		'function' => 'init_app',
		'filename' => 'app_initializer.php',
		'filepath' => 'hooks',
		'params'   => array()
);

$hook['post_controller_constructor'][] = array
(
		'class'    => 'App_initializer',
		'function' => 'init_brand',
		'filename' => 'app_initializer.php',
		'filepath' => 'hooks',
		'params'   => array()
);
