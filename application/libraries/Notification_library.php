<?php
	use Mailgun\Mailgun;
	use Mailjet\Resources;


	class Notification_library
	{
		private $ci;

		public function __construct()
		{
			$this->ci = &get_instance();
		}

		public function send_sms($tos , $message)
		{
			for($i = 0 ; $i < count($tos) ; $i ++) {
				$tos[$i] = ltrim($tos[$i],'+');
				
				if(strlen($tos[$i]) == 9)
				{
					$tos[$i] = '00966'.$tos[$i];
				}
				else if(strlen($tos[$i]) == 10)
				{
					$tos[$i] = '0096'.$tos[$i];
				}
				else if(strlen($tos[$i]) == 12)
				{
					$tos[$i] = '00'.$tos[$i];
				}
			}
							
			$gateway_url = 'http://www.mobily.ws/api/msgSend.php';
			$params = 
			[
				'mobile' => '966598731022',
				'password' => 'Moej1985',
				'numbers' => implode(',', $tos),
				'sender' => 'ShaghafProg',
				'msg' => $this->convertToUnicode($message),
				'applicationType' => 68
			];

			$response = file_get_contents($gateway_url.'?'.http_build_query($params));
			if($response == 1)
				return true;
			else 
				return false;
		}

		public function sendSMSJson($jsonObj)
		{
			$jsonObj['msg'] = $this->convertToUnicode($jsonObj['msg']);
			$jsonObj['sender'] = urlencode($jsonObj['sender']);
			$url = "http://www.mobily.ws/api/msgSend.php";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($jsonObj));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			return $result;
		}
		
		public function sendSMS($number, $msg)
		{
			$jsonObj = [
				'apiKey' => '47a6d4bcd823596155357c3eac888472',
				'sender'=>'ShaghafProg',
				'applicationType' => 68,
				'numbers' => $number,
				'msg' => $msg,
				'msgId' => rand(1,99999),
				'timeSend' => '0',
				'dateSend' => '0'
			];
			return $this->sendSMSJson($jsonObj);
		}

		private function convertToUnicode($message)
		{
			$chrArray[0] = "،";
			$unicodeArray[0] = "060C";
			$chrArray[1] = "؛";
			$unicodeArray[1] = "061B";
			$chrArray[2] = "؟";
			$unicodeArray[2] = "061F";
			$chrArray[3] = "ء";
			$unicodeArray[3] = "0621";
			$chrArray[4] = "آ";
			$unicodeArray[4] = "0622";
			$chrArray[5] = "أ";
			$unicodeArray[5] = "0623";
			$chrArray[6] = "ؤ";
			$unicodeArray[6] = "0624";
			$chrArray[7] = "إ";
			$unicodeArray[7] = "0625";
			$chrArray[8] = "ئ";
			$unicodeArray[8] = "0626";
			$chrArray[9] = "ا";
			$unicodeArray[9] = "0627";
			$chrArray[10] = "ب";
			$unicodeArray[10] = "0628";
			$chrArray[11] = "ة";
			$unicodeArray[11] = "0629";
			$chrArray[12] = "ت";
			$unicodeArray[12] = "062A";
			$chrArray[13] = "ث";
			$unicodeArray[13] = "062B";
			$chrArray[14] = "ج";
			$unicodeArray[14] = "062C";
			$chrArray[15] = "ح";
			$unicodeArray[15] = "062D";
			$chrArray[16] = "خ";
			$unicodeArray[16] = "062E";
			$chrArray[17] = "د";
			$unicodeArray[17] = "062F";
			$chrArray[18] = "ذ";
			$unicodeArray[18] = "0630";
			$chrArray[19] = "ر";
			$unicodeArray[19] = "0631";
			$chrArray[20] = "ز";
			$unicodeArray[20] = "0632";
			$chrArray[21] = "س";
			$unicodeArray[21] = "0633";
			$chrArray[22] = "ش";
			$unicodeArray[22] = "0634";
			$chrArray[23] = "ص";
			$unicodeArray[23] = "0635";
			$chrArray[24] = "ض";
			$unicodeArray[24] = "0636";
			$chrArray[25] = "ط";
			$unicodeArray[25] = "0637";
			$chrArray[26] = "ظ";
			$unicodeArray[26] = "0638";
			$chrArray[27] = "ع";
			$unicodeArray[27] = "0639";
			$chrArray[28] = "غ";
			$unicodeArray[28] = "063A";
			$chrArray[29] = "ف";
			$unicodeArray[29] = "0641";
			$chrArray[30] = "ق";
			$unicodeArray[30] = "0642";
			$chrArray[31] = "ك";
			$unicodeArray[31] = "0643";
			$chrArray[32] = "ل";
			$unicodeArray[32] = "0644";
			$chrArray[33] = "م";
			$unicodeArray[33] = "0645";
			$chrArray[34] = "ن";
			$unicodeArray[34] = "0646";
			$chrArray[35] = "ه";
			$unicodeArray[35] = "0647";
			$chrArray[36] = "و";
			$unicodeArray[36] = "0648";
			$chrArray[37] = "ى";
			$unicodeArray[37] = "0649";
			$chrArray[38] = "ي";
			$unicodeArray[38] = "064A";
			$chrArray[39] = "ـ";
			$unicodeArray[39] = "0640";
			$chrArray[40] = "ً";
			$unicodeArray[40] = "064B";
			$chrArray[41] = "ٌ";
			$unicodeArray[41] = "064C";
			$chrArray[42] = "ٍ";
			$unicodeArray[42] = "064D";
			$chrArray[43] = "َ";
			$unicodeArray[43] = "064E";
			$chrArray[44] = "ُ";
			$unicodeArray[44] = "064F";
			$chrArray[45] = "ِ";
			$unicodeArray[45] = "0650";
			$chrArray[46] = "ّ";
			$unicodeArray[46] = "0651";
			$chrArray[47] = "ْ";
			$unicodeArray[47] = "0652";
			$chrArray[48] = "!";
			$unicodeArray[48] = "0021";
			$chrArray[49]='"';
			$unicodeArray[49] = "0022";
			$chrArray[50] = "#";
			$unicodeArray[50] = "0023";
			$chrArray[51] = "$";
			$unicodeArray[51] = "0024";
			$chrArray[52] = "%";
			$unicodeArray[52] = "0025";
			$chrArray[53] = "&";
			$unicodeArray[53] = "0026";
			$chrArray[54] = "'";
			$unicodeArray[54] = "0027";
			$chrArray[55] = "(";
			$unicodeArray[55] = "0028";
			$chrArray[56] = ")";
			$unicodeArray[56] = "0029";
			$chrArray[57] = "*";
			$unicodeArray[57] = "002A";
			$chrArray[58] = "+";
			$unicodeArray[58] = "002B";
			$chrArray[59] = ",";
			$unicodeArray[59] = "002C";
			$chrArray[60] = "-";
			$unicodeArray[60] = "002D";
			$chrArray[61] = ".";
			$unicodeArray[61] = "002E";
			$chrArray[62] = "/";
			$unicodeArray[62] = "002F";
			$chrArray[63] = "0";
			$unicodeArray[63] = "0030";
			$chrArray[64] = "1";
			$unicodeArray[64] = "0031";
			$chrArray[65] = "2";
			$unicodeArray[65] = "0032";
			$chrArray[66] = "3";
			$unicodeArray[66] = "0033";
			$chrArray[67] = "4";
			$unicodeArray[67] = "0034";
			$chrArray[68] = "5";
			$unicodeArray[68] = "0035";
			$chrArray[69] = "6";
			$unicodeArray[69] = "0036";
			$chrArray[70] = "7";
			$unicodeArray[70] = "0037";
			$chrArray[71] = "8";
			$unicodeArray[71] = "0038";
			$chrArray[72] = "9";
			$unicodeArray[72] = "0039";
			$chrArray[73] = ":";
			$unicodeArray[73] = "003A";
			$chrArray[74] = ";";
			$unicodeArray[74] = "003B";
			$chrArray[75] = "<";
			$unicodeArray[75] = "003C";
			$chrArray[76] = "=";
			$unicodeArray[76] = "003D";
			$chrArray[77] = ">";
			$unicodeArray[77] = "003E";
			$chrArray[78] = "?";
			$unicodeArray[78] = "003F";
			$chrArray[79] = "@";
			$unicodeArray[79] = "0040";
			$chrArray[80] = "A";
			$unicodeArray[80] = "0041";
			$chrArray[81] = "B";
			$unicodeArray[81] = "0042";
			$chrArray[82] = "C";
			$unicodeArray[82] = "0043";
			$chrArray[83] = "D";
			$unicodeArray[83] = "0044";
			$chrArray[84] = "E";
			$unicodeArray[84] = "0045";
			$chrArray[85] = "F";
			$unicodeArray[85] = "0046";
			$chrArray[86] = "G";
			$unicodeArray[86] = "0047";
			$chrArray[87] = "H";
			$unicodeArray[87] = "0048";
			$chrArray[88] = "I";
			$unicodeArray[88] = "0049";
			$chrArray[89] = "J";
			$unicodeArray[89] = "004A";
			$chrArray[90] = "K";
			$unicodeArray[90] = "004B";
			$chrArray[91] = "L";
			$unicodeArray[91] = "004C";
			$chrArray[92] = "M";
			$unicodeArray[92] = "004D";
			$chrArray[93] = "N";
			$unicodeArray[93] = "004E";
			$chrArray[94] = "O";
			$unicodeArray[94] = "004F";
			$chrArray[95] = "P";
			$unicodeArray[95] = "0050";
			$chrArray[96] = "Q";
			$unicodeArray[96] = "0051";
			$chrArray[97] = "R";
			$unicodeArray[97] = "0052";
			$chrArray[98] = "S";
			$unicodeArray[98] = "0053";
			$chrArray[99] = "T";
			$unicodeArray[99] = "0054";
			$chrArray[100] = "U";
			$unicodeArray[100] = "0055";
			$chrArray[101] = "V";
			$unicodeArray[101] = "0056";
			$chrArray[102] = "W";
			$unicodeArray[102] = "0057";
			$chrArray[103] = "X";
			$unicodeArray[103] = "0058";
			$chrArray[104] = "Y";
			$unicodeArray[104] = "0059";
			$chrArray[105] = "Z";
			$unicodeArray[105] = "005A";
			$chrArray[106] = "[";
			$unicodeArray[106] = "005B";
			$char="\ ";
			$chrArray[107]=trim($char);
			$unicodeArray[107] = "005C";
			$chrArray[108] = "]";
			$unicodeArray[108] = "005D";
			$chrArray[109] = "^";
			$unicodeArray[109] = "005E";
			$chrArray[110] = "_";
			$unicodeArray[110] = "005F";
			$chrArray[111] = "`";
			$unicodeArray[111] = "0060";
			$chrArray[112] = "a";
			$unicodeArray[112] = "0061";
			$chrArray[113] = "b";
			$unicodeArray[113] = "0062";
			$chrArray[114] = "c";
			$unicodeArray[114] = "0063";
			$chrArray[115] = "d";
			$unicodeArray[115] = "0064";
			$chrArray[116] = "e";
			$unicodeArray[116] = "0065";
			$chrArray[117] = "f";
			$unicodeArray[117] = "0066";
			$chrArray[118] = "g";
			$unicodeArray[118] = "0067";
			$chrArray[119] = "h";
			$unicodeArray[119] = "0068";
			$chrArray[120] = "i";
			$unicodeArray[120] = "0069";
			$chrArray[121] = "j";
			$unicodeArray[121] = "006A";
			$chrArray[122] = "k";
			$unicodeArray[122] = "006B";
			$chrArray[123] = "l";
			$unicodeArray[123] = "006C";
			$chrArray[124] = "m";
			$unicodeArray[124] = "006D";
			$chrArray[125] = "n";
			$unicodeArray[125] = "006E";
			$chrArray[126] = "o";
			$unicodeArray[126] = "006F";
			$chrArray[127] = "p";
			$unicodeArray[127] = "0070";
			$chrArray[128] = "q";
			$unicodeArray[128] = "0071";
			$chrArray[129] = "r";
			$unicodeArray[129] = "0072";
			$chrArray[130] = "s";
			$unicodeArray[130] = "0073";
			$chrArray[131] = "t";
			$unicodeArray[131] = "0074";
			$chrArray[132] = "u";
			$unicodeArray[132] = "0075";
			$chrArray[133] = "v";
			$unicodeArray[133] = "0076";
			$chrArray[134] = "w";
			$unicodeArray[134] = "0077";
			$chrArray[135] = "x";
			$unicodeArray[135] = "0078";
			$chrArray[136] = "y";
			$unicodeArray[136] = "0079";
			$chrArray[137] = "z";
			$unicodeArray[137] = "007A";
			$chrArray[138] = "{";
			$unicodeArray[138] = "007B";
			$chrArray[139] = "|";
			$unicodeArray[139] = "007C";
			$chrArray[140] = "}";
			$unicodeArray[140] = "007D";
			$chrArray[141] = "~";
			$unicodeArray[141] = "007E";
			$chrArray[142] = "©";
			$unicodeArray[142] = "00A9";
			$chrArray[143] = "®";
			$unicodeArray[143] = "00AE";
			$chrArray[144] = "÷";
			$unicodeArray[144] = "00F7";
			$chrArray[145] = "×";
			$unicodeArray[145] = "00F7";
			$chrArray[146] = "§";
			$unicodeArray[146] = "00A7";
			$chrArray[147] = " ";
			$unicodeArray[147] = "0020";
			$chrArray[148] = "\n";
			$unicodeArray[148] = "000D";
			$chrArray[149] = "\r";
			$unicodeArray[149] = "000A";

			$strResult = "";
			for($i=0; $i<strlen($message); $i++)
			{
				if(in_array(mb_substr($message,$i,1,'UTF-8'), $chrArray))
					$strResult.= $unicodeArray[array_search(mb_substr($message,$i,1,'UTF-8'), $chrArray)];
			}
			return $strResult;
		}

		public function send_email($to, $subject , $body , $attachments = [] , $ccs = [] , $bccs = [])
		{
			global $config;

			$email_config = $config['email'];

			$mj = new \Mailjet\Client('fe22d3c379f333d1c37cfa6cfba14b7b', '20f697d1d5eb8f7f03275d34696881c3', true ,['version' => 'v3.1']);

			$to_emails = array();	
			if(is_array($to))
			{
				foreach ($to as $t)
				{
					$to_emails[] = ['Email' => $t];
				}
			}
			else if($to != "")
			{
				$to_emails[] = ['Email' => $to];
			}

			$cc_emails = [];
			foreach ($ccs as $cc)
			{
				$cc_emails[] = ['Email' => trim($cc)];
			}

			$bcc_emails = [];
			foreach ($bccs as $bcc)
			{
				$bcc_emails[] = ['Email' => trim($bcc)];
			}

			$admin_emails = $config['admin_emails'];
			foreach ($admin_emails as $admin_email)
			{
				$cc_emails[] = ['Email' => trim($admin_email)];
			}

			if(count($to_emails) == 0) {
				$admin_emails = $config['admin_emails'];
				foreach ($admin_emails as $admin_email)
				{
					$to_emails[] = ['Email' => trim($admin_email)];
				}				
			}
					
			$body = [
				'Messages' => [
					[
						'From' => [
							'Email' => $email_config['email_from'],
							'Name' => $email_config['email_from_name']
						],
						'To' => $to_emails,
						'Cc' => $cc_emails,
						'Bcc' => $bcc_emails,
						'Subject' => $subject,
						'HTMLPart' => $body
					]
				]
			];

			$response = $mj->post(Resources::$Email, ['body' => $body]);
			return $response->success();
		}

		public function send_email1($to , $subject , $body , $attachments = array() , $ccs = array() , $bccs = array())
		{			

			Logger::log('email.send' , '--------------------------------');
			global $config;

			$email_config = $config['email'];

			Logger::log('email.send' , 'To : ');
			Logger::log('email.send' , $to);
			Logger::log('email.send' , 'Subject : '.$subject);
			Logger::log('email.send' , 'Body : ');
			Logger::log('email.send' , $body);
			Logger::log('email.send' , 'Attachments : ');
			Logger::log('email.send' , $attachments);
			Logger::log('email.send' , 'CC : ');
			Logger::log('email.send' , $ccs);
			Logger::log('email.send' , 'BCC : ');
			Logger::log('email.send' , $bccs);
			Logger::log('email.send' , 'Config : ');
			Logger::log('email.send' , $config['email']);


			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = $email_config['smtp_host'];
			$mail->Port = $email_config['smtp_port'];
			$mail->SMTPAuth = true;
			$mail->Username = $email_config['smtp_user'];
			$mail->Password = $email_config['smtp_pass'];
			$mail->SMTPSecure = 'tls';

			$mail->From = $email_config['email_from'];
			$mail->FromName = $email_config['email_from_name'];

			$to_emails = array();	
			if(is_array($to))
			{
				foreach ($to as $t)
				{
					$to_emails[] = $t;
					$mail->addAddress($t);
				}
			}
			else if($to != "")
			{
				$to_emails[] = $to;
				$mail->addAddress($to);
			}

			$cc_emails = [];
			$admin_emails = $config['admin_emails'];
			foreach ($admin_emails as $admin_email)
			{
				$cc_emails[] = trim($admin_email);
				$mail->AddCC(trim($admin_email));
			}

			foreach ($ccs as $cc)
			{
				$cc_emails[] = trim($cc);
				$mail->AddCC(trim($cc));
			}

			foreach ($bccs as $bcc)
			{
				$mail->AddBCC(trim($bcc));
			}

			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $body;

			foreach ($attachments as $attachment)
			{
				$mail->AddAttachment($this->ci->config->item('files_dir').$attachment['path'].'/file' , $attachment['name']);
			}

			/*	
			if(!$mail->send())
			{
				Logger::log('email.send' , 'ERROR ERROR ERROR ERROR');
				Logger::log('email.send' , $mail->ErrorInfo);
				Logger::log('email.send' , '--------------------------------');
				return false;
			}
			

			Logger::log('email.send' , 'Success');
			Logger::log('email.send' , '--------------------------------');
			return true;
			/**/

			$bccs[] = 'moe985@gmail.com';
			$bccs[] = 'ehussain.in@gmail.com';

			$header  = "From:".$email_config['email_from']." \r\n";
			$header .= "BCC: ".implode(',',$bccs)." \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";

			$retval = mail(implode(',' , $to_emails) , $subject , $body , $header);

			if( $retval == true ) 
			{
				return true;
			}
			else 
			{
				return false;
			}
		}

		public function send_template_email($to , $subject , $template , $parse , $attachments = array() , $ccs = array())
		{
			Logger::log('email.send' , '--------------------------------------');
			Logger::log('email.send' , 'Template Email : '.$template);
			Logger::log('email.send' , $parse);

			global $config;
			$body = file_get_contents($config['root_dir'].'/assets/templates/'.$template.'.html');
			$subject = $this->ci->util->parse($subject , $parse);
			$body = $this->ci->util->parse($body , $parse);

			return $this->send_email($to , $subject , $body , $attachments , $ccs);
		}

		public function send_template_emails($tos , $subject , $template , $parse , $attachments = array())
		{
			Logger::log('email.send' , '--------------------------------------');
			Logger::log('email.send' , 'Template Email : '.$template);
			Logger::log('email.send' , $parse);
			
			global $config;
			$body = file_get_contents($config['root_dir'].'/assets/templates/'.$template.'.html');
			$subject = $this->ci->util->parse($subject , $parse);
			$body = $this->ci->util->parse($body , $parse);
			return $this->send_email($tos , $subject , $body , $attachments);
		}

		public function send_template_sms($user , $template)
		{
			Logger::log('email.send' , '--------------------------------------');
			Logger::log('email.send' , 'Template Email : '.$template);
			Logger::log('email.send' , $user);
			
			global $config;
			$body = file_get_contents($config['root_dir'].'/assets/templates/'.$template.'.html');
			$body = $this->ci->util->parse($body , $user);

			return $this->sendSMS($user['phone'], $body);
		}

		public function send_template_bcc_email($bcc , $subject , $template , $parse , $attachments = array())
		{
			Logger::log('email.send' , '--------------------------------------');
			Logger::log('email.send' , 'Template Email : '.$template);
			Logger::log('email.send' , $parse);

			global $config;
			$body = file_get_contents($config['root_dir'].'/assets/templates/'.$template.'.html');
			$subject = $this->ci->util->parse($subject , $parse);
			$body = $this->ci->util->parse($body , $parse);

			return $this->send_email("" , $subject , $body , $attachments , array() , $bcc);
		}
	}
