<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=topics
* Display Topic list Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_topics(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Begin Seomoz
	$assign_list["site_title"] = $core->getLang("Topics_list")." | ".$core->getLang("PECOPECO");
	//End Seomoz
}