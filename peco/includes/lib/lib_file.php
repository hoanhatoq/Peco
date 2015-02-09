<?
/******************************************************
 * Library File
 *
 * Contain file functions for project
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  lib_file.php
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
* Return content of a file
*  
* @param 				: string $file
* @return 			: string
*/
function read_file($file){
    $handle = fopen ($file, "rb");
    $contents = "";
    do {
        $data = fread($handle, 8192);
        if (strlen($data) == 0) {
           break;
       }
       $contents .= $data;
    } while(true);
    fclose ($handle);
    return $contents;
}
/** 		
* Save content to a file
*  
* @param 				: string $file, string $content, int $append, int $binary
* @return 			: string
*/
function save_file($file,$content,$append=0,$binary=0){
    if($binary){
        $b = 'b';
    } else {
        $b= 't';
    }
    if($append) {
        $mode = "a$b";
    } else {
        $mode = "w$b";
    }
    $fp = @fopen($file,$mode);
    $err = '';
    if($fp) {
        fwrite($fp,$content);
        fclose($fp);
        //@chmod($file, 0666);
    } else {
        $err = " Can't write file $file. Check file/directory permissions.";
    }
    return $err;
}
/** 		
* Get size text of a interger
*  
* @param 				: float $size
* @return 			: string
*/
function get_size($size) {//bytes
	$kb = 1024;
	$mb = 1024 * $kb;
	$gb = 1024 * $mb;
	$tb = 1024 * $gb;
	if ($size < $kb) {
		$file_size = "$size Bytes";
	}
	elseif ($size < $mb) {
		$final = round($size/$kb,2);
		$file_size = "$final KB";
	}
	elseif ($size < $gb) {
		$final = round($size/$mb,2);
		$file_size = "$final MB";
	}
	elseif($size < $tb) {
		$final = round($size/$gb,2);
		$file_size = "$final GB";
	} else {
		$final = round($size/$tb,2);
		$file_size = "$final TB";
	}
	return $file_size;
} 
if (!function_exists('file_put_contents')) {
	/** 		
	* Rewrite function file_put_contents if not exists
	*/
	function file_put_contents($filename="", $str){
		if (is_writable($filename)) {
			$fp = fopen($filename, "w");
			fwrite($fp, $str);
			fclose($fp);
			return 1;
		}else{
			return 0;
		}
	}	
}
if (!function_exists('file_get_contents')) {
	/** 		
	* Rewrite function file_get_contents if not exists
	*/
	function file_get_contents($filename=""){
		$fp = fopen($filename, "w");
		$str = fread($fp, filesize($filename));
		fclose($fp);
		return $str;
	}	
}
/** 		
* Get all files in directory
*  
* @param 				: string $dir
* @return 			: array
*/
function getDirectory($dir){
	$arr = "";
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && is_dir($dir."/".$file)){
				$arr[] = $file;
			}
		}
		closedir($handle);
	}
	return $arr;
}
/** 		
* Detect OS Line Break
*  
* @param 				: bool $true_val
* @return 			: char
*/
function _get_os_linebreak($true_val=false)
{
	$os = strtolower(PHP_OS);
	switch($os)
	{
		# not sure if the string is correct for FreeBSD
		# not tested
		case 'freebsd' : 
		# not sure if the string is correct for NetBSD
		# not tested
		case 'netbsd' : 
		# not sure if the string is correct for Solaris
		# not tested
		case 'solaris' : 
		# not sure if the string is correct for SunOS
		# not tested
		case 'sunos' : 
		# linux variation
		# tested on server
		case 'linux' : 
			$nl = "\n";
			break;
		# darwin is mac os x
		# tested only on the client os
		case 'darwin' : 
			# note os x has \r line returns however it appears that the ifcofig
			# file used to source much data uses \n. let me know if this is
			# just my setup and i will attempt to fix.
			if($true_val) $nl = "\r";
			else $nl = "\n";
			break;
		# defaults to a win system format;
		default :
			$nl = "\r\n";
	}
	return $nl;
}

