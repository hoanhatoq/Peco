<?
/******************************************************
 * Library String
 *
 * Contain string functions for project
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  lib_string.php
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
* Convert <br> to new line \n
*  
* @param 			: string $str
* @return 			: string
*/
function br2nl($str){
	$str = str_replace("<br>", "\n", $str);
	$str = str_replace("<br />", "", $str);
	return $str;
}

// Much simpler UTF-8-ness checker using a regular expression created by the W3C:
// Returns true if $string is valid UTF-8 and false otherwise.
// From http://w3.org/International/questions/qa-forms-utf-8.html
function isUTF8($str) {
   return preg_match('%^(?:
         [\x09\x0A\x0D\x20-\x7E]           // ASCII
       | [\xC2-\xDF][\x80-\xBF]            // non-overlong 2-byte
       | \xE0[\xA0-\xBF][\x80-\xBF]        // excluding overlongs
       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} // straight 3-byte
       | \xED[\x80-\x9F][\x80-\xBF]        // excluding surrogates
       | \xF0[\x90-\xBF][\x80-\xBF]{2}     // planes 1-3
       | [\xF1-\xF3][\x80-\xBF]{3}         // planes 4-15
       | \xF4[\x80-\x8F][\x80-\xBF]{2}     // plane 16
   )*$%xs', $str);
}
// Compare to native utf8_encode function, which will re-encode text that is already UTF-8
function makeUTF8($str, $encoding = "") {
	if (!empty($str)) {
		if (empty($encoding) && isUTF8($str))
		  $encoding = "UTF-8";
		if (empty($encoding))
		  $encoding = mb_detect_encoding($str,'UTF-8, ISO-8859-1');
		if (empty($encoding))
		  $encoding = "ISO-8859-1"; //  if charset can't be detected, default to ISO-8859-1
		return $encoding == "UTF-8" ? $str : @mb_convert_encoding($str,"UTF-8",$encoding);
	}
}
/** 		
* Convert utf8html to utf8
*  
* @param 			: string $s
* @return 			: string
*/
function uft8html2utf8( $s ) {
	if ( !function_exists('uft8html2utf8_callback') ) {
		 function uft8html2utf8_callback($t) {
				 $dec = $t[1];
	   if ($dec < 128) {
		 $utf = chr($dec);
	   } else if ($dec < 2048) {
		 $utf = chr(192 + (($dec - ($dec % 64)) / 64));
		 $utf .= chr(128 + ($dec % 64));
	   } else {
		 $utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
		 $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
		 $utf .= chr(128 + ($dec % 64));
	   }
	   return $utf;
		 }
	}                               
	return preg_replace_callback('|&#([0-9]{1,});|', 'uft8html2utf8_callback', $s );                               
}
/** 		
* Convert a string to UTF8 with no sign
*  
* @param 			: string $str
* @return 			: string
*/
function utf8_nosign ($str){
	$str = trim($str);
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd'=>'đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i'=>'í|ì|ỉ|ĩ|ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'D'=>'Đ',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	);	
	foreach($unicode as $nonUnicode=>$uni){
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
	}
	return $str;
}
/** 		
* Convert a string to UTF8 with no sign and no blank
*  
* @param 			: string $str
* @return 			: string
*/
function utf8_nosign_noblank($str){
	$str = trim($str);
	$str = strtolower(utf8_nosign($str));
	$str = preg_replace('/[^A-Za-z0-9]/', "-", $str);
	$i = 0;
	while(strpos($str, '--')!==false){
		$str = str_replace('--', '-', $str);
		$i++;
		if ($i>10) break;
	};
	$str = trim($str, '-');
	return $str;
}
/** 		
* Get seed is current microtime
*  
* @param 			: no
* @return 			: float
*/
function make_seed()
{
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}
/** 		
* Generates a random string with the specified length, Chars are chosen from the provided [optional] list
*  
* @param 			: string $str
* @return 			: string
*/
function simpleRandString($length=5, $list="123456789ABCDEFGHJKLMNPQRSTUVWXYZ") {
	mt_srand(make_seed());
	$newstring = "";
	if ($length > 0) {
		while (strlen($newstring) < $length) {
			$newstring .= $list[mt_rand(0, strlen($list)-1)];
		}
	}
	return $newstring;
}
/** 		
* Decode variable to original
*  
* @param 			: mix $var
* @return 			: string
*/
function htmlDecode($var){
	if (is_array($var)){
		foreach ($var as $k => $v){
			$var[$k] = htmlDecode($v);
		}
	}else{
		$var = html_entity_decode($var, ENT_QUOTES, 'UTF-8');
	}
	return $var;
}
/** 		
* Find position of first occurrence of a string 
*  
* @param 			: string $str, string $findme
* @return 			: bool
*/
function mystrpos($str, $findme){
	if ($str=="" && $findme=="") return 1;
	if (strpos(strtolower($str), $findme)!==false){
		return 1;
	}
	return 0;
}
/** 		
* Detect delimiter in string
*  
* @param 			: string $str
* @return 			: bool
*/
function detect_delimiter($str){
	if (strpos($str, ',')!==false) return ',';
	if (strpos($str, ';')!==false) return ';';
	if (strpos($str, '|')!==false) return '|';
	return '';
}
?>