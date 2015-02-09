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
 * Module: [account]
 * Home function with $sub=default, $act=default
 * Display MyPage Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_default(){
	global $core, $assign_list, $mod, $sub, $act, $clsRewrite;
	//Check Authorization
	if ($core->isLoggedIn()==0){
		redirectURL($clsRewrite->url_signin());
		exit();
	}
	$current_user_id = $core->_USER['id'];
	//Create new Instance of Articles
	$clsArticles = new Articles();
	$curPage = GET("page", 0);
	$limit = 10;
	$start = $curPage*$limit;
	$arrListArticles = $clsArticles->getListByUser($totalItem, $current_user_id, 'ALL', $start, $limit);
	//begin paging
	require_once(DIR_COMMON."/clsPaging.php");
	$clsPaging = new Paging($curPage, $limit);
	$clsPaging->setBaseURL($clsRewrite->url_mypage());
	$clsPaging->setTotalRows($totalItem);
	$clsPaging->setShowStatstic(false);
	$clsPaging->setShowGotoBox(false);
	$clsPaging->showPageNums = 5;
	$assign_list["clsPaging"] = $clsPaging;
	$assign_list["totalItem"] = $totalItem;
	//end paging
	$arrListFavorites = array();
	$assign_list["arrListArticles"] = $arrListArticles;
	$assign_list["arrListFavorites"] = $arrListFavorites;
	//Begin Seomoz
	if ($curPage==0) $prefix = "マイページ | "; else $prefix = $core->getLang("page")." ".($curPage+1)." | マイページ | ";
	$assign_list["site_title"] = $prefix.$core->getLang("PECOPECO");
	//End Seomoz
}
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=favorites
 * Display Favorites Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_favorites(){
	global $core, $assign_list, $mod, $sub, $act;
}
?>