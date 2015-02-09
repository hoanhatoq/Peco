<?
/******************************************************
 * Child Module of module [home]
 *
 * Contain functions of child module: [default], each function has prefix is 'default_'
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  index.php
 * Environment                :  PHP  version 4, 5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/

/** 		
 * Module: [home]
 * Home function with $sub=default, $act=default
 * Display Home Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_default(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Create new instance of Topics
	$clsTopics = new Topics();
	//Create new instance of Articles
	$clsArticles = new Articles();
	$curPage = GET("page", 0);
	$limit = 20;
	$start = $curPage*$limit;
	//Get list of articles at homepage
	$arrListArticles = $clsArticles->getListSummary($totalItem, $start, $limit);
	//begin paging
	require_once(DIR_COMMON."/clsPaging.php");
	$clsPaging = new Paging($curPage, $limit);
	$clsPaging->setBaseURL($clsRewrite->url_home());
	$clsPaging->setTotalRows($totalItem);
	$clsPaging->setShowStatstic(false);
	$clsPaging->setShowGotoBox(false);
	$clsPaging->showPageNums = 5;
	$assign_list["clsPaging"] = $clsPaging;
	$assign_list["totalItem"] = $totalItem;
	//end paging
	$assign_list["arrListArticles"] = $arrListArticles;
	//Begin Seomoz
	if ($curPage==0) $prefix = ""; else $prefix = $core->getLang("page")." ".($curPage+1)." | ";
	$assign_list["site_title"] = $prefix.$core->getLang("PECOPECO");
	//End Seomoz
}
/**
 * Module: [home]
 * Home function with $sub=default, $act=about
 * Display About Page
 *
 * @param 				: no params
 * @return 				: no need return
 */
function default_about(){
	global $smarty, $core, $stdio, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Assign vars to $assign_list
	$assign_list["URL_ICON"] = URL_ICON;
	$assign_list["URL_ARTICLES"] = URL_ARTICLES;
	$assign_list["URL_IMAGES"] = URL_IMAGES;
	$assign_list["URL_UPLOADS"] = URL_UPLOADS;
	$assign_list["URL_CSS"] = URL_CSS;
	$assign_list["URL_JS"] = URL_JS;
	$assign_list["URL_CMS"] = URL_CMS;
	$assign_list["stdio"] = $stdio;
	$assign_list["mod"] = $mod;
	$assign_list["core"] = $core;
	$assign_list["clsRewrite"] = $clsRewrite;
	$smarty->assign($assign_list);
	$smarty->display("about.htm");
	exit();
}
/**
 * Module: [home]
 * Home function with $sub=default, $act=rules
 * Display Rules Page
 *
 * @param 				: no params
 * @return 				: no need return
 */
function default_rules(){
	global $smarty, $core, $stdio, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Assign vars to $assign_list
	$assign_list["URL_ICON"] = URL_ICON;
	$assign_list["URL_ARTICLES"] = URL_ARTICLES;
	$assign_list["URL_IMAGES"] = URL_IMAGES;
	$assign_list["URL_UPLOADS"] = URL_UPLOADS;
	$assign_list["URL_CSS"] = URL_CSS;
	$assign_list["URL_JS"] = URL_JS;
	$assign_list["URL_CMS"] = URL_CMS;
	$assign_list["stdio"] = $stdio;
	$assign_list["mod"] = $mod;
	$assign_list["core"] = $core;
	$assign_list["clsRewrite"] = $clsRewrite;
	$smarty->assign($assign_list);
	$smarty->display("rules.htm");
	exit();
}
/**
 * Module: [home]
 * Home function with $sub=default, $act=privacy
 * Display Privacy Page
 *
 * @param 				: no params
 * @return 				: no need return
 */
function default_policy(){
	global $smarty, $core, $stdio, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Assign vars to $assign_list
	$assign_list["URL_ICON"] = URL_ICON;
	$assign_list["URL_ARTICLES"] = URL_ARTICLES;
	$assign_list["URL_IMAGES"] = URL_IMAGES;
	$assign_list["URL_UPLOADS"] = URL_UPLOADS;
	$assign_list["URL_CSS"] = URL_CSS;
	$assign_list["URL_JS"] = URL_JS;
	$assign_list["URL_CMS"] = URL_CMS;
	$assign_list["stdio"] = $stdio;
	$assign_list["mod"] = $mod;
	$assign_list["core"] = $core;
	$assign_list["clsRewrite"] = $clsRewrite;
	$smarty->assign($assign_list);
	$smarty->display("policy.htm");
	exit();
}
/**
 * Module: [home]
 * Home function with $sub=default, $act=contact
 * Display Contact Page
 *
 * @param 				: no params
 * @return 				: no need return
 */
function default_contact(){
	global $smarty, $core, $stdio, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Assign vars to $assign_list
	$assign_list["URL_ICON"] = URL_ICON;
	$assign_list["URL_ARTICLES"] = URL_ARTICLES;
	$assign_list["URL_IMAGES"] = URL_IMAGES;
	$assign_list["URL_UPLOADS"] = URL_UPLOADS;
	$assign_list["URL_CSS"] = URL_CSS;
	$assign_list["URL_JS"] = URL_JS;
	$assign_list["URL_CMS"] = URL_CMS;
	$assign_list["stdio"] = $stdio;
	$assign_list["mod"] = $mod;
	$assign_list["core"] = $core;
	$assign_list["clsRewrite"] = $clsRewrite;
	$smarty->assign($assign_list);
	$smarty->display("contact.htm");
	exit();
}
?>