<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=createpost
 * Display CreatePost Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
function removeTrailingCommas($json)
{
	$json=preg_replace('/,\s*([\]}])/m', '$1', $json);
	return $json;
}
function default_createpost(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $clsRewrite, $_CONFIG;
	//Check Authorization
	if ($core->isLoggedIn()==0){
		redirectURL($clsRewrite->url_signin());
		exit();
	}
	$current_user_id = $core->_USER['id'];
	//Create new Instance of Articles
	$clsArticles = new Articles();
	//Get Article ID from GET
	$ID = GET("ID", 0);
	
	/* $b = '{"avatar":"http:\/\/abs.twimg.com\/sticky\/default_profile_images\/default_profile_6_normal.png","fullname":"talkvn","username":"Talk Vietnam","content":"Hanoi youth offered chance to experience intangible cultural heritages: Taking part in the\u2026 &lt;a href=&quot;http:\/\/goo.gl\/fb\/qPFSgL&quot; rel=&quot;external&quot;&gt;goo.gl\/fb\/qPFSgL&lt;\/a&gt;","comment":"","time":"2015.01.28 12:09","imgTarget":"undefined","imgSrc":"undefined"}';
	$b = str_replace("&quot;", '\"', $b);
	$a = json_decode($b);
	print_r($a); */
	//If Article ID is null
	if ($ID==0){
		//Get new ID by insert new article record
		$ID = $clsArticles->getNewID();
		//Redirect to URL /add/ID
		redirectURL($clsRewrite->url_addID($ID));
	}else
	if ($clsArticles->checkValidID($ID, $current_user_id)){//Else if valid Article ID
		$arrOneArticle = $clsArticles->getOne($ID);
		$arrListContent = $clsArticles->getAllContent($ID); 
		if (is_array($arrListContent)){
			$contentItems = "";
			foreach ($arrListContent as $key => $val){
				$val['content'] = str_replace("&quot;", '\"', $val['content']);
				$content = htmlDecode($val['content']);
				$arr = (array)json_decode($content);
				$articleItemId = "item".$val['id'];
				if ($val['ctype']==0){//Heading					
					$articleItemText = $smarty->fetch("components/article_heading.html");
					if ($arr['headingText']!=""){
						$articleItemText = str_replace("[articleHeading]", $arr['headingText'], $articleItemText);
						$articleItemText = str_replace("[articleColor]", $arr['headingColor'], $articleItemText);
					}else{
						$articleItemText = str_replace("[articleHeading]", $arr['subHeadingText'], $articleItemText);
						$articleItemText = str_replace("[articleColor]", $arr['headingColor'], $articleItemText);
					}				
					$itemEditFunc = "onEditHeading(this)";	
				}else
				if ($val['ctype']==1){//Text					
					$articleItemText = $smarty->fetch("components/article_text.html");				
					$articleItemText = str_replace("[fontStyle]", $arr['fontStyle'], $articleItemText);
					$articleItemText = str_replace("[articleText]", $arr['articleText'], $articleItemText);	
					$itemEditFunc = "onEditText(this)";
				}else
				if ($val['ctype']==2){//Image
					$articleItemText = $smarty->fetch("components/article_image.html");
					$articleItemText = str_replace("[imageTitle]", $arr['imageTitle'], $articleItemText);
					$articleItemText = str_replace("[imageLink]", $arr['imageLink'], $articleItemText);
					$articleItemText = str_replace("[imageSourceTarget]", $arr['imageSourceTarget'], $articleItemText);
					$articleItemText = str_replace("[imageSource]", $arr['imageSource'], $articleItemText);
					$articleItemText = str_replace("[imageDesc]", $arr['imageDesc'], $articleItemText);
					$articleItemText = str_replace("[articleIsUpload]", $arr['articleIsUpload'], $articleItemText);
					$itemEditFunc = "onEditImageItem(this)";
				}else
				if ($val['ctype']==3){//Quote
					$articleItemText = $smarty->fetch("components/article_quote.html");
					$articleItemText = str_replace("[articleQuote]", $arr['articleQuote'], $articleItemText);
					$articleItemText = str_replace("[articleQuoteSourceTarget]", $arr['articleQuoteSourceTarget'], $articleItemText);
					$articleItemText = str_replace("[articleQuoteSource]", $arr['articleQuoteSource'], $articleItemText);
					$articleItemText = str_replace("[articleQuoteComment]", $arr['articleQuoteComment'], $articleItemText);
					$itemEditFunc = "onEditQuote(this)";
				}else
				if ($val['ctype']==4){//Link
					$articleItemText = $smarty->fetch("components/article_url.html");
					$articleItemText = str_replace("[siteTitleTarget]", $arr['siteTitleTarget'], $articleItemText);
					$articleItemText = str_replace("[siteTitle]", $arr['siteTitle'], $articleItemText);
					$articleItemText = str_replace("[siteLinkTarget]", $arr['siteLinkTarget'], $articleItemText);
					$articleItemText = str_replace("[siteLink]", $arr['siteLink'], $articleItemText);
					$articleItemText = str_replace("[siteDesc]", $arr['siteDesc'], $articleItemText);
					$articleItemText = str_replace("[siteThumb]", $arr['siteThumb'], $articleItemText);
					$articleItemText = str_replace("[siteThumbTarget]", $arr['siteThumbTarget'], $articleItemText);
					$articleItemText = str_replace("[siteComment]", $arr['siteComment'], $articleItemText);
					
					$siteImgs = $arr['siteImgs'];		
					$imgPos   = trim($arr['imgPos']);	
					$articleItemText = str_replace('value=""', 'value='.$siteImgs.'', $articleItemText);
					$articleItemText = str_replace("imgPos", 'imgPos" value="'.$imgPos."", $articleItemText);
					
					if ($arr['siteThumb']=="undefined" || $arr['siteThumb']==""){
						$articleItemText = str_replace("articleURLItemThumbView", 'articleURLItemThumbView" style="display:none"', $articleItemText);
					}
					
					$itemEditFunc = "onEditURLInfo(this)";
				}else
				if ($val['ctype']==5){//Twitter
					
					$articleItemText = $smarty->fetch("components/article_twitter.html");
					$articleItemText = str_replace("[avatar]", $arr['avatar'], $articleItemText);
					$articleItemText = str_replace("[fullname]", $arr['fullname'], $articleItemText);
					$articleItemText = str_replace("[username]", $arr['username'], $articleItemText);
					$articleItemText = str_replace("[content]", $arr['content'], $articleItemText);
					$articleItemText = str_replace("[comment]", $arr['comment'], $articleItemText);
					$articleItemText = str_replace("[time]", $arr['time'], $articleItemText);
					$articleItemText = str_replace("[imgSrc]", $arr['imgSrc'], $articleItemText);
					$articleItemText = str_replace("[imgTarget]", $arr['imgTarget'], $articleItemText);
					if ($arr['imgSrc']=="undefined" || $arr['imgSrc']==""){
						$articleItemText = str_replace("itemTweet01", 'itemTweet01" style="display:none"', $articleItemText);
					}
					if ($arr['comment']=="undefined" || $arr['comment']==""){
						$articleItemText = str_replace("articleTwitterComment", 'articleTwitterComment" style="display:none"', $articleItemText);
					}
					$itemEditFunc = "onEditTwitter(this)";
				}else
				if ($val['ctype']==6){//Video
					$articleItemText = $smarty->fetch("components/article_video.html");
					$articleItemText = str_replace("[videoEmbed]", $arr['videoEmbed'], $articleItemText);
					$articleItemText = str_replace("[videoSourceTarget]", $arr['videoSourceTarget'], $articleItemText);
					$articleItemText = str_replace("[videoTitle]", $arr['videoTitle'], $articleItemText);
					$articleItemText = str_replace("[videoComm]", $arr['videoComm'], $articleItemText);
					$articleItemText = str_replace("[videoId]", $arr['videoId'], $articleItemText);
					$itemEditFunc = "onEditVideoItem(this)";
				}
				$html = $smarty->fetch("components/article_element.html");
				$html = str_replace("[articleItemId]", $articleItemId, $html);
				$html = str_replace("[articleText]", $articleItemText, $html);
				$html = str_replace("[itemEditFunc]", $itemEditFunc, $html);
				//add to contentItems
				$contentItems .= $html;
			}
		}
	}else{//Else display error 404 page
		$clsRewrite->error404();
	}
	$assign_list["google_api"] = $_CONFIG['google_api'];
	$assign_list["ARTICLE_ID"] = $ID;
	$assign_list["arrOneArticle"] = $arrOneArticle;
	$assign_list["contentItems"] = $contentItems;
	$assign_list["ST_DRAFT"] = ST_DRAFT;
	$assign_list["ST_PUBLIC"] = ST_PUBLIC;
	$assign_list["ST_PRIVATE"] = ST_PRIVATE;
	$assign_list["ST_DISABLED"] = ST_DISABLED;
}

?>