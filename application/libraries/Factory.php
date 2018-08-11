<?php 

	class Factory
	{
		private static $service_instances = array();
		
		public static function get_service($service)
		{
			if(key_exists($service, self::$service_instances))
			{
				return self::$service_instances[$service];
			}
			
			$service_parts = explode('/', $service);
			$class = ucfirst(array_pop($service_parts));

			$service_path = implode('/', $service_parts).'/'.$class;
			include_once dirname(__FILE__).'/../services/'.$service_path.'.php';

			$instance = new $class();
			self::$service_instances[$service] = $instance;
			return $instance;
		}				
	}