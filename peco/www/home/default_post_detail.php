<?
/** 		
 * Module: [home]
 * Home function with $sub=default, $act=post_detail
 * Display PostDetail Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function default_post_detail(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Check If preview mode
	$mode = GET("mode", "");
	$ID = GET("ID", 0);
	if ($mode=="preview"){
		//If not logged in then return 404 page
		if ($core->isLoggedIn()==0){
			redirectURL($clsRewrite->url_signin());
			exit();
		}
	}else{
		Ranking::updateDailyPV($ID);
	}
	//Create new instance of Articles
	$clsArticles = new Articles();
	//Get detail article from ID
	$article = $clsArticles->getDetail($ID);
	//If not valid article then return 404 page
	if (!is_array($article) || !$article['id']){
		$clsRewrite->error404();
	}
	//Check If preview mode
	if ($mode=="preview"){		
		$current_user_id = $core->_USER['id'];
		//If not author of this article then return 404 page
		if ($current_user_id!=$article['created_by']){
			$clsRewrite->error404();
		}
	}else
	if ($article['status']!=ST_PUBLIC){
		$clsRewrite->error404();
	}
	//Get list of content item from article ID
	$arrListContent = $clsArticles->getAllContent($ID);
	//If valid content items
	if (is_array($arrListContent)){
		$contentItems = "";
		foreach ($arrListContent as $key => $val){
			$val['content'] = str_replace("&quot;", '\"', $val['content']);
			$content = htmlDecode($val['content']);
			$arr = (array)json_decode($content);
			$articleItemId = "item".$val['id'];
			$smarty->assign("articleItemId", $articleItemId);
			$smarty->assign($arr);
			$itemHtml = "";
			if ($val['ctype']==0){//Heading
				$itemHtml = $smarty->fetch("components/z_heading.html");				
			}else
			if ($val['ctype']==1){//Text
				$itemHtml = $smarty->fetch("components/z_text.html");
			}else
			if ($val['ctype']==2){//Image
				$itemHtml = $smarty->fetch("components/z_image.html");				
			}else
			if ($val['ctype']==3){//Quote
				$itemHtml = $smarty->fetch("components/z_quote.html");
			}else
			if ($val['ctype']==4){//Link
				$itemHtml = $smarty->fetch("components/z_url.html");
			}else
			if ($val['ctype']==5){//Twitter				
				$itemHtml = $smarty->fetch("components/z_twitter.html");
			}else
			if ($val['ctype']==6){//Video
				$itemHtml = $smarty->fetch("components/z_video.html");
			}			
			//add to contentItems
			$contentItems .= $itemHtml;
		}
	}
	//Get list of related articles
	
	$arrListRelatedArticles = $clsArticles->getListByUser($totalItem, $article['created_by'], ST_PUBLIC, 0, 10);
	//Assign to smarty
	$assign_list["article"] = $article;
	$assign_list["arrListRelatedArticles"] = $arrListRelatedArticles;
	$assign_list["contentItems"] = $contentItems;
	$assign_list["mode"] = $mode;
	//Begin Seomoz
	$og = array();
	$og['title'] = $article['title'];
	$og['description'] = $article['detail'];
	$og['url'] = $clsRewrite->url_postdetail($ID);	
	$og['image'] = ($article['thumbnail_path']!="")? URL_ARTICLES."/".$article['thumbnail_path'] : URL_IMAGES."/noimage.png";
	$og['type'] = "article";
	$assign_list["og"] = $og;
	$assign_list["site_title"] = $article['title']." | ".$core->getLang("PECOPECO");
	$assign_list["meta_description"] = $article['detail'];
	//End Seomoz
}
?>