<?
/******************************************************
 * Class Core
 *
 * Kernel class of application, start Session and do special actions
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsCore.php
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
		global $mod, $clsRewrite;
		//check module $mod
		if (!file_exists(DIR_MODULES."/$mod")){
			trigger_error("ModuleFile is not found!", E_USER_ERROR);
			exit();
		}
		$this->_REMOTE_ADDR   = 	$_SERVER['REMOTE_ADDR'];
		$clsUsers = new Users();
		if ($this->isLoggedIn()){
			$username = jpSessionGetVar("USERNAME");
			$fbid = jpSessionGetVar("FBID");
			$logintype = ($username!="")? 1 : ( ($fbid!="")? 2 : 0 );
			if ($logintype==0){
				$this->doLogout();
				header("location:".$clsRewrite->url_home());
				exit();
			}else
			if ($logintype==2){
				$this->_USER = $clsUsers->getByEmail(jpSessionGetVar("EMAIL"));
			}else{			
				$this->_USER = $clsUsers->getByEmail(jpSessionGetVar("USERNAME"));
			}
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
	* @param 				: no
	* @return 			: true of false
	*/
	function isLoggedIn(){
		return jpSessionGetVar("LOGGEDIN");
	}
	/** 		
	* Do login with email and password
	*  
	* @param 				: no
	* @return 			: true of false
	*/
	function doLogin($email="", $password=""){
		global $clsCookie, $COOKIE_USER, $COOKIE_PASS;
		if ($email=="") $email = POST("email");
		if ($password=="") $password = POST("password");
		$remember = POST("remember", 0);
		if ($remember==1){
			$clsCookie->putVar($COOKIE_USER, $email);
			$clsCookie->putVar($COOKIE_PASS, $password);
			$clsCookie->setVar();//save all cookie
		}else{
			$clsCookie->clearVar();
			$clsCookie->setVar();//save all cookie
		}
		jpSessionSetVar("LOGGEDIN", 1);
		jpSessionSetVar("USERNAME", $email);
		jpSessionSetVar("PASSWORD", Users::encrypt($password));
		return 1;
	}
	/** 		
	* Do login with email and password
	*  
	* @param 				: no
	* @return 			: true of false
	*/
	function doLoginFB($graphObject){
		global $clsCookie, $COOKIE_USER, $COOKIE_PASS;
		$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
		$fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
		$femail = $graphObject->getProperty('email');    // To Get Facebook email ID
		jpSessionSetVar("LOGGEDIN", 1);
		jpSessionSetVar("FBID", $fbid);
		jpSessionSetVar("EMAIL", $femail);
		jpSessionSetVar("FULLNAME", $fbfullname);
		return 1;
	}
	/** 		
	* Do login with email and password
	*  
	* @param 				: no
	* @return 			: true of false
	*/
	function doLogout(){
		jpSessionDelVar("LOGGEDIN");
		jpSessionDelVar("USERNAME");
		jpSessionDelVar("PASSWORD");
		
		jpSessionDelVar("FBID");
		jpSessionDelVar("EMAIL");
		jpSessionDelVar("FULLNAME");
		return 1;
	}
	/** 
	* Return exists or not of a template
	*  
	* @param 				: no
	* @return 			: string
	*/
	function template_exists($template){
		global $smarty;
		return $smarty->template_exists($template);
	}
	/** 		
	* call a function from smarty
	*  
	* @param 				: no
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
	* @param 				: no
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
}
?>