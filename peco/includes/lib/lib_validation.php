<?
/******************************************************
 * Library Validation
 *
 * Contain validate functions for project
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  lib_validation.php
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
* Check a string is zero (0) or not?
*  
* @param 			: $num string
* @return 			: true of false
*/
function isZero($num=""){
	return ($num==0 || $num=='0' || $num=="0");
}
/** 		
* Check a string is null or not?
*  
* @param 			: $str string
* @return 			: true of false
*/
function isNull($str=""){
	return ($str=="" || $str==NULL || strlen($str)==0);
}
/**
 * Check a string is number or not?
 *
 * @param 			: $str string
 * @return 			: true of false
 */
function isNumber($str=""){
	if(preg_match('/^[0-9]+$/', $str)){
		return 1;
	}else{
		return 0;
	}
}
/** 		
* Check a string is valid length or not?
*  
* @param 			: $str string
* @return 			: true of false
*/
function isValidLength($str="", $min=3, $max=255){ 
	$len = strlen($str);
	return ($len>=$min && $len<=$max);
}
/** 		
* Check a string is correct email or not?
*  
* @param 			: $str string
* @return 			: true of false
*/
function isValidEmail($str=""){ 
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}
/** 		
* Check a string is valid username or not?
*  
* @param 			: $str string
* @return 			: true of false
*/
function isValidUserName($str=""){ 
	if(preg_match('/^[a-zA-Z0-9_]+$/', $str)){
		return 1;
	}else{
		return 0;
	}
}
/** 		
* Check a string is valid password or not?
*  
* @param 			: $str string
* @return 			: true of false
*/
function isValidPassword($str=""){ 
	return 1;
}

/**
 * Check image extension
 *
 * @param 			: $str string
 * @return 			: true of false
 */
function isValidImage($fname=""){
	$ext = strtolower(substr(strrchr($fname,"."), 1));
	if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif")
		return 1;
	return 0;
}
?>