function readMailTemplate($mailtemplate,&$subjectmail){
	$str="";
	$fin=fopen($mailtemplate,"r");	
	if (!$fin) 
	{	
		return false;
	}
	$i=0;
	while (!feof($fin))
	{
		$line=fgets($fin);
		if ($i==0){
			$subjectmail=$line;
		}
		$i++;
		if ($i>2){
			$str.=$line;//trim($line, "\r\n")."\r";
		}
	}
	fclose($fin);	
	return $str;
}
/**
 * Resize avatar with Black background
 *
 * @param 			: string $file_name, string $new_file_name, int width, int height
 * @return 			: true of false
 */
function resize_avatar($file_name="", $new_file_name="", $width=220, $height=298){
	if(file_exists($file_name)){
		if (strtolower(substr($file_name, -3))=="jpg" || strtolower(substr($file_name, -4))=="jpeg"){
			$obj_image = imagecreatefromjpeg($file_name);
			$obj_image_type= "jpg";
		}else
		if (strtolower(substr($file_name, -3))=="gif"){
			$obj_image = imagecreatefromgif($file_name);
			$obj_image_type= "gif";
		}else
		if (strtolower(substr($file_name, -3))=="png"){
			$obj_image = imagecreatefrompng($file_name);
			$obj_image_type= "png";
		}
		$o_wd = imagesx($obj_image);
		$o_ht = imagesy($obj_image);	
		$o_x = $o_y = 0;	
		$newwidth = $width;
		$newheight = round($o_ht*$newwidth/$o_wd);	
		$o_y = round(($newheight-$height)/2);
		$obj_temp = imageCreateTrueColor($width,$height);
		imageCopyResampled($obj_temp, $obj_image, 0, 0, $o_x, $o_y, $newwidth, $newheight, $o_wd, $o_ht);
		if ($obj_image_type=="jpg"){
			imagejpeg($obj_temp, $new_file_name, 100);
		}elseif ($obj_image_type=="gif"){
			imagegif($obj_temp, $new_file_name);
		}elseif ($obj_image_type=="png"){
			imagepng($obj_temp, $new_file_name);
		}
		return 1;
	}
	return 0;
}
/**
 * Resize and Crop image to thumbnail
 *
 * @param 			: string $file_name, string $new_file_name, int width, int height
 * @return 			: true of false
 */
function resize_thumbs($file_name="", $new_file_name="", $width=160, $height=160){
	if(file_exists($file_name)){
		if (strtolower(substr($file_name, -3))=="jpg" || strtolower(substr($file_name, -4))=="jpeg"){
			$obj_image = imagecreatefromjpeg($file_name);
			$obj_image_type= "jpg";
		}else
		if (strtolower(substr($file_name, -3))=="gif"){
			$obj_image = imagecreatefromgif($file_name);
			$obj_image_type= "gif";
		}else
		if (strtolower(substr($file_name, -3))=="png"){
			$obj_image = imagecreatefrompng($file_name);
			$obj_image_type= "png";
		}
	}
	$o_wd = imagesx($obj_image);
	$o_ht = imagesy($obj_image);	
	if ($o_wd*$height == $o_ht*$width) $i=0;elseif ($o_wd*$height > $o_ht*$width) $i = 1; else $i = 2;
	$o_x = $o_y = 0;
	if ($i==0){
		$newwidth = $newheight = $width;
	}else
	if ($i==1){
		$newheight = $height;
		$newwidth = (float)($o_wd*$newheight/$o_ht);
		$o_x = $width - (float)(($newwidth-$width)/2);
	}else
	if ($i==2){
		$newwidth = $width;
		$newheight = (float)($o_ht*$newwidth/$o_wd);	
		$o_y = $height - (float)(($newheight-$height)/2);
	}
	$obj_temp = imageCreateTrueColor($width,$height);
	imageCopyResampled($obj_temp, $obj_image, 0, 0, $o_x, $o_y, $newwidth, $newheight, $o_wd, $o_ht);
	//if (file_exists($file_name)) @unlink($file_name);
	if ($obj_image_type=="jpg"){
		imagejpeg($obj_temp, $new_file_name, 100);
	}elseif ($obj_image_type=="gif"){
		imagegif($obj_temp, $new_file_name);
	}elseif ($obj_image_type=="png"){
		imagepng($obj_temp, $new_file_name);
	}
	return 1;
}
/**
 * Fetch content of an url use fsockopen
 *
 * @param 			: string $url
 * @return 			: string
 */
