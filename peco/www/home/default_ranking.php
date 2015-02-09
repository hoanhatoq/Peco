<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=ranking
* Display Ranking Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_ranking(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Begin Seomoz
	$assign_list["site_title"] = $core->getLang("Ranking")." | ".$core->getLang("PECOPECO");
	//End Seomoz
}