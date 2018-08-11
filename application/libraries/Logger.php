<?php

    class Logger
    {
        private static $ci;
        private static $config;

        private static $db;
        private static $fh;
        private static $space;

        private static function init()
        {
            self::$ci = &get_instance();
            self::$config = self::$ci->config->item('log');

            if(self::$config['type'] == 'file' && self::$fh == null)
            {
                self::$fh = array();
            }

            if(self::$config['type'] == 'aws' && self::$fh == null)
            {
                self::$fh = array();
            }

            if(self::$config['type'] == 'mongo' && self::$db == null)
            {
                self::$db = self::$ci->mongodb->get_instance(self::$config);
            }
        }

        public static function log_space_start($process)
        {
            $space = isset(self::$space[$process]) ? self::$space[$process] : 0;
            self::$space[$process] = $space + 1;
        }

        public static function log_space_end($process)
        {
            $space = isset(self::$space[$process]) ? self::$space[$process] : 0;
            self::$space[$process] = $space - 1;
        }

        public static function log($process , $message)
        {
            self::init();

            if(self::$config['type'] == 'file')
            {
                self::log_file($process , $message);
            }
            else if(self::$config['type'] == 'aws')
            {
                self::log_aws($process , $message);
            }
            else if(self::$config['type'] == 'mongo')
            {
                self::log_mongo($process , $message);
            }
            else if(self::$config['type'] == 'papertrail')
            {
                self::log_papertrail($process , $message);
            }
        }

        public static function flush()
        {
            self::init();

            if(self::$config['type'] == 'file')
            {
                self::flush_file();
            }
            else if(self::$config['type'] == 'aws')
            {
                self::flush_aws();
            }
            else if(self::$config['type'] == 'mongo')
            {
                self::flush_mongo();
            }
            else if(self::$config['type'] == 'papertrail')
            {
                self::flush_papertrail();
            }
        }

        public static function log_file($process , $message)
        {
            $space = isset(self::$space[$process]) ? self::$space[$process] : 0;

            $spaces = "";
            for($i = 0 ; $i < $space ; $i ++)
                $spaces = "\t\t".$spaces;

            if(is_object($message))
            {
                ob_start();
                var_dump($message);
                $content = ob_get_contents();
                ob_end_clean();
            }
            else if(is_array($message))
            {
                $content = print_r($message, true);
                $content = $spaces.str_ireplace(array("\n"),array("\n".$spaces) , $content);
            }
            else
            {
                $content = $spaces.$message;
            }

            $content = date('Y-m-d H:i:s'). ' --- ' . $content . "\n";

            $file = isset(self::$fh[$process]) ? self::$fh[$process] : false;
            if(empty($file))
            {
                $file = fopen(self::$config['path'].$process.'.txt',"a");
                self::$fh[$process] = $file;
            }

            $samplifyrx_file = isset(self::$fh['samplifyrx']) ? self::$fh['samplifyrx'] : false;
            if(empty($samplifyrx_file))
            {
                $samplifyrx_file = fopen(self::$config['path'].'samplifyrx.txt',"a");
                self::$fh['samplifyrx'] = $samplifyrx_file;
            }

            fwrite($file, $content);
            fwrite($samplifyrx_file, $content);
        }

        public static function flush_file()
        {
            foreach (self::$fh as $process => $file)
            {
                fclose($file);
                unset(self::$fh[$process]);
            }
        }

        public static function log_aws($process , $message)
        {
            if(is_object($message))
            {
                ob_start();
                var_dump($message);
                $content = ob_get_contents();
                ob_end_clean();
            }
            else if(is_array($message))
            {
                $content = print_r($message, true);
            }
            else
            {
                $content = $message;
            }
            $content = date('Y-m-d H:i:s'). ' --- ' . $content . "\n";

            $file = isset(self::$fh[$process]) ? self::$fh[$process] : false;
            if(empty($file))
            {
                $file = fopen(self::$config['aws_path'].$process.'.txt',"a");
                self::$fh[$process] = $file;
            }

            $samplifyrx_file = isset(self::$fh['samplifyrx']) ? self::$fh['samplifyrx'] : false;
            if(empty($samplifyrx_file))
            {
                $samplifyrx_file = fopen(self::$config['aws_path'].'samplifyrx.txt',"a");
                self::$fh['samplifyrx'] = $samplifyrx_file;
            }

            fwrite($file, $content);
            fwrite($samplifyrx_file, $content);
        }

        public static function flush_aws()
        {
            foreach (self::$fh as $file)
            {
                fclose($file);
            }
        }

        public static function log_mongo($process , $message)
        {
            self::init();
            if(is_object($message))
            {
                ob_start();
                var_dump($message);
                $content = ob_get_contents();
                ob_end_clean();
            }
            else if(is_array($message))
            {
                $content = print_r($message , true);
            }
            else
            {
                $content = $message;
            }

            $log = array();
            $log['process'] = $process;
            $log['date'] = gmdate('Y-m-d H:i:s');
            $log['content'] = $content;

            $collection = 'log_'.$process;
            self::$db->insert($collection , $log);

            $collection = 'log_samplifyrx';
            self::$db->insert($collection , $log);
        }

        public static function flush_mongo()
        {

        }

        public static function log_papertrail($process , $message)
        {
            if(is_array($message))
            {
                $content = json_encode($message);
            }
            else
            {
                $content = $message;
            }
            $content = $content;

            // Set the format
            $output = "%channel%.%level_name%: %message%";
            $formatter = new Monolog\Formatter\LineFormatter($output);

            // Setup the logger
            $logger = new Monolog\Logger($process);
            $syslogHandler = new Monolog\Handler\SyslogUdpHandler(self::$config['papertrail']['host'], self::$config['papertrail']['port']);
            $syslogHandler->setFormatter($formatter);
            $logger->pushHandler($syslogHandler);

            // Use the new logger
            $logger->addInfo($content);
        }

        public static function flush_papertrail()
        {

        }
    }
