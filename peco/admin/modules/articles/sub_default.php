<?
function filter_title($c, $value, $pval, $row){
	$page_view = ($row->page_view>0)? $row->page_view : 0;
	$title = ($row->title!="")? $row->title : "タイトルを入力してください (下書き)";
	$html = "<div class='divtable'>";
	if ($row->status==0) $class="class='grey'";
	$html.= "<h3 $class >$title</h3><p><span class='text-left grey'>$page_view view</span><span class='text-right grey'>".$row->username."</span></p>";
	$html.= "</div>";
	return $html;
}
function get_status_text($value){
	global $core;
	if ($value==0) $status = 'Draft';
	if ($value==1) $status = 'Publish';
	if ($value==2) $status = 'Private';
	if ($value==3) $status = 'Disabled';
	return $core->getLang($status);
}
function filter_status($c, $value, $pval, $row){
	return get_status_text($value);
}
function filter_thumbnail_path($c, $value, $pval, $row){
	global $core;
	if ($value=="") return "N/A";
	$html = "<img src='".URL_ARTICLES."/".$value."' style='max-height:80px; width:auto'>";	
	return $html;
}
function filter_id_edit($c, $value, $pval, $row){
	$html = "<a href='?mod=articles&act=add&id=".$row->id."'>【編集】</a>";
	return $html;
}
function filter_list_topic_id($c, $value, $pval, $row){
	return Topic_Articles::getStringTopicIdFromArticle($row->id);
}
function filter_list_topic($c, $value, $pval, $row){
	return Topic_Articles::getStringTopicNameFromArticle($row->id);
}
/** 		
 * Module: [articles]
 * Home function with $sub=default, $act=default
 * Display Articles Management Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */
function default_default(){
	global $core, $assign_list, $mod;
	global $clsButtonNav;
	$classTable = "Articles";
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
	$s_article_id = POST("s_article_id", "");
	
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
	if ($s_article_id!="") $cond.= " AND a.id='$s_article_id'";
	//init Grid
	$query = "SELECT a.*, b.name AS username FROM articles AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				WHERE $cond 
				ORDER BY a.priority DESC, a.score DESC";
	$query_c = "SELECT COUNT(a.id) AS totalRows FROM articles AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				WHERE $cond";
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL($baseURL);
	$clsDataGrid->setDbQuery($query, $query_c);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->noJs = 1;
	$clsDataGrid->showEditLink = 0;
	$clsDataGrid->itemname = "Article";
	$clsDataGrid->setFormName("theForm");	
	$clsDataGrid->setTitle($core->getLang("Articles"));
	$clsDataGrid->setTitle2($core->getLang("Articles_Management"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="gridtable"');
	$clsDataGrid->addColumnLabel("id", "記事id", "width='2%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("created_by", "ユーザーid", "width='2%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("title", "記事タイトル、ライター名、view数", "width='auto' valign='top' align='left'");
	$clsDataGrid->addColumnAction("list_topic_id", "紐づけトピックid", "width='10%' align='center'");
	$clsDataGrid->addColumnAction("list_topic", "紐づけトピック名", "width='10%' align='center'");
	$clsDataGrid->addColumnLabel("thumbnail_path", "サムネ画像", "width='5%' align='center'");	
	$clsDataGrid->addColumnLabel("status", "ステータス", "width='3%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("priority", "優先", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("score", "スコア", "width='5%' align='center'");
	$clsDataGrid->addColumnDate("created_at", "登録日日", "width='8%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("updated_at", "最終更新日", "width='8%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addColumnAction("action1", "記事の紐づけ", "width='3%' align='center' nowrap");
	$clsDataGrid->addFilter("title", "filter_title");
	$clsDataGrid->addFilter("status", "filter_status");
	$clsDataGrid->addFilter("thumbnail_path", "filter_thumbnail_path");
	$clsDataGrid->addFilter("action1", "filter_id_edit");
	$clsDataGrid->addFilter("list_topic_id", "filter_list_topic_id");
	$clsDataGrid->addFilter("list_topic", "filter_list_topic");
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){			
		$clsDataGrid->saveData();		
		$query = $_SERVER['QUERY_STRING'];
		header("location: ?$query");
		exit();
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
}
/**		
 * Module: [articles]
 * Home function with $sub=default, $act=add
 * Add new article
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 
function default_add(){
	global $core, $assign_list, $mod;
	global $smarty, $clsButtonNav;
	$clsArticles = new Articles();	
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?mod=$mod");
	//Get Article ID from GET
	$ID = GET("id", 0);
	if ($ID==0){
		//Get new ID by insert new article record
		$ID = $clsArticles->getNewID();
		//Redirect to URL /add/ID
		redirectURL("?mod=articles&act=add&id=$ID");
		//echo "Article does not exits!";
		//exit();
	}	
	$article = $clsArticles->getDetail($ID);
	$btnSave = POST("btnSave", "");
	$errors = array();
	$valid = 1;
	if ($btnSave!=""){
		$_POST["article_id"] = $ID;
		$valid = Articles::checkValidAddForm($errors);
		if ($valid){
			$valid = Articles::doAddRecord($errors);
			if ($valid){
				redirectURL('?'.$_SERVER['QUERY_STRING']);
				exit();
			}
		}
	}else{
		if (is_array($article)){
			$_POST['article_id'] = $article['id'];
			$_POST['created_by'] = $article['created_by'];
			$_POST['list_topic_id'] = (isset($article['list_topic_id']))? $article['list_topic_id'] : "";
			$_POST['priority'] = $article['priority'];
			$_POST['score'] = $article['score'];
			$_POST['created_at'] = date("Y/m/d", $article['created_at']);
			$_POST['updated_at'] = date("Y/m/d", $article['updated_at']);
			$article['list_topic_id'] = $_POST['list_topic_id'] = $_POST['old_list_topic_id'] = Topic_Articles::getStringTopicIdFromArticle($article['id']);
		}
	}
	$article['status_text'] = get_status_text($article['status']);
	$article['list_topic_name'] = Topic_Articles::getStringTopicNameFromArticle($article['id']);
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	$assign_list["ARTICLE_ID"] = $ID;
	$assign_list["article"] = $article;
}
/** 		
 * Module: [articles]
 * Home function with $sub=default, $act=delete
 * Delete a exists article
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 
function default_delete(){
	global $core, $assign_list;
	//################### CAN NOT MODIFY BELOW CODE ###################
}
?>