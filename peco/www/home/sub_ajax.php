<?
function ajax_default(){
	global $core, $assign_list, $mod, $sub, $act;
	exit();
}

/**
 * Module: [home] with $sub=ajax, $act=twitter
 * Run twitter command
 *
 * @param 				: string $url, string $key, string $action
 * @return 				: HTML
 */
function ajax_twitter(){
	global $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	require_once(DIR_COMMON."/clsTwitter.php");
	
	$url=$_GET['statusUrl'];
	$key=$_GET['keyword'];
	$action=$_GET['action'];
	if(!$action) exit();
	
	//$action = "search_tweet";
	//$url = "https://twitter.com/CustomCutting/status/560323503996813313";
	//$key = '?q=natural';
	
	$apiUrl = $_CONFIG['tweet_api'][$action];
	if(!$apiUrl) return;

	$process = new TwitterUtil($_CONFIG['auth_token']);
	
	if($action == 'search_tweet') {
		$res = $process->searchTweetById($apiUrl, $url);
	} elseif ($action == 'search_tweet_list') {
		$res = $process->searchTweetByKeyword($apiUrl, $key);
	} elseif ($action == 'search_user_timeline') {
		$res = $process->searchUserTimeline($apiUrl, $key);
	}
	
	echo $res;
	exit();
}
/**
 * Module: [home] with $sub=ajax, $act=getcomponents
 * Display component
 *
 * @param 				: string $c
 * @return 				: HTML
 */
function ajax_getcomponent(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	$c = GET("c", "");
	if ($c==""){ echo ""; exit();} 
	
	$smarty->assign("URL_IMAGES", URL_IMAGES);
	echo $smarty->fetch("components/".$c.".html");
	
	exit();
}
/**
 * Module: [home] with $sub=ajax, $act=savearticle
 * Save article content
 *
 * @param 				: 
 * @return 				: HTML
 */
function ajax_savearticle(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG, $clsRewrite;
	$arrError = array('error' => 0, 'msg' => '');
	$clsArticles = new Articles();
	$article_id = POST("article_id", 0);
	$title = POST("title", "");
	$detail = POST("detail", "");
	$status = POST("status", "");
	$thumbnail_src = POST("thumbnail_src", "");
	if ($article_id>0 && $title!=""){
		$ok = $clsArticles->updateTitleDetail($article_id, $title, $detail, $status);
		if ($ok){
			if ($thumbnail_src!=""){
				if(!filter_var($thumbnail_src, FILTER_VALIDATE_URL)){
					$ok = $clsArticles->saveImageBase64($article_id, $thumbnail_src);
				}else{
					$ok = $clsArticles->saveImageUrl($article_id, $thumbnail_src);
				}
			}
			if ($status=="preview"){
				$arrError['url_redirect'] = $clsRewrite->url_previewpost($article_id);
			}
			if ($status=="publish"){
				$arrError['url_redirect'] = $clsRewrite->url_publicpost($article_id);
			}
			if ($status==""){
				$arrError['url_redirect'] = $clsRewrite->url_postdetail($article_id);
			}
		}else{
			$arrError['error'] = 1;
			$arrError['msg'] = "Cannot insert DB";
		}
	}
	echo json_encode($arrError);
	exit();
}
/**
 * Module: [home] with $sub=ajax, $act=saveitem
 * Display component
 *
 * @param 				: string $c
 * @return 				: HTML
 */
