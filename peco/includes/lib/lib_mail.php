<?
/******************************************************
 * Library Mail
 *
 * Contain function for sending mail
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  lib_mail.php
 * Environment                :  PHP  version 4, 5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/
/** 		
* Send mail with attachment by mail() function
*  
* @param 				: string $mailto, string subject, ....
* @return 			: int
*/
function mail_attachment($mailto, $subject, $message, $from_mail, $from_name, $replyto, $filename, $path) {
    $file = $path;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
		$header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
		$header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    if (mail($mailto, $subject, $message, $header)) {
        return 1;
    } else {
    	return 0;
    }
}
/** 		
* Rewrite function mail()
* Send mail with attachment by mail() function or by PHPMailer class
*  
* @param 				: string $mailto, string subject, ....
* @return 			: int (0,1)
*/
function mail2($to="", $subject="", $html="", $from="", $cc="", $bcc=""){
	global $assign_list, $_CONFIG,  $mod;
	global $core;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= 'From: '.$_CONFIG['site_name']." <".$_CONFIG['webmaster_email'].">\r\n";

	$smtp_host	= $_CONFIG['smtp_server'];
	$smtp_port	= $_CONFIG['smtp_port'];
	$smtp_user	= $_CONFIG['smtp_user'];
	$smtp_pass	= $_CONFIG['smtp_pass'];
	
	$from = $_CONFIG['webmaster_email'];
	$site_name = $_CONFIG['site_name'];
	//BEGIN SEND MAIL
	$subject = "=?utf-8?b?".base64_encode($subject)."?=";
	if ($smtp_host=="" || $smtp_user=="" || $smtp_pass==""){
		if ($cc!=""){
			return mail($cc, $subject, $html, $headers);
		}else
		if ($bcc!=""){
			$headers .= "Bcc: $bcc" . "\r\n";
			return mail($to, $subject, $html, $headers);
		}else
			return mail($to, $subject, $html, $headers);
	}
	require_once (DIR_COMMON.'/class.phpmailer.php');
	$mail  = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->IsSMTP();
	//GMAIL config
		if ($smtp_port==465){
			$mail->SMTPAuth   = true;				// enable SMTP authentication
			$mail->SMTPSecure = "ssl";				// sets the prefix to the server
		}
		//$mail->SMTPDebug  = true;
		$mail->Host       = $smtp_host;			// sets GMAIL as the SMTP server
		$mail->Port       = $smtp_port;			// set the SMTP port for the GMAIL server
		$mail->Username   = $smtp_user;  		// GMAIL username
		$mail->Password   = $smtp_pass;			// GMAIL password
	//End Gmail config
	$mail->From       = $from;
	$mail->FromName   = $site_name;
	if ($cc!=""){
		if (strpos($cc, ',')!==false){
			$arrCC = explode(',', $cc);
			if (is_array($arrCC)){
				foreach ($arrCC as $k => $v){
					$mail->AddCC($v);
				}
			}
		}else{
			$mail->AddCC($cc);
		}
	}
	if ($bcc!=""){
		if (strpos($bcc, ',')!==false){
			$arrBCC = explode(',', $bcc);
			if (is_array($arrBCC)){
				foreach ($arrBCC as $k => $v){
					$mail->AddBCC($v);
				}
			}
		}else{
			$mail->AddBCC($bcc);
		}
	}
	$mail->Subject    = $subject;
	$mail->MsgHTML($html);	 
	$mail->AddAddress($to);
	$mail->IsHTML(true); // send as HTML	 
	if(!$mail->Send()) {//to see if we return a message or a value bolean
		//Begin write log
		$log = "[To: ".$to." | Subject:".$subject." | From: ".$from." | CC: ".$cc." | BCC: ".$bcc."]\n";
		$log.= "Mailer Error: " . $mail->ErrorInfo."\n";
		file_put_contents(DIR_LOGS."/mail.log", $log);
		//End write log
		return 0;
	}
	return 1;
	//END SEND MAIL
}
/** 		
* Send mail when register with activation link
*  
* @param 				: string $to, string fullname, string user_name, string user_pass, string active_link
* @return 			: int
*/
function send_mail_register($to="", $fullname="", $user_name="", $user_pass="", $active_link=""){	
	global $assign_list, $_CONFIG,  $mod;
	global $core;
	$html = readMailTemplate(DIR_CONFIGS."/mail_register.txt", $subject);
	$html = str_replace("%TITLE%", $_CONFIG['site_name'], $html);
	$html = str_replace("%FULL_NAME%", $fullname, $html);
	$html = str_replace("%USER_NAME%", $user_name, $html);
	$html = str_replace("%USER_PASS%", $user_pass, $html);
	$html = str_replace("%URL_ACTIVE%", $active_link, $html);
	$html = str_replace("%SITE_NAME%", $_CONFIG['site_name'], $html);
	return mail2($to, $subject, $html);
}
/** 		
* Send mail when register when verified successfully
*  
* @param 				: string $to, string fullname, string user_name, string user_pass
* @return 			: int
*/
function send_mail_register_success($to="", $fullname="", $user_name="", $user_pass=""){	
	global $assign_list, $_CONFIG,  $mod;
	global $core;
	$html = readMailTemplate(DIR_CONFIGS."/mail_register_success.txt", $subject);
	$html = str_replace("%TITLE%", $_CONFIG['site_name'], $html);
	$html = str_replace("%FULL_NAME%", $fullname, $html);
	$html = str_replace("%USER_NAME%", $user_name, $html);
	$html = str_replace("%USER_PASS%", $user_pass, $html);
	$html = str_replace("%SITE_NAME%", $_CONFIG['site_name'], $html);
	return mail2($to, $subject, $html);
}
/** 		
* Send forgot mail when lost password
*  
* @param 				: string $to, string fullname, string forgot_link
* @return 			: int
*/
function send_mail_forgot($to="", $fullname="", $forgot_link=""){	
	global $assign_list, $_CONFIG,  $mod;
	global $core;
	$html = readMailTemplate(DIR_CONFIGS."/mail_forgot.txt", $subject);
	$html = str_replace("%TITLE%", $_CONFIG['site_name'], $html);
	$html = str_replace("%FULL_NAME%", $fullname, $html);
	$html = str_replace("%URL_FORGOT%", $forgot_link, $html);
	$html = str_replace("%SITE_NAME%", $_CONFIG['site_name'], $html);
	return mail2($to, $subject, $html);
}
/** 		
* Send resetpass mail
*  
* @param 				: string $to, string fullname, string user_name, string user_pass
* @return 			: int
*/
function send_mail_resetpass($to="", $fullname="", $user_name="", $user_pass=""){
	global $assign_list, $_CONFIG,  $mod;
	global $core;
	$html = readMailTemplate(DIR_CONFIGS."/mail_resetpass.txt", $subject);
	$html = str_replace("%TITLE%", $_CONFIG['site_name'], $html);
	$html = str_replace("%FULL_NAME%", $fullname, $html);
	$html = str_replace("%USER_NAME%", $user_name, $html);
	$html = str_replace("%USER_PASS%", $user_pass, $html);
	$html = str_replace("%SITE_NAME%", $_CONFIG['site_name'], $html);
	return mail2($to, $subject, $html);
}
/** 		
* Send mass email
*  
* @param 				: string $send_type, array arrListEmail, string cc_email, string subject, string body
* @return 			: int
*/
function send_mass_email($send_type="HTML", $arrListEmail, $cc_email="", $subject="", $body=""){
	global $assign_list, $_CONFIG,  $mod;
	global $core;
}

?>