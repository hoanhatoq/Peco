<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=resetpass
 * Display Reset Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_resetpass(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	if ($core->isLoggedIn()==1){
		header("location:".$clsRewrite->url_home());
		exit();
	}
	$token = GET("resetpass_token", "");
	$clsUsers = new Users();
	$clsToken = new Token();
	$btnSubmit = POST("btnSubmit");
	$errors = array();
	$valid = 1;
	if ($btnSubmit=="ResetPass"){
		$valid = $clsUsers->checkValidResetPassForm($errors);
		if ($valid){
			$email = $clsToken->getEmailByToken($token);
			if ($clsUsers->isExistsEmail($email)){
				$ok = $clsUsers->updateNewPassword($email);
				if ($ok){
					header("location:".$clsRewrite->url_signin());
					exit();
				}
			}else{
				$errors['token'] = "Token_is_not_exists_or_expired";
			}
		}
	}
	if (!$clsToken->verifyToken($token)){
		$errors['token'] = "Token_is_not_exists_or_expired";		
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsUsers);
}

?>