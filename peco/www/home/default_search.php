<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=search
* Display Search Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_search(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Begin Seomoz
	$assign_list["site_title"] = $core->getLang("Summary_list")." | ".$core->getLang("PECOPECO");
	//End Seomoz
}