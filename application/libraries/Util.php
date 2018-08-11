<?php

    class Util
    {
        private $ci;
        public function __construct()
        {
            $this->ci = &get_instance();
        }
        
        public function check_browser()
        {
        	$this->ci->load->library('user_agent');
        	
        	$isValid = true;
        	if($this->ci->agent->is_browser())
        	{
	        	$browser = $this->ci->agent->browser();
	        	$version = $this->ci->agent->version();
	        	
	        	switch ($browser)
	        	{
	        		case "Firefox":
	        			break;
	        		case "Internet Explorer";
	        			if($version != "7.0" && $version != "8.0")
	        				$isValid = false;
	        			break;
	        		case "Chrome" :	        			
	        			break;
	        	}
        	}
        	else if($this->ci->agent->agent_string() == "cURL")
        	{
        		$isValid = true;
        	}
        	else
        	{
        		$isValid = false;
        	}

        	if(!$isValid)
        	{
        		redirect('common/error/error_browser');
        	}
        }
        
        public function get_map($key, $array)
        {
        	$map = array();
        	foreach($array as $value)	
        	{
        		$map[$value[$key]] = $value;
        	}
        	return $map;
        }

        function get_ip() 
        {
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            
            if($ipaddress == '127.0.0.1')
                $ipaddress = '123.201.80.38';

            return $ipaddress;
        }

        public function parse($string , $parse)
        {
            foreach ($parse as $key => $value) 
            {
                $string = str_replace('{'.$key.'}', $value, $string);
            }
            return $string;
        }

        public function get_parse_keys($parse)
        {
            $final_parse = array();
            foreach ($parse as $key => $value) 
            {
                if(is_array($value))
                {
                    foreach ($value as $value_key => $value_value) 
                    {
                        $final_parse[$key.'_'.$value_key] = $value_value;
                    }
                }
                else 
                {
                    $final_parse[$key] = $value;
                }
            }

            return $final_parse;
        }

        public function execute_command($command , $outputFile = '/dev/null')
        {
            if (substr(php_uname(), 0, 7) == "Windows")
            {
                $p = popen
                (
                    "start /B ". $command, "r"
                );

                $contents = '';
                while (!feof($p)) {
                    $contents .= fread($p, 8192);
                }
                
                pclose($p);

                return $contents;
            }
            else 
            {
                shell_exec(sprintf
                (
                    '%s > %s 2>&1 & echo $!',
                    $command,
                    $outputFile
                ));
            }
        }

        public function resize_image($image_path , $thumb_path , $w , $h , $trim = true)
        {
            list($width, $height) = getimagesize($image_path);
            $ratio = $width/$height;
            
            $owidth = $width;
            $oheight = $height;

            $r = $w/$h;

            $scale_x = $w/$width;
            $scale_y = $h/$height;

            if($trim)
            {
                // calculating the part of the image to use for thumbnail
                if ($scale_x <= $scale_y) 
                {
                    $height = $width / $r;
                    $x = 0;
                    $y = ($oheight - $height) / 2;                    
                } 
                else 
                {
                    $width = $r * $height; 
                    $x = ($owidth - $width) / 2;                    
                    $y = 0;
                }
            }
            else 
            {
                if ($scale_x > $scale_y) 
                {
                    $height = $width / $r;
                    $x = 0;
                    $y = ($oheight - $height) / 2;                    
                } 
                else 
                {
                    $width = $r * $height; 
                    $x = ($owidth - $width) / 2;                    
                    $y = 0;
                }
            }

            /*
            // calculating the part of the image to use for thumbnail
            if ($scale_x > $scale_y) 
            {
                $height = $width / $r;
                $x = 0;
                $y = ($oheight - $height) / 2;                    
            } 
            else 
            {
                $width = $r * $height; 
                $x = ($owidth - $width) / 2;                    
                $y = 0;
            }
            /**/

            $type = exif_imagetype($image_path);

            if($type == IMAGETYPE_PNG)
            {
                //saving the image into memory (for manipulation with GD Library)
                $image = imagecreatefrompng($image_path);

                // copying the part into thumbnail
                $thumb = imagecreatetruecolor($w, $h);
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                imagecopyresampled($thumb, $image, 0, 0, $x, $y, $w, $h, $width, $height);

                //final output
                imagepng($thumb , $thumb_path , 7);
            }
            else
            {
                //saving the image into memory (for manipulation with GD Library)
                $image = imagecreatefromjpeg($image_path);

                // copying the part into thumbnail
                $thumb = imagecreatetruecolor($w, $h);
                imagecopyresampled($thumb, $image, 0, 0, $x, $y, $w, $h, $width, $height);

                //final output
                imagejpeg($thumb , $thumb_path , 75);
            }
            
            return $thumb_path;
        }

        public function crop_image($image_path , $thumb_path , $x , $y , $w , $h , $scaled_width , $scaled_height)
        {
            list($width, $height) = getimagesize($image_path);

            Logger::log('image.crop' , 'Width : '.$width);
            Logger::log('image.crop' , 'Height : '.$height);
            Logger::log('image.crop' , 'Path : '.$image_path);
            Logger::log('image.crop' , $x.':'.$y.':'.$w.':'.$h);
            Logger::log('image.crop' , 'Scaled Width : '.$scaled_width);
            Logger::log('image.crop' , 'Scaled Height : '.$scaled_height);

            $x = $x * ($width / $scaled_width);
            $y = $y * ($height / $scaled_height);
            $w = $w * ($width / $scaled_width);
            $h = $h * ($height / $scaled_height);

            Logger::log('image.crop' , $x.':'.$y.':'.$w.':'.$h);
            
            $type = exif_imagetype($image_path);

            if($type == IMAGETYPE_PNG)
            {
                Logger::log('image.crop' , 'Type : PNG');
                //saving the image into memory (for manipulation with GD Library)
                $image = imagecreatefrompng($image_path);

                // copying the part into thumbnail
                $thumb = imagecreatetruecolor($w, $h);
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                imagecopyresampled($thumb, $image, 0, 0, $x, $y, $w, $h, $w, $h);

                //final output
                imagepng($thumb , $thumb_path , 7);
            }
            else
            {
                Logger::log('image.crop' , 'Type : JPG');
                //saving the image into memory (for manipulation with GD Library)
                $image = imagecreatefromjpeg($image_path);

                // copying the part into thumbnail
                $thumb = imagecreatetruecolor($w, $h);
                imagecopyresampled($thumb, $image, 0, 0, $x, $y, $w, $h, $w, $h);

                //final output
                imagejpeg($thumb , $thumb_path , 90);
            }

            Logger::log('image.crop' , 'Thumb : '.$thumb_path);
            
            return $thumb_path;
        }
    }