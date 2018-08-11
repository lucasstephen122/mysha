<?php

    function lg($label , $parse = array())
    {
        $lbl =  lang($label);

        if(empty($lbl))
        {
            return '>>> '.$label.' <<<';
        }
        else
        {
            if(count($parse) > 0)
            {
                $ci = &get_instance();
                return $ci->util->parse($lbl , $parse);
            }
            else
            {
                return $lbl;
            }
        }
    }
	function l($label)
	{
		echo lg($label);
	}

    function debug($array , $exit = true)
    {
        ob_end_flush();
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        ob_start();

        if($exit)
            exit;
    }

    // reference : http://www.php.net/manual/en/function.uniqid.php#94959
    function temp_uuid()
    {
        return strtoupper('TMP_'.uuid());
    }

    function uuid()
    {
        return strtoupper(sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,

                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        ));
    }

    function now()
    {
        return gmdate('Y-m-d H:i:s');
    }

    function utf8tohtml($utf8, $encodeTags)
    {
        $result = '';
        for ($i = 0; $i < strlen($utf8); $i++)
        {
            $char = $utf8[$i];
            $ascii = ord($char);
            if ($ascii < 128)
            {
                // one-byte character
                $result .= ($encodeTags) ? htmlentities($char , ENT_QUOTES, 'UTF-8') : $char;
            }
            else if ($ascii < 192)
            {
                // non-utf8 character or not a start byte
            }
            else if ($ascii < 224)
            {
                // two-byte character
                $result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'UTF-8');
                $i++;
            }
            else if ($ascii < 240)
            {
                $result .= substr($utf8, $i, 3);
                // three-byte character
                /*
                $ascii1 = ord($utf8[$i+1]);
                $ascii2 = ord($utf8[$i+2]);
                $unicode = (15 & $ascii) * 4096 +
                    (63 & $ascii1) * 64 +
                    (63 & $ascii2);
                $result .= "&#$unicode;";
                /**/
                $i += 2;
            }
            else if ($ascii < 248)
            {
                $result .= substr($utf8, $i, 4);
                /*
                // four-byte character
                $ascii1 = ord($utf8[$i+1]);
                $ascii2 = ord($utf8[$i+2]);
                $ascii3 = ord($utf8[$i+3]);
                $unicode = (15 & $ascii) * 262144 +
                    (63 & $ascii1) * 4096 +
                    (63 & $ascii2) * 64 +
                    (63 & $ascii3);
                $result .= "&#$unicode;";
                /**/
                $i += 3;
            }
        }
        return $result;
    }

    function doFormPost($action , $params)
    {
        $formHtml = '<html><body><form method="post" name="doFormPost" id="doFormPost" action="' . $action . '">';
        foreach($params as $key => $value)
        {
            $formHtml .= '<input type="hidden" name="' . $key . '" id="' . $key . '" value="' . $value . '">';
        }
        $formHtml .= '</form></body></html>';
        echo $formHtml;
        echo "<script type='text/javascript' language='javascript'>document.forms['doFormPost'].submit();</script>";
        exit;
    }

    function doRedirect($url, $params = array())
    {
        $preparedUrl = prepareUrl($url, $params);
        redirect($preparedUrl);
    }

    function prepareUrl($url, $params = array())
    {
        $url .= strpos($url , '?') === false ? '?' : '';
        $url .= http_build_query($params);
        return $url;
    }

    function trimText($text,$count)
    {
        if(strlen($text) > $count)
        {
            $text = substr($text,0,$count-1).'...';
        }
        return $text;
    }

    function str_to_upper($string)
    {
        return mb_strtoupper($string);
    }

    function wild_compare($wild, $string)
    {
        $wild_i = 0;
        $string_i = 0;

        $wild_len = strlen($wild);
        $string_len = strlen($string);

        while ($string_i < $string_len && $wild[$wild_i] != '*')
        {
            if (($wild[$wild_i] != $string[$string_i]) && ($wild[$wild_i] != '?'))
            {
                return 0;
            }
            $wild_i++;
            $string_i++;
        }

        $mp = 0;
        $cp = 0;

        while ($string_i < $string_len)
        {
            if ($wild[$wild_i] == '*')
            {
                if (++$wild_i == $wild_len)
                {
                    return 1;
                }
                $mp = $wild_i;
                $cp = $string_i + 1;
            }
            else
            if (($wild[$wild_i] == $string[$string_i]) || ($wild[$wild_i] == '?'))
            {
                $wild_i++;
                $string_i++;
            }
            else
            {
                $wild_i = $mp;
                $string_i = $cp++;
            }
        }

        while ($wild[$wild_i] == '*')
        {
            $wild_i++;
        }

        return $wild_i == $wild_len ? 1 : 0;
    }

    function get_random()
    {
        return md5(microtime());
    }

    function json_response($response)
    {
        header('Content-type: text/json');
        echo json_encode($response);
        exit;
    }

    function is_ajax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function html_encode($str)
    {
        return html_escape($str);
    }

    function htmlbr($text)
    {
        return combineLines(nl2br($text));
    }

    function combineLines($text,$count = -1)
    {
        if($count == -1)
        {
            return preg_replace("/[\r\n]+/", " ", $text);
        }
        else
        {
            return trimText(preg_replace("/[\r\n]+/", " ", $text), $count);
        }
    }

    function getYearOptions()
    {
        $year = gmdate("Y");
        $option = '<option value="">- Year -</option>';
        for($i = $year; $i > $year - 50; $i --)
        {
            $option .= '<option value="'. $i .'">'.$i.'</option>';
        }
        return $option;
    }

    function getMonthOptions()
    {
        $months = array("Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Oct" , "Nov" , "Dec");
        $option = '<option value="">- Mon -</option>';
        for($i = 0 ; $i < count($months); $i ++)
        {
            $option .= '<option value="'. ($i + 1) .'">'.$months[$i].'</option>';
        }
        return $option;
    }

    function getMonthText($monthIndex)
    {
        $months = array("Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Oct" , "Nov" , "Dec");
        return $months[$monthIndex - 1];
    }

    function get_file_extension($fileName)
    {
        $split = explode('.', $fileName);
        return $split[count($split) - 1];
    }
    function get_file_name($fileName)
    {
        $split = explode('.', $fileName);
        return $split[0];
    }
    function get_file($fileName)
    {
        $split = explode('/', $fileName);
        return $split[count($split) - 1];
    }

    function get_request_uri()
    {
        $ci = &get_instance();
        $url = get_request_url();
        $baseUrl = $ci->config->item('base_url');
        $uri = str_replace($baseUrl, '', $url);
        return $uri;
    }

    function get_request_url()
    {
        $ci = &get_instance();
        $protocol = (isset ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
        $url =  $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    function getRequestSegments()
    {
        return explode('/' , getRequestURI());
    }

    function bytesToSize($bytes, $precision)
    {
        $kilobyte = 1024;
        $megabyte = $kilobyte * 1024;
        $gigabyte = $megabyte * 1024;
        $terabyte = $gigabyte * 1024;

        if (($bytes >= 0) && ($bytes < $kilobyte)) {
            return $bytes .' B';

        } else if (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
            return round($bytes / $kilobyte, $precision) .' KB';

        } else if (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
            return round($bytes / $megabyte, $precision) .' MB';

        } else if (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
            return round($bytes / $gigabyte, $precision) .' GB';

        } else if ($bytes >= $terabyte) {
            return round($bytes / $terabyte, $precision) .' TB';

        } else {
            return $bytes .' B';
        }
    }

    function set_error_message($message)
    {
        $ci = &get_instance();
        $ci->app_cache->put_session('error_message', $message);
    }

    function throw_error_message($message , $uri)
    {
        set_error_message($message);
        redirect($uri);
        exit;
    }

    function show_error_message()
    {
         $ci = &get_instance();
         $message = $ci->app_cache->get_session('error_message');
         $str = '';
         if ($message != '')
         {
            $str .= '<div class="alert alert-danger fade in">';
            $str .= '    <button type="button" class="close close-sm" data-dismiss="alert">';
            $str .= '        <i class="fa fa-times"></i>';
            $str .= '    </button>';
            $str .= $message;
            $str .= '</div>';
         }
         $ci->app_cache->put_session('error_message' , '');
         echo  $str;
    }

    function set_success_message($message)
    {
        $ci = &get_instance();
        $ci->app_cache->put_session('success_message', $message);
    }

    function show_success_message($message = "")
    {
        $ci = &get_instance();
        $message = $message ? $message : $ci->app_cache->get_session('success_message');
        $str = '';
        if ($message != '')
        {
            $str .= '<div class="alert alert-success">';
            $str .= '    <button type="button" class="close close-sm" data-dismiss="alert">';
            $str .= '        <i class="fa fa-times"></i>';
            $str .= '    </button>';
            $str .= $message;
            $str .= '</div>';
        }
        $ci->app_cache->put_session('success_message' , '');
        echo $str;
    }

    function set_dialog_message($message)
    {
        $ci = &get_instance();
        $ci->app_cache->put_session('dialog_success_message', $message);
    }

    function get_dialog_message()
    {
        $ci = &get_instance();
        $message =  $ci->app_cache->get_session('dialog_success_message');
        $ci->app_cache->put_session('dialog_success_message' , '');
        return $message;
    }

    function prepare_response($result, $message = '')
    {
        return array(
                'status'        =>  true,
                'error_code'    =>  '',
                'result'        =>  $result,
                'message'       =>  $message
        );
    }

    function prepare_error($result , $message = '', $errorCode = 0 , $handler = '')
    {
        return array(
                'status'        =>  false,
                'error_code'    =>  $errorCode,
                'result'        =>  $result,
                'message'       =>  $message,
                'handler'       =>  $handler
        );
    }

    global $lastRandom;
    function rand_color()
    {
        global $lastRandom;

        $color = array('color-red', 'color-blue', 'color-yellow' , 'color-green' ,'color-magento' , 'color-purple' , 'color-blue-green' );
        $randKey = mt_rand(0, (count($color) - 1));
        $random = $color[$randKey];
        if($random == $lastRandom)
        {
            return rand_color();
        }
        else
        {
            $lastRandom = $random;
            return $random;
        }
    }

    if(!function_exists('sanitize_name'))
    {
        function sanitize_name($title , $index = 0 , $fallback_title = '' , $sep = '.')
        {
            $title = remove_accents($title);

            $title = strip_tags($title);
            // Preserve escaped octets.
            $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
            // Remove percent signs that are not part of an octet.
            $title = str_replace('%', '', $title);
            // Restore octets.
            $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

            if (seems_utf8($title)) {
                if (function_exists('mb_strtolower')) {
                    $title = mb_strtolower($title, 'UTF-8');
                }
                $title = utf8_uri_encode($title, 200);
            }

            $title = strtolower($title);
            $title = preg_replace('/&.+?;/', '', $title); // kill entities
            $title = str_replace('.', $sep, $title);
            $title = str_replace('-', $sep, $title);

            // Convert nbsp, ndash and mdash to hyphens
            $title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), $sep , $title );

            // Strip these characters entirely
            $title = str_replace( array(
                        // iexcl and iquest
                        '%c2%a1', '%c2%bf',
                        // angle quotes
                        '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
                        // curly quotes
                        '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
                        '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
                        // copy, reg, deg, hellip and trade
                        '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
                        // grave accent, acute accent, macron, caron
                        '%cc%80', '%cc%81', '%cc%84', '%cc%8c',
            ), '', $title );

            // Convert times to x
            $title = str_replace( '%c3%97', 'x', $title );

            $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
            $title = preg_replace('/\s+/', $sep, $title);
            $title = preg_replace('|-+|', $sep, $title);
            $title = trim($title, $sep);

            if($title === '' || $title === false)
                $title = $fallback_title;

            $title = $title . ($index === 0 ? '' : $index);
            return $title;
        }
    }

    if(!function_exists('utf8_uri_encode'))
    {
        function utf8_uri_encode( $utf8_string, $length = 0 )
        {
            $unicode = '';
            $values = array();
            $num_octets = 1;
            $unicode_length = 0;

            $string_length = strlen( $utf8_string );
            for ($i = 0; $i < $string_length; $i++ ) {

                $value = ord( $utf8_string[ $i ] );

                if ( $value < 128 ) {
                    if ( $length && ( $unicode_length >= $length ) )
                        break;
                    $unicode .= chr($value);
                    $unicode_length++;
                } else {
                    if ( count( $values ) == 0 ) $num_octets = ( $value < 224 ) ? 2 : 3;

                    $values[] = $value;

                    if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
                        break;
                    if ( count( $values ) == $num_octets ) {
                        if ($num_octets == 3) {
                            $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                            $unicode_length += 9;
                        } else {
                            $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                            $unicode_length += 6;
                        }

                        $values = array();
                        $num_octets = 1;
                    }
                }
            }

            return $unicode;
        }
    }

    if(!function_exists('seems_utf8'))
    {
        function seems_utf8($str)
        {
            $length = strlen($str);
            for ($i=0; $i < $length; $i++)
            {
                $c = ord($str[$i]);
                if ($c < 0x80) $n = 0; # 0bbbbbbb
                elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
                elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
                elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
                elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
                elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
                else return false; # Does not match any model
                for ($j=0; $j<$n; $j++)
                { # n bytes matching 10bbbbbb follow ?
                    if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                        return false;
                }
            }
            return true;
        }
    }

    if(!function_exists('remove_accents'))
    {
        function remove_accents($string)
        {
            if ( !preg_match('/[\x80-\xff]/', $string) )
                return $string;

            if (seems_utf8($string))
            {
                $chars = array(
                        // Decompositions for Latin-1 Supplement
                        chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
                        chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
                        chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
                        chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
                        chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
                        chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
                        chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
                        chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
                        chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
                        chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
                        chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
                        chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
                        chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
                        chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
                        chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
                        chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
                        chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
                        chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
                        chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
                        chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
                        chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
                        chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
                        chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
                        chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
                        chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
                        chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
                        chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
                        chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
                        chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
                        chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
                        chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
                        chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
                        // Decompositions for Latin Extended-A
                        chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
                        chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
                        chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
                        chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
                        chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
                        chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
                        chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
                        chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
                        chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
                        chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
                        chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
                        chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
                        chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
                        chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
                        chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
                        chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
                        chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
                        chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
                        chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
                        chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
                        chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
                        chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
                        chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
                        chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
                        chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
                        chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
                        chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
                        chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
                        chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
                        chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
                        chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
                        chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
                        chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
                        chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
                        chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
                        chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
                        chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
                        chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
                        chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
                        chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
                        chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
                        chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
                        chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
                        chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
                        chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
                        chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
                        chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
                        chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
                        chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
                        chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
                        chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
                        chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
                        chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
                        chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
                        chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
                        chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
                        chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
                        chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
                        chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
                        chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
                        chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
                        chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
                        chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
                        chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
                        // Decompositions for Latin Extended-B
                        chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
                        chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
                        // Euro Sign
                        chr(226).chr(130).chr(172) => 'E',
                        // GBP (Pound) Sign
                        chr(194).chr(163) => '',
                        // Vowels with diacritic (Vietnamese)
                        // unmarked
                        chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
                        chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
                        // grave accent
                        chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
                        chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
                        chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
                        chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
                        chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
                        chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
                        chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
                        // hook
                        chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
                        chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
                        chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
                        chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
                        chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
                        chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
                        chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
                        chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
                        chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
                        chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
                        chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
                        chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
                        // tilde
                        chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
                        chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
                        chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
                        chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
                        chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
                        chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
                        chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
                        chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
                        // acute accent
                        chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
                        chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
                        chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
                        chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
                        chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
                        chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
                        // dot below
                        chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
                        chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
                        chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
                        chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
                        chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
                        chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
                        chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
                        chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
                        chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
                        chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
                        chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
                        chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
                        // Vowels with diacritic (Chinese, Hanyu Pinyin)
                        chr(201).chr(145) => 'a',
                        // macron
                        chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
                        // acute accent
                        chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
                        // caron
                        chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
                        chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
                        chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
                        chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
                        chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
                        // grave accent
                        chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
                );

                $string = strtr($string, $chars);
            }
            else
            {
                // Assume ISO-8859-1 if not UTF-8
                $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                .chr(252).chr(253).chr(255);

                $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

                $string = strtr($string, $chars['in'], $chars['out']);
                $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
                $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
                $string = str_replace($double_chars['in'], $double_chars['out'], $string);
            }

            return $string;
        }
    }

    function tokenize($string)
    {
        $string = preg_replace('/[^a-zA-Z0-9]+/', '_', strtolower(trim($string)));
        $string = trim($string, '_');
        return $string;
    }
    function get_address($address)
    {
        $addressString = '';

        if ($address['address'])
        {
            $addressString .= $address['address'] .', ';
        }

        if ($address['city'])
        {
            $addressString .= $address['city'];
        }

        if ($address['state'])
        {
            $addressString .= ', '.$address['state'];
        }

        if ($address['country'])
        {
            $addressString .= ', '.$address['country'];
        }

        if ($address['zipcode'])
        {
            $addressString .= ', '.$address['zipcode'];
        }
        return $addressString;
    }

    function get_only_address($address)
    {
        $addressString = '';

        if ($address['address1'])
        {
            $addressString .= $address['address1'];
        }

        if ($address['address2'])
        {
            $addressString .= ', '.$address['address2'];
        }

        $addressString .= '.';
        return $addressString;
    }

    function get_address_state_code($state)
    {
        return strtoupper(substr($state, 0 , 2));
    }

    function get_map_address($address)
    {
        $addressString = '';

        if ($address['city'])
        {
            $addressString .= $address['city'];
        }

        if ($address['state'])
        {
            $addressString .= ', '.$address['state'];
        }

        if ($address['country'])
        {
            $addressString .= ', '.$address['country'];
        }

        return $addressString;
    }

    function get_city_address($address)
    {
        $addressString = '';

        if ($address['address'])
        {
            $addressString .= $address['address'] .', ';
        }

        if ($address['zipcode'])
        {
            $addressString .= $address['zipcode'];
        }
        return $addressString;
    }

    function get_gender($gender)
    {
        return $gender == 'M' ? 'Male' : 'Female';
    }

    function is_assoc($array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));

        /*
         *  return array_keys($array) != range(0, count($array) - 1);
         *
         */
    }

    function get_user_url($user)
    {
        global $config;
        return $config['base_url'].'member/'.$user['username'];
    }

    function get_user_image($url)
    {
        $ci = &get_instance();
        $path = str_replace(base_url() , '' , $url);
        $file = get_file($path);
        $file_name = get_file_name($file);
        $extension = get_file_extension($file);

        $restaurants_dir = $ci->config->item('files_dir').'user/';
        $restaurants_url = $ci->config->item('files_url').'user/';

        $file_thumb = $file_name.'_thumb.'.$extension;
        resize(120 , 120 , $restaurants_dir.$file , $restaurants_dir.$file_thumb);

        return $restaurants_url.$file_thumb;
    }

    function resize($width , $height , $source_path , $destination_path , $dimension = "")
    {
        $ci = &get_instance();

        if ($width >= 0 && $height >= 0)
        {
            $config["source_image"] = $source_path;
            $config['new_image'] = $destination_path;
            $config["width"] = $width;
            $config["height"] = $height;
            if($dimension != "")
            {
                $config['master_dim'] = $dimension;
            }

            $ci->load->library('image_lib');
            $ci->image_lib->initialize($config);

            $ci->image_lib->fit();
        }
    }

    function execute_cmd($cmd)
    {
        if (substr(php_uname(), 0, 7) == "Windows")
        {
            pclose(popen("start /B ". $cmd, "r"));
        }
        else
        {
            exec($cmd . " > /dev/null &");
        }
    }

    function is_site_online($url)
    {
        $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

        $ch = curl_init();
        curl_setopt ($cl, CURLOPT_CONNECTTIMEOUT,3);
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_VERBOSE,false);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_SSLVERSION,3);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $page = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode>=200 && $httpcode<300) return true;
        else return false;
    }

    function shorten_url($url)
    {
        $url = preg_replace('#^https?://#', '', $url);
        $url = preg_replace('#^www.#', '', $url);
        return $url;
    }

    function addhttp($url , $suffix = '//')
    {
       if (!preg_match("~^(?:f|ht)tps?:".$suffix."~i", $url)) {
            $url = "http:".$suffix. $url;
        }
        return $url;
    }

    function get_age($birth)
    {
        $birth = strtotime($birth);
        $t = time();
        $age = ($birth < 0) ? ( $t + ($birth * -1) ) : $t - $birth;
        $age = floor($age/31536000);
        return $age;
    }

    function calc_age($birth)
    {
        $birthDate = explode("/", $birth);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        if ($age<0) return 0;
        return $age;
    }

    function getRemainingSeconds($user)
    {
        if (empty($user['end_date'])) {
            return NULL;
        }
        $timeFirst  = strtotime(date('Y-m-d H:i'));
        $timeSecond = strtotime($user['end_date']);
        $differenceInSeconds = $timeSecond - $timeFirst;

        return $differenceInSeconds;
    }

    function is_valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
    }

    function get_text_for_unit($price , $unit)
    {
        switch($unit)
        {
            case '%': return $price.'%';
            case '$': return '$'.$price;
        }
    }


    function get_return_url($url)
    {
        $return_uri = get_request_uri();

        $query = parse_url($url, PHP_URL_QUERY);
        if($query)
        {
            $url .= '&return_uri='.urlencode($return_uri);
        }
        else
        {
            $url .= '?return_uri='.urlencode($return_uri);
        }

        return $url;
    }

    function return_redirect($url)
    {
        redirect(get_return_redirect($url));
    }

    function get_return_redirect($url)
    {
        $return_uri = $_SESSION['return_uri'];
        if($return_uri)
        {
            return $return_uri;
        }
        else
        {
            return $url;
        }
    }

    function get_back_url()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    function current_full_url()
    {
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }

	function render_url($attachment_id)
	{
		$ci = &get_instance();
		return $ci->attachment_library->render_url($attachment_id);
	}

	function download_url($attachment_id)
	{
		$ci = &get_instance();
		return $ci->attachment_library->download_url($attachment_id);
	}

    function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function array_to_csv_download($header, $keys, $array, $filename = "export.csv", $delimiter=",") {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
        $f = fopen('php://output', 'w');

        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter);
        }
    }