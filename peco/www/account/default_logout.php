<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=logout
 * Display SignUp Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_logout(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	$core->doLogout();
	redirectURL($clsRewrite->url_home());
	exit();
}

?>