<?php 
	
	class Date_library
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
		}

		public function now()
		{
			return (int) (microtime(true));
		}

		public function convert_to_utc($date_time)
		{
			$user = $this->ci->user_session->get_user();
			$timezone = $user['data']['timezone'];
			
			$date_time = new DateTime($date_time , new DateTimeZone($timezone));
			$date_time->setTimeZone(new DateTimeZone('UTC'));
			$date_time =  $date_time->format('Y-m-d H:i:s');

			return $date_time;
		}

		public function format_date($date_time , $format = "")
        {
            $date_time = new DateTime($date_time , new DateTimeZone('UTC'));
            return $date_time->format($format);
        }

		public function add_interval($date_time , $interval , $lead = 1)
		{
			$date_time = new DateTime($date_time , new DateTimeZone('UTC'));
			$date_time = $this->add_date_time_interval($date_time , $interval , $lead);
			return $date_time->format('Y-m-d H:i:s');
		}

		public function diff_date($date_time_start , $date_time_end)
		{
			$date_time_start = new DateTime($date_time_start , new DateTimeZone('UTC'));
			$date_time_end = new DateTime($date_time_end , new DateTimeZone('UTC'));
			$diff = $date_time_start->diff($date_time_end);

			return $diff;
		}

		public function add_date_time_interval($date_time , $interval , $lead = 1)
		{
			switch ($interval) 
			{
				case Interval::$SECOND:
					$interval_str = 'PT'.$lead.'S';
					break;

				case Interval::$MINUTE:
					$interval_str = 'PT'.$lead.'M';
					break;

				case Interval::$HOUR:
					$interval_str = 'PT'.$lead.'H';
					break;

				case Interval::$DAY:
					$interval_str = 'P'.$lead.'D';
					break;	

				case Interval::$WEEK:
					$interval_str = 'P'.$lead.'W';
					break;

				case Interval::$MONTH:
					$interval_str = 'P'.$lead.'M';
					break;	
				
				case Interval::$YEAR:
					$interval_str = 'P'.$lead.'Y';
					break;
				
				default:
					$interval_str = 'P0D';
					break;
			}

			$date_time->add(new DateInterval($interval_str));
			return $date_time;
		}

		public function date_time_to_timestamp($date_time)
		{
			return strtotime($date_time->format("Y-m-d H:i:s"));
		}

		public function timestamp_to_date_time($timestamp)
		{
			return new DateTime(gmdate('Y-m-d H:i:s' , $timestamp) , new DateTimeZone('UTC'));
		}

		public function timestamp_to_string($timestamp)
		{
			return gmdate('Y-m-d H:i:s' , $timestamp);
		}

		public function get_next_midnight()
		{
			$next_midnight = gmmktime(0, 0, 0, gmdate('n'), gmdate('j') + 1);
			return $next_midnight;
		}
	}