<?
function filter_topic_thumbnail($c, $value, $pval, $row){
	if ($value=="") return "No Thumb";
	$html = "<img src='".URL_UPLOADS."/".$value."' style='max-height:80px; width:auto'>";	
	return $html;
}
function filter_display_flags($c, $value, $pval, $row){
	return ($value>0)? 'Y' : 'N';
}
function filter_id_edit1($c, $value, $pval, $row){
	$return = (isset($_GET["return"]))? base64_decode($_GET["return"]) : "mod=$mod";
	$returnExp = "return=".base64_encode($_SERVER['QUERY_STRING']);
	$html = "<a href='?mod=topics&act=add&id=".$row->id."&$returnExp' title='トピック編集 : ".$row->name."'>【編集】</a>";
	return $html;
}
function filter_id_edit2($c, $value, $pval, $row){	
	$return = (isset($_GET["return"]))? base64_decode($_GET["return"]) : "mod=$mod";
	$returnExp = "return=".base64_encode($_SERVER['QUERY_STRING']);
	$html = "<a href='?mod=topics&act=list_articles&topic_id=".$row->id."&$returnExp' title='記事の紐づけ: ".$row->name."'>【編集】</a>";
	return $html;
}
/** 		
 * Module: [topics]
 * Home function with $sub=default, $act=default
 * Display Topics Management Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */
