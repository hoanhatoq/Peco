<?
/******************************************************
 * Class CoreAdmin
 *
 * Kernel class of application, start Session and do special actions
 * For admin page purpose
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsCoreAdmin.php
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
class Core{
	var $_REMOTE_ADDR   	= 	"";
	var $_USER						= 	array();
	//init
	function Core(){
		global $mod;
		//check module $mod
		if (!file_exists(DIR_MODULES."/$mod")){
			trigger_error("ModuleFile is not found!", E_USER_ERROR);
			exit();
		}
		$this->_REMOTE_ADDR   = 	$_SERVER['REMOTE_ADDR'];
		if ($this->isLoggedIn()){
			$this->_USER['username'] = jpSessionGetVar("USERNAME");
		}
	}
	/**
	 * Return Language value of var
	 *
	 * @param 			: string $key
	 * @return 			: string
	 */
	function getLang($key){
		global $_LANG;
		return (isset($_LANG[$key]) && $_LANG[$key]!="")? $_LANG[$key] : $key;
	}
	/** 		
	* Check is logged in or not
	*  
	* @param 			: no
	* @return 			: true of false
	*/
	function isLoggedIn(){
		return jpSessionGetVar("LOGGEDIN");
	}
	/** 		
	* Do login with email and password
	*  
	* @param 			: no
	* @return 			: true of false
	*/
	function doLogin($username="", $password=""){
		jpSessionSetVar("LOGGEDIN", 1);
		jpSessionSetVar("USERNAME", $username);
		jpSessionSetVar("PASSWORD", md5($password));
		return 1;
	}
	/** 		
	* Do login with email and password
	*  
	* @param 			: no
	* @return 			: true of false
	*/
	function doLogout(){
		jpSessionDelVar("LOGGEDIN");
		jpSessionDelVar("USERNAME");
		jpSessionDelVar("PASSWORD");
		return 1;
	}	
	/** 
	* Return exists or not of a template
	*  
	* @param 			: no
	* @return 			: string
	*/
	function template_exists($template){
		global $smarty;
		return $smarty->template_exists($template);
	}
	/** 		
	* call a function from smarty
	*  
	* @param 			: no
	* @return 			: string
	*/
	function call_func(){
		$numargs = func_num_args();
		$func_name = func_get_arg(0);
		$param_arr = array();
		for ($i=1; $i<$numargs; $i++)
			$param_arr[] = func_get_arg($i);
		return call_user_func_array($func_name, $param_arr);
	}
	/** 		
	* call a function from smarty
	*  
	* @param 			: no
	* @return 			: string
	*/
	function callfunc(){
		$numargs = func_num_args();
		$func_name = func_get_arg(0);
		$param_arr = array();
		for ($i=1; $i<$numargs; $i++)
			$param_arr[] = func_get_arg($i);
		return call_user_func_array($func_name, $param_arr);
	}
	/**
	 * check user admin is valid or not
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function checkUser($username="", $userpass=""){
		global $_ADMIN;
		return ($username==$_ADMIN['username'] && $userpass==$_ADMIN['userpass']);
	}
}
?>