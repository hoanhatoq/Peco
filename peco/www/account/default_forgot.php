<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=forgot
 * Display Forgot Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_forgot(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Check Authorization
	if ($core->isLoggedIn()==1){
		redirectURL($clsRewrite->url_home());
		exit();
	}
	$clsUsers = new Users();
	$clsToken = new Token();
	$btnSubmit = POST("btnSubmit");
	$errors = array();
	$valid = 1;
	if ($btnSubmit=="Forgot"){
		$valid = $clsUsers->checkValidForgotForm($errors);
		if ($valid){
			$email = POST("email");
			$token = $clsToken->createToken($email);
			if ($token!=""){
				$url = $clsRewrite->url_resetpass($token);
				redirectURL($url);
				exit();
			}
		}
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsUsers);
}

?>