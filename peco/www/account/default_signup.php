<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=signup
 * Display SignUp Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_signup(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Check Authorization
	if ($core->isLoggedIn()==1){
		redirectURL($clsRewrite->url_home());
		exit();
	}
	$clsUsers = new Users();
	$btnSubmit = POST("btnSubmit");
	$errors = array();
	$valid = 1;
	if ($btnSubmit=="Register"){
		$valid = $clsUsers->checkValidRegisterForm($errors);
		if ($valid){
			if ($clsUsers->doRegister()){
				$core->doLogin();
				redirectURL($clsRewrite->url_home());
				exit();
			}
		}
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsUsers);
}

?>