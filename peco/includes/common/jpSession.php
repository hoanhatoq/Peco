<?
/******************************************************
 * Session Handling
 *
 * Contain functions: setup session, initialize session, get session, set session, destroy session
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  jpSession.php
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
$SESSION_NAME .= '_'.SITE_ROOT;

/**
 * Set up session handling
 */
function jpSessionSetup(){
	global $SESSION_NAME, $SESSION_COOKIE, $SESSION_TIME_OUT;
	$path = "/";
	$host = $_SERVER['HTTP_HOST'];
	$host = preg_replace('/:.*/', '', $host);
	$lifetime = 0;
	// Stop adding SID to URLs
	@ini_set('session.use_trans_sid', 0);
	// How to store data
	//@ini_set('session.serialize_handler', 'php');
	// Use cookie to store the session ID
	@ini_set('session.use_cookies', $SESSION_COOKIE);
	// Name of our cookie
	@ini_set('session.name', $SESSION_NAME);
	@session_name($SESSION_NAME);
	// Check each HTTP Referer
	@ini_set('session.referer_check', "$host");
	// Life time of cookie
	@ini_set('session.cookie_lifetime', $SESSION_TIME_OUT);
	@session_set_cookie_params($SESSION_TIME_OUT);
	// Auto-start session
	@ini_set('session.auto_start', 1);
	return true;
} 

/**
 * Initialise session
 */
function jpSessionInit($_sessid=""){
	global $SESSION_NAME;
	$ok = false;
	//echo session_name();
	//if (@ini_get('session.name')!=$SESSION_NAME) return false;
	if (@session_name()!=$SESSION_NAME){
		echo "<script language='javascript'>alert('Your session name is not valid!');</script>";
		return false;
	}
	if (!headers_sent()){
		header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
		header('Cache-control: private, max-age=0');
	}	
	if ($_sessid!=""){
		$sessid = session_id($_sessid);
		session_start();
	}else{
		session_start();
		$sessid = session_id();
	}
	return true;
} 

/**
 * Get a session variable
 * @param name $ name of the session variable to get
 */
function jpSessionGetVar($name){
	global $SESSION_NAME;
	//print_r($_SESSION);echo $name."<BR>";
    if(isset($_SESSION[$SESSION_NAME.'_'.$name])) {
        return $_SESSION[$SESSION_NAME.'_'.$name];
    }
    return false;
}

/**
 * Determine a session variable is set or not
 * @param name $ name of the session variable
 */
function jpSessionExist($name) {
	global $SESSION_NAME;
	if(isset($_SESSION[$SESSION_NAME.'_'.$name])) {
    return true;
  }
  return false;
}

/**
 * Set a session variable
 * @param name $ name of the session variable to set
 * @param value $ value to set the named session variable
 */
function jpSessionSetVar($name, $value){
	global $SESSION_NAME;
	$_SESSION[$SESSION_NAME.'_'.$name] = $value;
	return true;
} 

/**
 * Delete a session variable
 * @param name $ name of the session variable to delete
 */
function jpSessionDelVar($name){
	global $SESSION_NAME;
	jpSessionSetVar($name, '');
	unset($_SESSION[$SESSION_NAME.'_'.$name]);
	unset($GLOBALS[$SESSION_NAME.'_'.$name]);
	return true;
} 

?>
