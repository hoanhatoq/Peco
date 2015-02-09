<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=curators
* Display Curators Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_curators(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Begin Seomoz
	$assign_list["site_title"] = $core->getLang("Curators_list")." | ".$core->getLang("PECOPECO");
	//End Seomoz
}