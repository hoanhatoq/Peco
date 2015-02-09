<?
/** 		
 * Module: [default]
 * Home function with $sub=default, $act=default
 * Display Dashboard Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_default(){
	global $core, $assign_list;
	if (!$core->isLoggedin()){
		header("location: ?mod=_login");
		exit();
	}
}
?>