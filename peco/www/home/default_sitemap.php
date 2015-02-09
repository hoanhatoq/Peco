<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=sitemap
* Display Sitemap Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_sitemap(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Begin Seomoz
	$assign_list["site_title"] = $core->getLang("Sitemap")." | ".$core->getLang("PECOPECO");
	//End Seomoz
}