function default_default(){
	global $core, $assign_list, $mod;
	global $clsButtonNav;
	$classTable = "Topics";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	//get _GET, _POST
	$curPage = GET("page", 0);
	$btnSave = POST("btnSave", "");
	$rowsPerPage = 20;	
	$return = (isset($_GET["return"]))? base64_decode($_GET["return"]) : "mod=$mod";
	$returnExp = "return=".base64_encode($_SERVER['QUERY_STRING']);
	$s_keyword = POST("s_keyword", "");
	$s_topic_id = POST("s_topic_id", "");

	//init Button
	//$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?mod=$mod&act=add&$returnExp",1);
	//$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	//$clsButtonNav->set("Delete", "/icon/delete2.png", "?mod=$mod&act=delete", 1, "confirmDelete");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?");

	//################### CHANGE BELOW CODE ###################	
	$baseURL = "?mod=$mod";
	$cond = "a.id>0";
	if ($s_keyword!="") $cond.= " AND a.name LIKE '%$s_keyword%'";
	if ($s_topic_id!="") $cond.= " AND a.id='$s_topic_id'";
	//init Grid
	$query = "SELECT a.*, b.name AS username FROM topics AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				WHERE $cond 
				ORDER BY a.priority DESC, a.score DESC";
	$query_c = "SELECT COUNT(a.id) AS totalRows FROM topics AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				WHERE $cond";
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL($baseURL);
	$clsDataGrid->setDbQuery($query, $query_c);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->noJs = 1;
	$clsDataGrid->showEditLink = 0;
	$clsDataGrid->itemname = "Topic";
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Topics"));
	$clsDataGrid->setTitle2($core->getLang("Topics_Management"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="gridtable"');	
	$clsDataGrid->addColumnLabel("id", "トピックid", "width='3%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("name", "トピック名", "width='12%' align='center'");
	$clsDataGrid->addColumnLabel("detail", "トピックリード文", "width='auto' align='center'");
	$clsDataGrid->addColumnLabel("thumbnail", "サムネ画像", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("path", "Path", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("priority", "優先", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("score", "スコア", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("total_article", "紐づけ記事数", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("display_flags", "トピックステータス", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("username", "クリエイタ", "width='5%' align='center'");
	$clsDataGrid->addColumnDate("created_at", "登録日日", "width='5%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("updated_at", "最終更新日", "width='5%' align='center' nowrap", "%Y/%m/%d");	
	$clsDataGrid->addColumnAction("action1", "トピック編集", "width='3%' align='center' nowrap");
	$clsDataGrid->addColumnAction("action2", "記事の紐づけ", "width='3%' align='center' nowrap");
	$clsDataGrid->addFilter("thumbnail", "filter_topic_thumbnail");
	$clsDataGrid->addFilter("display_flags", "filter_display_flags");
	$clsDataGrid->addFilter("action1", "filter_id_edit1");
	$clsDataGrid->addFilter("action2", "filter_id_edit2");
	//####################### ENG CHANGE ######################	
	$assign_list["clsDataGrid"] = $clsDataGrid;
}
/**		
 * Module: [topics]
 * Home function with $sub=default, $act=add
 * Add new topic
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 
function default_add(){
	global $core, $assign_list, $mod;
	global $smarty, $clsButtonNav;
	//Create new instance of Topics
	$clsTopics = new Topics();
	//init Button
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?mod=$mod");
	$id = GET("id", 0);
	$arrOneTopic = array();
	if ($id>0){
		$arrOneTopic = $clsTopics->getOne($id);
	}
	$btnSave = POST("btnSave", "");
	$errors = array();
	$valid = 1;
	if ($btnSave!=""){
		$valid = $clsTopics->checkValidAddForm($errors);
		if ($valid){
			$valid = $clsTopics->doAddRecord($errors);
			if ($valid){
				redirectURL("?mod=$mod");
				exit();
			}
		}
	}else
		if (is_array($arrOneTopic)){
			foreach ($arrOneTopic as $key => $val) {$_POST[$key] = $val;
		}
		$_POST["old_path"] = isset($arrOneTopic["path"])? $arrOneTopic["path"] : "";
		$_POST["old_thumbnail"] = isset($arrOneTopic["thumbnail"])? $arrOneTopic["thumbnail"] : "";
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsTopics);
}
function filter_title($c, $value, $pval, $row){
	$page_view = ($row->page_view>0)? $row->page_view : 0;
	$title = ($row->title!="")? $row->title : "タイトルを入力してください (下書き)";
	$html = "<div class='divtable'>";
	if ($row->status==0) $class="class='grey'";
	$html.= "<h3 $class >$title</h3><p><span class='text-left grey'>$page_view view</span><span class='text-right grey'>".$row->username."</span></p>";
	$html.= "</div>";
	return $html;
}
function filter_status($c, $value, $pval, $row){
	global $core;
	if ($value==0) $status = 'Draft';
	if ($value==1) $status = 'Publish';
	if ($value==2) $status = 'Private';
	if ($value==3) $status = 'Disabled';
	return $core->getLang($status);
}
function filter_thumbnail_path($c, $value, $pval, $row){
	global $core;
	if ($value=="") return "N/A";
	$html = "<img src='".URL_ARTICLES."/".$value."' style='max-height:80px; width:auto'>";
	return $html;
}
function filter_list_topic_id($c, $value, $pval, $row){
	return Topic_Articles::getStringTopicIdFromArticle($row->id);
}
function filter_list_topic($c, $value, $pval, $row){
	return Topic_Articles::getStringTopicNameFromArticle($row->id);
}
/**
 * Module: [topics]
 * Home function with $sub=default, $act=list_articles
 * List of articles in a topic
 *
 * @param 				: no params
 * @return 				: no need return
 * @exception
 * @throws
 */
function default_list_articles(){
	global $core, $dbconn, $assign_list, $clsRewrite, $mod;
	global $smarty, $clsButtonNav;
	$topic_id = GET("topic_id", 0);
	if ($topic_id==0){
		header("location: ?mod=$mod");
		exit();
	}
	$classTable = "Articles";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	//Create new instance of Topics
	$clsTopics = new Topics();
	//Get Topic topic_id
	$topic = $clsTopics->getOne($topic_id);
	//Get list of article of a topic_id
	$topic['list_article_id'] = Topic_Articles::getStringArticleIdFromTopic($topic_id);
	//If button SaveTopic click
	$btnSaveTopic = POST("btnSaveTopic", "");
	if ($btnSaveTopic!=""){
		$list_article_id = POST("list_article_id", "");
		$ok = Topic_Articles::addArticleListToTopic($topic_id, $list_article_id);
		if ($ok){
			Topic_Articles::updateTotalArticle($topic_id);
			redirectURL('?'.$_SERVER['QUERY_STRING']);
			exit();
		}
	}
	//init Button
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?mod=$mod");
	//get _GET, _POST
	$curPage = GET("page", 0);
	$btnSave = POST("btnSave", "");
	$rowsPerPage = 50;
	$return = (isset($_GET["return"]))? base64_decode($_GET["return"]) : "mod=$mod";
	$returnExp = "return=".base64_encode($_SERVER['QUERY_STRING']);
	//################### CHANGE BELOW CODE ###################
	$baseURL = "?mod=$mod";
	$cond = "ta.topic_id=$topic_id";
	//init Grid
	$query = "SELECT a.*, b.name AS username, ta.priority AS topic_article_priority, ta.score AS topic_article_score FROM articles AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				LEFT JOIN topic_articles AS ta ON a.id=ta.article_id
				WHERE $cond
				ORDER BY topic_article_priority DESC, topic_article_score DESC";
	$query_c = "SELECT COUNT(a.id) AS totalRows FROM articles AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				LEFT JOIN topic_articles AS ta ON a.id=ta.article_id
				WHERE $cond";
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL($baseURL);
	$clsDataGrid->setDbQuery($query, $query_c);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->noJs = 1;
	$clsDataGrid->showEditLink = 0;
	$clsDataGrid->itemname = "Article";
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Topics"));
	$clsDataGrid->setTitle2($core->getLang("Topics_Management"));
	$bgColor = "#F5F5F5";
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="gridtable"');
	$clsDataGrid->addColumnLabel("id", "記事id", "width='2%' align='center' nowrap bgcolor='$bgColor'");
	$clsDataGrid->addColumnLabel("created_by", "ユーザーid", "width='2%' align='center' nowrap bgcolor='$bgColor'");
	$clsDataGrid->addColumnLabel("title", "記事タイトル、ライター名、view数", "width='auto' align='left' bgcolor='$bgColor'");
	$clsDataGrid->addColumnAction("list_topic_id", "紐づけトピックid", "width='10%' align='center' bgcolor='$bgColor'");
	$clsDataGrid->addColumnAction("list_topic", "紐づけトピック名", "width='10%' align='center' bgcolor='$bgColor'");
	$clsDataGrid->addColumnLabel("thumbnail_path", "サムネ画像", "width='5%' align='center' bgcolor='$bgColor'");
	$clsDataGrid->addColumnLabel("status", "ステータス", "width='3%' align='center' nowrap bgcolor='$bgColor'");
	$clsDataGrid->addColumnLabel("priority", "優先", "width='5%' align='center' bgcolor='$bgColor'");
	$clsDataGrid->addColumnLabel("score", "スコア", "width='5%' align='center' bgcolor='$bgColor'");
	$clsDataGrid->addColumnDate("created_at", "登録日日", "width='8%' align='center' nowrap bgcolor='$bgColor'", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("updated_at", "最終更新日", "width='8%' align='center' nowrap bgcolor='$bgColor'", "%Y/%m/%d");
	$clsDataGrid->addColumnText("topic_article_score", "トピック内スコア", "width='5%' align='center' nowrap");
	$clsDataGrid->addFilter("title", "filter_title");
	$clsDataGrid->addFilter("status", "filter_status");
	$clsDataGrid->addFilter("thumbnail_path", "filter_thumbnail_path");
	$clsDataGrid->addFilter("list_topic_id", "filter_list_topic_id");
	$clsDataGrid->addFilter("list_topic", "filter_list_topic");
		//####################### ENG CHANGE ######################
	if ($btnSave!=""){
		$topic_article_scoreList = POST("topic_article_scoreList");
		if (is_array($topic_article_scoreList)){
			$ok = 1;
			foreach ($topic_article_scoreList as $article_id => $score){
				$ok = $ok * Topic_Articles::updateScore($article_id, $topic_id, $score);
			}
			if ($ok){
				redirectURL('?'.$_SERVER['QUERY_STRING']);
				exit();
			}
		}
	}
	
	$assign_list["topic"] = $topic;
	$assign_list["clsDataGrid"] = $clsDataGrid;
}
/** 		
 * Module: [topics]
 * Home function with $sub=default, $act=delete
 * Delete a exists topic
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 
function default_delete(){
	global $core, $assign_list;

}
?>