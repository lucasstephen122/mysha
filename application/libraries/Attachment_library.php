<?php

    class Attachment_library
    {
        private $ci;
        public function __construct()
        {
            $this->ci = &get_instance();
        }

        function get_name($attachment_id)
        {
            $attachment_service = Factory::get_service('attachment_service');
            if($attachment_id)
            {
                $attachment = $attachment_service->get_attachment($attachment_id);
                return $attachment['name'];
            }
            else 
            {
                return "";
            }
        }
        
        function upload($from_path , $module , $attachment)
        {
            $path = $module.'/'.$attachment['attachment_id'];
            
            Logger::log('file.upload' , 'Checking path..');
            if(!file_exists($this->ci->config->item('files_dir').'/'.$path))
                mkdir($this->ci->config->item('files_dir').'/'.$path, 0777, true);
            
            Logger::log('file.upload' , 'Creating file at '.$this->ci->config->item('files_dir').$path.'/file');
            $fp = fopen($this->ci->config->item('files_dir').$path.'/file', 'w');
            Logger::log('file.upload' , 'Reading file at '.$from_path);
            Logger::log('file.upload' , 'File Exists '.file_exists($from_path));

            fwrite($fp, file_get_contents($from_path));            
            fclose($fp);
            
            return $path;
        }

        function write_path($path)
        {
            if(!file_exists($path))
                mkdir($path, 0777, true);
        }

        function write_file($path , $name , $content)
        {
            if(!file_exists($path))
                mkdir($path, 0777, true);
            
            $fp = fopen($path.'/'.$name, 'w');
            fwrite($fp, $content);            
            fclose($fp);
        }

        function write_resource($resource , $module , $attachment)
        {
            $path = $module.'/'.$attachment['attachment_id'];
            
            if(!file_exists($this->ci->config->item('files_dir').'/'.$path))
                mkdir($this->ci->config->item('files_dir').'/'.$path, 0777, true);
            
            imagepng($resource , $this->ci->config->item('files_dir').'/'.$path.'/file');
            
            return $path;
        }

        function wait_untill_file_exists($path , $loop = 20)
        {
            $count = 0;
            while(!(file_exists($path) && filesize($path) > 0))
            {
                if($count >= $loop)
                {
                    break;
                }
                sleep(3);
            }
            sleep(3);
            chmod($path, 0777);
        }

        function delete($attachment)
        {   
            $path = $this->ci->config->item('files_dir').$attachment['path'].'/file';
            unlink($path);     
            
            $path = $this->ci->config->item('files_dir').$attachment['path'];
            rmdir($path);
        }

        function download($attachment)
        {        
            $path = $this->ci->config->item('files_dir').'/'.$attachment['path'].'/file';

            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"".$attachment['name']."\"");
            header("Content-length: ".(string)(filesize($path)));
            
            header("Expires: Wed, 29 May 2033 06:50:58 GMT");
            header("Cache-Control: max-age=29030400");
            header("Etag: ".$attachment['attachment_id']);
            header('Pragma: cache');
            
            // header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
            // header("Cache-Control: no-cache, must-revalidate");
            // header("Pragma: no-cache");  
            echo file_get_contents($path);
            exit;
        }

        function download_file($name , $content)
        {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"".$name."\"");
            header("Content-length: ".(string)(strlen($content)));
            echo $content;
            exit;
        }

        function render($attachment)
        {
            $path = $this->ci->config->item('files_dir').'/'.$attachment['path'].'/file';
            header("Content-type: " . $this->get_mime_type($attachment['name']));
            header("Content-Disposition: inline; filename=\"".$attachment['name']."\"");
            header("Content-length: ".(string)(filesize($path)));
            
            header("Expires: Wed, 29 May 2033 06:50:58 GMT");
            header("Cache-Control: max-age=29030400");
            header("Etag: ".$attachment['attachment_id']);
            header('Pragma: cache');

            // header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
            // header("Cache-Control: no-cache, must-revalidate");
            // header("Pragma: no-cache");  
            echo file_get_contents($path);
            exit;
        }
        
        function render_thumb($attachment , $width , $height , $trim = true)
        {
            $path = $this->ci->config->item('files_dir').'/'.$attachment['path'].'/file_'.$width.'_'.$height;

            if(true || !file_exists($path))
            {
                $this->ci->util->resize_image($this->ci->config->item('files_dir').'/'.$attachment['path'].'/file' , $path , $width , $height , $trim);
            }

            header("Content-type: " . $this->get_mime_type($attachment['name']));
            header("Content-Disposition: inline; filename=\"".$attachment['name']."\"");
            header("Content-length: ".(string)(filesize($path)));
            header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
            /*
            header("Pragma: no-cache");  
            header("Expires: Wed, 29 May 2033 06:50:58 GMT");
            header("Cache-Control: no-cache, must-revalidate");
            /**/
            
            header('Pragma: public');
            header('Cache-Control: max-age=86400');
            header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

            echo file_get_contents($path);
            exit;
        }


        function crop_attachment($attachment , $x , $y , $w , $h , $width , $height)
        {
            $path = $this->ci->config->item('files_dir').'/'.$attachment['path'].'/file';
            $this->ci->util->crop_image($path , $path , $x , $y , $w , $h , $width , $height);
            return $attachment;
        }

        function render_url($attachment_id , $size = "" , $trim = "")
        {
            if($attachment_id != "")
            {
                $url = base_url().'common/attachment/render/'.$attachment_id;
                
                if($size)
                {
                    $url .= '/'.$size;
                }

                if($trim)
                {
                    $url .= '/'.$trim;
                }

                return $url;
            }
            else 
                return "";
        }
        
        function download_url($attachment_id)
        {
        	if($attachment_id != "")
                return base_url().'common/attachment/download/'.$attachment_id;
            else 
                return "";
        }

        function attachment_path($attachment , $download = false)
        {
            $path = $this->ci->config->item('files_dir').$attachment['path'].'/file';

            if($download && $this->ci->config->item('files_dir') != $this->ci->config->item('disks_dir'))
            {
                $this->write_file($this->ci->config->item('disks_dir').$attachment['path'] , 'file' , file_get_contents($path));
                $path = $this->ci->config->item('disks_dir').$attachment['path'].'/file';
            }

            return $path;
        }

        function copy_path($path_from , $name_from , $path_to , $name_to)
        {
            Logger::log('file.copy' , 'Path from : '.$path_from);
            Logger::log('file.copy' , 'Name from : '.$name_from);
            Logger::log('file.copy' , 'Path to : '.$path_to);
            Logger::log('file.copy' , 'Name to : '.$name_to);

            $from_path = $this->ci->config->item('files_dir').$path_from.'/'.$name_from;
            Logger::log('file.copy' , 'From path : '.$from_path);

            $this->write_file($this->ci->config->item('disks_dir').$path_to , $name_to , file_get_contents($from_path));
            $to_path = $this->ci->config->item('disks_dir').$path_to.'/'.$name_to;

            Logger::log('file.copy' , 'To path : '.$to_path);

            return $to_path;
        }
        
        function get_mime_type($file)
        {
            $mime_types = array
            (
                "pdf"=>"application/pdf",
                "exe"=>"application/octet-stream",
                "zip"=>"application/zip",
                "docx"=>"application/msword",
                "doc"=>"application/msword",
                "xls"=>"application/vnd.ms-excel",
                "ppt"=>"application/vnd.ms-powerpoint",
                "gif"=>"image/gif",
                "png"=>"image/png",
                "jpeg"=>"image/jpg",
                "jpg"=>"image/jpg",
                "mp3"=>"audio/mpeg",
                "wav"=>"audio/x-wav",
                "mpeg"=>"video/mpeg",
                "mpg"=>"video/mpeg",
                "mpe"=>"video/mpeg",
                "mov"=>"video/quicktime",
                "avi"=>"video/x-msvideo",
                "3gp"=>"video/3gpp",
                "css"=>"text/css",
                "jsc"=>"application/javascript",
                "js"=>"application/javascript",
                "php"=>"text/html",
                "htm"=>"text/html",
                "html"=>"text/html"
            );

            $parts = explode('.',$file);
            $extension = end($parts);
            $extension = strtolower($extension);

            return $mime_types[$extension];
        }
    }