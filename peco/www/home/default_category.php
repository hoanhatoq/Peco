<?php
/**
 * Module: [home]
* Home function with $sub=default, $act=category
* Display Category Page
*
* @param 				: no params
* @return 				: no need return
* @exception
* @throws
*/
function default_category(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Create new instance of Articles
	$clsArticles = new Articles();
	$clsCategories = new Categories();
	$start = 0;
	$limit = 50;
	$slug = GET("slug", "");
	$cat_id = $clsCategories->getIdFromSlug($slug);
	if ($cat_id==0){
		$clsRewrite->error404();
	}
	//Get list of articles at category page
	$arrListArticles = $clsArticles->getListByCategory($cat_id, 0, $limit);
	$assign_list["arrListArticles"] = $arrListArticles;	
	//Get detail of current category
	$category = $clsCategories->getOne($cat_id);
	$assign_list["category"] = $category;
}
?>