function fetchURL( $url ) {
	$url_parsed = parse_url($url);
	$host = $url_parsed["host"];
	$port = isset($url_parsed["port"])? $url_parsed["port"] : 80;
	if ($port==0) $port = 80;
	$path = $url_parsed["path"];
	if ($url_parsed["query"] != "")
		$path .= "?".$url_parsed["query"];

	$out = "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n";

	$fp = fsockopen($host, $port, $errno, $errstr, 30);

	fwrite($fp, $out);
	$body = false;
	$in = '';
	while (!feof($fp)) {
		$s = fgets($fp, 1024);
		if ( $body )
			$in .= $s;
		if ( $s == "\r\n" )
			$body = true;
	}
	 
	fclose($fp);
	 
	return $in;
}
/**
 * Upload image to server
 *
 * @param 			: string $fname, string $toDir, string $prefix, int $twidth, int $theight
 * @return 			: string
 */
function uploadImage(&$errors, $fname='', $toDir="", $prefix="", $twidth=160, $theight=160){
	global $core;
	$image = isset($_FILES[$fname])? $_FILES[$fname] : "";
	$valid = 1;
	if ($image["name"]!=""){
		$image_name = str_replace(' ', '', strtolower($image["name"]));
		if ($prefix!="") $image_name = $prefix."_".$image_name;
		$newpath_tmp = $toDir."/".$image_name;
		if(!isValidImage($image_name)) {
			$errors[$fname] = $core->getLang("Extension_is_not_allowed");
			$valid = 0;
		}else
		if (filesize($image['tmp_name']) > 1*1024*1024){
			$errors[$fname] = $core->getLang("File_size_is_invalid");
			$valid = 0;
		}else
		if ($image["tmp_name"]!="" && @move_uploaded_file($image["tmp_name"], $newpath_tmp)){
			if ($twidth>0 && $theight>0){
				resize_thumbs($newpath_tmp, $newpath_tmp, $twidth, $theight);
			}
			$errors['_uploaded_file_name'] = $image_name;
		}else{
			$errors[$fname] = $core->getLang("Cannot_upload_to_server");
			$valid = 0;
		}
	}
	return $valid;
}

/**
 * Upload image to server
 *
 * @param 			: string $fname, string $toDir, string $prefix, int $twidth, int $theight
 * @return 			: string
 */
function uploadArticleImage(&$errors, $fname='', $toDir="", $prefix="", $twidth=160, $theight=160){
	global $core;

	$image = isset($_FILES[$fname])? $_FILES[$fname] : "";
	$valid = 1;

	if ($image["name"]!=""){
		$image_name = str_replace(' ', '', strtolower($image["name"]));
		if ($prefix!="") $image_name = $prefix."_".$image_name;
		$newpath_tmp = $toDir."/".$image_name;

		if(!isValidImage($image_name)) {
			$errors['msg'] = $core->getLang("Extension_is_not_allowed");
			return 0;
		}

		if (filesize($image['tmp_name']) > 10*1024*1024){
			$errors['msg'] = $core->getLang("File_size_is_invalid");
			return 0;
		}

		if ($image["tmp_name"]!="" && @move_uploaded_file($image["tmp_name"], $newpath_tmp)){
			if ($twidth>0 && $theight>0){
				resize_thumbs($newpath_tmp, $newpath_tmp, $twidth, $theight);
			}
			$errors['_uploaded_file_name'] = $image_name;
		} else {
			$errors['msg'] = $core->getLang("Cannot_upload_to_server");
			$valid = 0;
		}
	}
	return $valid;
}
?>