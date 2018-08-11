<?php
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;


	class Rabbitmq_library
	{
		private $ci;
		private $connection;
		private $channel;

		public function __construct()
        {
            $this->ci = &get_instance();            
        }

        public function __destruct()
        {
        	if($this->channel)
        	{
	        	$this->channel->close();
				$this->connection->close();
			}
        }

        public function send($queue , $key , $message)
        {
        	if(!$this->channel)
        	{
	        	$rabbitmq_config = $this->ci->config->item('rabbitmq');
	            $this->connection = new AMQPConnection($rabbitmq_config['host'], $rabbitmq_config['port'], $rabbitmq_config['user_name'], $rabbitmq_config['password']);
				$this->channel = $this->connection->channel();
			}

			$this->channel->exchange_declare($queue, 'topic', false, false, false);
			$message = new AMQPMessage($message);
			$this->channel->basic_publish($message, $queue, $key);
			return true;
        }
    }   