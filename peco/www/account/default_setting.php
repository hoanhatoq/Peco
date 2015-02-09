<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=setting
 * Display SignUp Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_setting(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Check Authorization
	if ($core->isLoggedIn()==0){
		redirectURL($clsRewrite->url_signin());
		exit();
	}
	$clsUsers = new Users();
	$btnSubmit = POST("btnSubmit");
	$errors = array();
	$valid = 1;
	if ($btnSubmit=="Setting"){
		$valid = $clsUsers->checkValidSettingForm($errors);
		if ($valid){
			if ($clsUsers->doUpdateProfile($errors)){
				redirectURL($clsRewrite->url_setting());
				exit();
			}
		}
	}else{
		$_POST["email"] = $core->_USER["email"];
		$_POST["icon1"] = $core->_USER["icon"];
		$_POST["account_name"] = $core->_USER["account_name"];
		$_POST["introduction"] = $core->_USER["introduction"];
		$_POST["introduction_url"] = $core->_USER["introduction_url"];
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsUsers);
}

?>