function ajax_saveitem(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	$arrError = array('error' => 0, 'msg' => '');
	$clsArticles = new Articles();
	$arrJson = array();
	$ctype = POST("ctype", 0);
	$article_id = POST("article_id", 0);
	$priority = POST("priority", 1);
	$curItemId = POST("curItemId", 0);
	if ($article_id==0){
		$arrError['error'] = 1;
		$arrError['msg'] = "Article ID is null";
	}else
	if ($ctype==0){//Heading
		$arrJson['headingText'] 	=	addslashes(POST("headingText"));
		$arrJson['subHeadingText'] 	=	POST("subHeadingText");
		$arrJson['headingColor'] 	=	POST("headingColor");
	}else
	if ($ctype==1){//Text
		$arrJson['articleText']		=	POST("articleText");
		$arrJson['fontStyle']		=	POST("fontStyle");
	}else
	if ($ctype==2){//Image
		$arrJson['imageTitle']		=	POST("imageTitle");
		$arrJson['imageLink'] 		=	POST("imageLink");
		$arrJson['imageSourceTarget'] 	=	POST("imageSourceTarget");
		$arrJson['imageSource'] 	=	POST("imageSource");
		$arrJson['imageDesc'] 		=	POST("imageDesc");
		$arrJson['articleIsUpload'] =	POST("articleIsUpload");
	}else
	if ($ctype==3){//Quote
		$arrJson['articleQuote'] 	=	POST("articleQuote");
		$arrJson['articleQuoteSourceTarget'] 	=	POST("articleQuoteSourceTarget");
		$arrJson['articleQuoteSource'] 			=	POST("articleQuoteSource");
		$arrJson['articleQuoteComment'] 		=	POST("articleQuoteComment");		
	}else
	if ($ctype==4){//Link		
		$arrJson['siteTitleTarget'] =	POST("siteTitleTarget");
		$arrJson['siteTitle'] 		=	POST("siteTitle");
		$arrJson['siteLinkTarget'] 	=	POST("siteLinkTarget");
		$arrJson['siteLink'] 		=	POST("siteLink");
		$arrJson['siteDesc'] 		=	POST("siteDesc");
		$arrJson['siteThumb'] 		=	POST("siteThumb");
		$arrJson['siteThumbTarget'] =	POST("siteThumbTarget");
		$arrJson['siteComment'] 	=	POST("siteComment");
		$arrJson['siteImgs'] 		=	POST("siteImgs");
		$arrJson['imgPos'] 			=	POST("imgPos");
	}else
	if ($ctype==5){//Twitter		
		$arrJson['avatar'] 			=	POST("avatar");
		$arrJson['fullname'] 		=	POST("fullname");
		$arrJson['username'] 		=	POST("username");
		$arrJson['content'] 		=	POST("content");
		$arrJson['comment'] 		=	POST("comment");
		$arrJson['time'] 			=	POST("time");		
		$arrJson['imgTarget'] 		=	POST("imgTarget");
		$arrJson['imgSrc'] 			=	POST("imgSrc");
	}else
	if ($ctype==6){//Video
		$arrJson['videoEmbed']		=	POST("videoEmbed");
		$arrJson['videoSourceTarget'] 		=	POST("videoSourceTarget");
		$arrJson['videoTitle'] 		=	POST("videoTitle");
		$arrJson['videoComm'] 		=	POST("videoComm");
		$arrJson['videoId'] 		=	POST("videoId");		
	}
	$content = mysql_real_escape_string( json_encode($arrJson) );
	$itemId = $clsArticles->insertContent($curItemId, $article_id, $ctype, $priority, $content);
	$arrError['itemId'] = $itemId;	
	echo json_encode($arrError);
	exit();
}
/**
 * Module: [home] with $sub=ajax, $act=deleteitem
 * Delete content item
 *
 * @param 				: none
 * @return 				: HTML
 */
function ajax_deleteitem(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	$arrError = array('error' => 0, 'msg' => '');
	$clsArticles = new Articles();
	$arrJson = array();
	$itemId = POST("itemId", 0);
	if ($itemId>0){
		$ok = $clsArticles->deleteContent($itemId);
	}else{
		$arrError['error'] = 1;
		$arrError['msg'] = "Content ID is null";
	}
	echo json_encode($arrError);
	exit();
}
/**
 * Module: [home] with $sub=ajax, $act=updatepriority
 * Update priority of content items
 *
 * @param 				: none
 * @return 				: HTML
 */
function ajax_updatepriority(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	$arrError = array('error' => 0, 'msg' => '');
	$clsArticles = new Articles();
	$arrJson = array();
	$itemsOrder = POST("itemsOrder", 0);
	if (is_array($itemsOrder)){
		$ok = $clsArticles->updateContentPriority($itemsOrder);
	}else{
		$arrError['error'] = 1;
		$arrError['msg'] = "Something_wrong";
	}
	echo json_encode($arrError);
	exit();
}
/**
 * Module: [home] with $sub=ajax, $act=parser
 * Display content of an URL
 *
 * @param 				: string $url
 * @return 				: HTML
 */
