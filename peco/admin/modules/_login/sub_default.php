<?
/** 		
 * Module: [_login]
 * Home function with $sub=default, $act=default
 * Display Login Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_default(){
	global $core, $assign_list, $smarty, $mod;
	$return = (isset($_GET["return"]))? base64_decode($_GET["return"]) : "";
	//check logged in
	if ($core->isLoggedin()){
		header("location: ?");
		exit();
	}
	$btnLogin = isset($_POST["btnLogin_x"])? $_POST["btnLogin_x"] : "";
	$txtUsername = isset($_POST["txtUsername"])? $_POST["txtUsername"] : "";
	$txtPassword = isset($_POST["txtPassword"])? $_POST["txtPassword"] : "";
	$isValid = 1;
	if ($btnLogin!=""){
		$isValid = ($txtUsername!="" && $txtPassword!="");
		if ($isValid){
			if ($core->checkUser($txtUsername, $txtPassword)){
				$isValid = 1;
				$core->doLogin($txtUsername, $txtPassword);
				header("location: ?$return");
				exit();
			}else{
				$isValid = 0;
			}
		}
	}
	
	$assign_list["btnLogin"] = $btnLogin;
	$assign_list["txtUsername"] = $txtUsername;
	$assign_list["isValid"] = $isValid;

	$assign_list["core"] = $core;
	$assign_list["ADMIN_URL_IMAGES"] = ADMIN_URL_IMAGES;
	$assign_list["ADMIN_URL_CSS"] = ADMIN_URL_CSS;
	$assign_list["ADMIN_URL_JS"] = ADMIN_URL_JS;
	$assign_list["URL_IMAGES"] = URL_IMAGES;
	$assign_list["URL_UPLOADS"] = URL_UPLOADS;
	
	$smarty->assign($assign_list);
	$smarty->display("$mod/index.html");
	exit();
}
/** 		
 * Module: [_login]
 * Home function with $sub=default, $act=logout
 * Logout from system
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_logout(){
	global $core, $assign_list;
	if ($core->isLoggedin()){
		$core->doLogout();		
	}
	header("location: ?mod=_login");
	exit();
}
?>