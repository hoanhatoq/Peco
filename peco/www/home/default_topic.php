<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=topic
* Display Topic Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_topic(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Create new instance of Articles
	$clsArticles = new Articles();
	$clsTopics = new Topics();
	$curPage = GET("page", 0);
	$limit = 20;
	$start = $curPage*$limit;
	$topic_id = GET("ID", 0);
	if ($topic_id==0){
		$clsRewrite->error404();
	}
	//Get detail of current topic
	$topic = $clsTopics->getOne($topic_id);
	$assign_list["topic"] = $topic;
	//Get list of articles at topic page
	$arrListArticles = $clsArticles->getListByTopic($totalItem, $topic_id, 0, $limit);
	//begin paging
	require_once(DIR_COMMON."/clsPaging.php");
	$clsPaging = new Paging($curPage, $limit);
	$clsPaging->setBaseURL($clsRewrite->url_topic($topic));
	$clsPaging->setTotalRows($totalItem);
	$clsPaging->setShowStatstic(false);
	$clsPaging->setShowGotoBox(false);
	$clsPaging->showPageNums = 5;
	$assign_list["clsPaging"] = $clsPaging;
	$assign_list["totalItem"] = $totalItem;
	//end paging
	$assign_list["arrListArticles"] = $arrListArticles;	
	//Begin Seomoz
	if ($curPage==0) $prefix = $topic['name']." | "; else $prefix = $core->getLang("page")." ".($curPage+1)." | ".$topic['name']." | ";
	$assign_list["site_title"] = $prefix.$core->getLang("PECOPECO");
	$assign_list["meta_description"] =$topic['detail'];
	//End Seomoz
}
?>