function ajax_parser() {
	global $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	require_once(DIR_COMMON."/clsParser.php");
	
	$responses = array('error' => 0, 'msg' => '');
	$url=$_GET['url'];
	if(!$url) return;
	
	//$url = "http://en.wikipedia.org/wiki/Cat"; 
	//$url = "http://www.partition-tsuhan.com/";
	//$url = "http://peco-japan.com/";
	
	$parser = new Parser();
	$res    = $parser->processLink($url);
	
	if($res==null) {
		$responses['error'] = 1;
		$responses['msg'] = "Cannot get this link infomation";
	} else {
		$responses['error'] = 0;
		$responses['msg'] = $res;
	}
	echo json_encode($responses);
	exit();
}

/**
 * Module: [home] with $sub=ajax, $act=uploadimg
 * Upload image to server
 *
 * @param 				: string $url
 * @return 				: HTML
 */
function ajax_uploadimg() {
	global $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	require_once(DIR_LIB."/lib_file.php");

	$arrError = array('error' => 0, 'msg' => '');
	$article_id = POST("article_id", 0);
	$fname      = POST("fname", "");
	$prefix     = POST("prefix", "");
	$prefix     = $article_id."_".$prefix;

	if ($article_id==0 || $fname==""){
		$arrError['error'] = 1;
		$arrError['msg'] = "Article ID is null";
	} else {
		$res = uploadArticleImage($errors, $fname, DIR_ARTICLES, $prefix, 800, 600);
		if($res==0) {
			$arrError['error'] = 1;
			$arrError['msg'] = $errors["msg"];
		} else {
			$arrError['error'] = 0;
			$arrError['msg'] = URL_ARTICLES .'/'. $errors["_uploaded_file_name"];
		}
	}
	echo json_encode($arrError);
	exit();
}

/**
 * Module: [home] with $sub=ajax, $act=add_favorite
 * Update priority of content items
 *
 * @param 				: none
 * @return 				: HTML
 */
function ajax_add_favorite(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	if ($core->isLoggedIn()==0){
		$arrError['error'] = 1;
		$arrError['msg'] = "You_must_login";
	}else{
		$arrError = array('error' => 0, 'msg' => '');
		$article_id = POST("article_id", 0);
		if ($article_id>0){
			$ok = Favorites::addFavorites($article_id);
		}
		if (!$ok){
			$arrError['error'] = 1;
			$arrError['msg'] = "Something_wrong";
		}
	}
	echo json_encode($arrError);
	exit();
}

/**
 * Module: [home] with $sub=ajax, $act=getcomponents
 * Display article content
 *
 * @param 				: string $c
 * @return 				: HTML
 */
function ajax_getarticle(){
	global $smarty, $core, $assign_list, $mod, $sub, $act, $_CONFIG;
	
	$ID = POST("id", 0);
	if ($ID==0){
		echo "Article does not exits!";
		exit();
	}
	
	//Create new Instance of Articles
	$clsArticles = new Articles();
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

	$smarty->assign("URL_IMAGES", URL_IMAGES);
	$smarty->assign("URL_JS", URL_JS);
	$smarty->assign("ARTICLES", URL_ARTICLES);
	$smarty->assign("google_api", $_CONFIG['google_api']);
	$smarty->assign("ARTICLE_ID", $ID);
	$smarty->assign("arrOneArticle", $arrOneArticle);
	$smarty->assign("contentItems", $contentItems);
	$smarty->assign("ST_DRAFT", ST_DRAFT);
	$smarty->assign("ST_PUBLIC", ST_PUBLIC);
	$smarty->assign("ST_PRIVATE", ST_PRIVATE);
	$smarty->assign("ST_DISABLED", ST_DISABLED);

	echo $smarty->fetch("components/article_content.html");
	exit();
}
?>