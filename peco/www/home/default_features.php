<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=features
* Display Features Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_features(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Begin Seomoz
	$assign_list["site_title"] = $core->getLang("Features_list")." | ".$core->getLang("PECOPECO");
	//End Seomoz
}