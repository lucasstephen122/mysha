<?php
	
	class Schedule_library
	{
		private $db;
		private $ci;
		private static $tbl_schedules = 'srx_schedules';
		
		public static $PENDING = 10;
		public static $ACTIVE = 20;
		public static $COMPLETE = 30;
		public static $ERROR = 40;
		
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->db = new db();
		}
		
		public function run($since)
		{
			Logger::log('schedule', ' - Running Scheduler - ');
			Logger::log('schedule' , $since);
				
			$schedules = $this->get_schedules($since);
			foreach($schedules as $schedule)
			{				
				$this->execute($schedule);
			}
		}
		
		public function run_schedule($schedule_id)
		{
			Logger::log('schedule', ' - Running Process - ');
			Logger::log('schedule' , $schedule_id);
			
			$schedule = $this->get_schedule($schedule_id);
			$this->execute($schedule);
		}
		
		public function execute($schedule)
		{
			Logger::log('schedule', ' - Process Details - ');
			Logger::log('schedule' , $schedule);

			$schedule_id = $schedule['schedule_id'];
			$this->mark_schedule($schedule_id, self::$ACTIVE);

			Logger::log('schedule', ' - Started - ');
			
			$parameters = unserialize($schedule['parameters']);
			$service = $schedule['service'];
			$method = $schedule['method'];

			$service = Factory::get_service($service);
			$response = call_user_func_array(array($service, $method), $parameters);

			Logger::log('schedule', $response);

			if($schedule['interval'] != Interval::$NONE)
			{
				Logger::log('schedule', 'Calculating Reschedule Date');
				$schedule['scheduled_on'] = $this->ci->date_library->add_interval($schedule['scheduled_on'] , $schedule['interval'] , $schedule['frequency']);
				Logger::log('schedule', 'Rescheduled On : '.$schedule['scheduled_on']);

				if($schedule['scheduled_on'] < now())
				{
					$schedule['scheduled_on'] = $this->ci->date_library->add_interval(now() , $schedule['interval'] , $schedule['frequency']);
				}

				$this->mark_schedule($schedule_id, self::$PENDING , $response , $schedule['scheduled_on']);	
			}
			else 
			{
				$this->mark_schedule($schedule_id, self::$COMPLETE , $response);	
			}

			Logger::log('schedule', ' - Finished - ');
		}

		public function add($service , $method , $parameters , $scheduled_on , $interval = '' , $frequency = 0)
		{
			global $config;
			
			$schedule = array();
			$schedule['schedule_id'] = uuid();
			$schedule['service'] = $service;
			$schedule['method'] = $method;
			$schedule['parameters'] = serialize($parameters);
			$schedule['result'] = serialize(array());
			$schedule['scheduled_on'] = $scheduled_on;
			$schedule['interval'] = $interval;
			$schedule['frequency'] = $frequency;
			$schedule['status'] = self::$PENDING;
			$schedule['created_on'] = gmdate('Y-m-d H:i:s');
			$schedule['updated_on'] = gmdate('Y-m-d H:i:s');
			
			$this->db->insert(self::$tbl_schedules, $schedule);

			return $schedule['schedule_id'];
		}

		public function delete($schedule_id)
		{
			try 
			{
				$this->db->delete(self::$tbl_schedules ,array('schedule_id' => $schedule_id));	
			}
			catch (DBException $e)
			{
				
			}
		}
		
		public function get_schedule($schedule_id)
		{
			$query = "SELECT * FROM ".self::$tbl_schedules." WHERE schedule_id ='".$schedule_id."'";
			$this->db->query($query);
			return $this->db->get_row();
		}
		
		public function get_schedules($since)
		{
			$query = "SELECT * FROM ".self::$tbl_schedules." WHERE status ='".self::$PENDING."' AND scheduled_on <='".$since."'";
			$this->db->query($query);
			return $this->db->get_rows();
		}
		
		public function mark_schedule($schedule_id , $status , $result = null , $scheduled_on = null)
		{
			$schedule = array();
			$schedule['status'] = $status;
			$schedule['updated_on'] = gmdate("Y-m-d H:i:s");
			
			if($result != null)
			{
				$schedule['result'] = serialize($result);
			}

			if($scheduled_on != null)
			{
				$schedule['scheduled_on'] = $scheduled_on;
			}

			$this->db->update(self::$tbl_schedules, $schedule , array('schedule_id' => $schedule_id));			
		}
	}
	