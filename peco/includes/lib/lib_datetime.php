<?
/******************************************************
 * Library DateTime
 *
 * Contain datetime functions for project
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  lib_datetime.php
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
* Convert string to array if delimiter is : or ' '
*  
* @param 			: string $str
* @return 			: array
*/
function _getdatetime($str=""){
	$arr = array();
	if (strpos($str, ':')!==false && strpos($str, ' ')!==false){
		$arr = explode(' ', $str);
	}else{
		$arr[0] = $str;
	}
	return $arr;
}
/** 		
* Return total day between $start & $end
*  
* @param 			: string $str
* @return 			: array
*/
function getdayin($start, $end){//type Integer
	return round(($end-$start)/(24*60*60));
}
/** 		
* Return timestamp from string with standard format
*  
* @param 			: string $str, string $format
* @return 			: interger
*/
function mystrtotime($str="", $format="%m/%d/%Y %H:%M"){
	$str = trim($str);
	$format = trim($format);
	$arr1 = _getdatetime($str);
	$arr2 = _getdatetime($format);
	
	$date = array('m' => 0, 'd' => 0, 'Y' => 0);
	$a = @explode('/', $arr1[0]);
	$b = @explode('/', $arr2[0]);
	if (is_array($b))
	foreach ($b as $k => $v){ $v = str_replace('%', '', $v); $date[$v] = $a[$k]; }

	$time = array('H' => 0, 'M' => '0');
	if ($arr1[1]!=''){		
		$a = @explode(':', $arr1[1]);
		$b = @explode(':', $arr2[1]);
		if (is_array($b))
		foreach ($b as $k => $v){ $v = str_replace('%', '', $v); $time[$v] = $a[$k]; }
	}
	
	return @gmmktime($time['H'], $time['M'], 0, $date['m'], $date['d'], $date['Y']);
}
/** 		
* Return timestamp from string with 1 in 3 format
*  
* @param 			: string $str, string $format
* @return 			: interger
*/
function datetotime($str='02/10/2014', $format='dd/mm/YY'){/*dd/mm/YY*/
	$a = array();
	if (is_numeric($str) && $format!=='YYmmdd'){
		$a[0] = date('d', $str);
		$a[1] = date('m', $str);
		$a[2] = date('Y', $str);
	}else{
		if ($format=='dd/mm/YY'){
			$a = explode('/', $str);
		}else
		if ($format=='YYmmdd'){
			$a[2] = substr($str, 0, 4);
			$a[1] = substr($str, 4, 2);
			$a[0] = substr($str, -2);
		}
	}	
	return @gmmktime(1, 0, 0, $a[1], $a[0], $a[2]);
}
/** 		
* Return microtime of current
*  
* @param 			: no
* @return 			: float
*/
function microtime_float(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
/** 		
* Show date time by language
*  
* @param 			: no
* @return 			: float
*/
function dateformat($datetime){
	global $_LANG_ID;
	if ($_LANG_ID=='jp'){
		return date("Y/m/d", $datetime);
	}else
	if ($_LANG_ID=='en'){
		return date("m/d/Y", $datetime);
	}
	return date("d/m/Y", $datetime);
}
?>