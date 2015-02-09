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
function filter_pickup_edit($c, $value, $pval, $row){
	$html = "<a href='?mod=pickup&act=add&id=".$row->id."'>【編集】</a>";
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
function filter_top_ok($c, $value, $pval, $row){
	return ($value>0)? 'Y' : 'N';
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
	$query = "SELECT a.*, b.name AS username, c.top_ok, c.pickup_order FROM articles AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				INNER JOIN article_pickups AS c ON a.id = c.id
				WHERE $cond 
				ORDER BY a.priority DESC, a.score DESC";
	$query_c = "SELECT COUNT(a.id) AS totalRows FROM articles AS a
				LEFT JOIN users AS b ON a.created_by=b.id
				INNER JOIN article_pickups AS c ON a.id = c.id
				WHERE $cond";
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL($baseURL);
	$clsDataGrid->setDbQuery($query, $query_c);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->noJs = 1;
	$clsDataGrid->showEditLink = 0;
	$clsDataGrid->itemname = "Article";
	$clsDataGrid->setFormName("theForm");	
	$clsDataGrid->setTitle($core->getLang("Pickup"));
	$clsDataGrid->setTitle2($core->getLang("Pickup_Management"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="gridtable"');
	$clsDataGrid->addColumnLabel("id", "記事id", "width='2%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("top_ok", "最上部OK", "width='2%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("created_by", "ユーザーid", "width='3%' align='center'");
	$clsDataGrid->addColumnLabel("title", "記事タイトル、ライター名、view数", "width='auto' align='left'");
	$clsDataGrid->addColumnAction("list_topic_id", "紐づけトピックid", "width='10%' align='center'");
	$clsDataGrid->addColumnAction("list_topic", "紐づけトピック名", "width='10%' align='center'");
	$clsDataGrid->addColumnLabel("thumbnail_path", "サムネ画像", "width='5%' align='center'");	
	$clsDataGrid->addColumnLabel("status", "ステータス", "width='3%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("priority", "優先", "width='3%' align='center'");
	$clsDataGrid->addColumnLabel("score", "スコア", "width='3%' align='center'");
	$clsDataGrid->addColumnDate("created_at", "登録日日", "width='5%' align='center'", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("updated_at", "最終更新日", "width='5%' align='center'", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("from_date", "ピックアップ開始予約日", "width='5%' align='center'", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("to_date", "ピックアップ終了予約日", "width='5%' align='center'", "%Y/%m/%d");
	$clsDataGrid->addColumnAction("pickup_edit", "ピックアップ編集", "width='3%' align='center'");
	$clsDataGrid->addColumnAction("article_edit", "記事編集", "width='3%' align='center'");
	$clsDataGrid->addFilter("title", "filter_title");
	$clsDataGrid->addFilter("status", "filter_status");
	$clsDataGrid->addFilter("thumbnail_path", "filter_thumbnail_path");
	$clsDataGrid->addFilter("pickup_edit", "filter_pickup_edit");
	$clsDataGrid->addFilter("article_edit", "filter_id_edit");
	$clsDataGrid->addFilter("list_topic_id", "filter_list_topic_id");
	$clsDataGrid->addFilter("list_topic", "filter_list_topic");
	$clsDataGrid->addFilter("top_ok", "filter_top_ok");
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
	$id = GET("id", 0);
	//init Button
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?mod=$mod");
	$article = array();
	if ($id>0){
		$article = Pickup::getPickup($id);
	} 
	$btnSave = POST("btnSave", "");
	$errors = array();
	$valid = 1;
	if ($btnSave!=""){
		$valid = Pickup::checkValidAddForm($errors);
		if ($valid){
			$valid = Pickup::doAddRecord($errors);
			if ($valid){
				redirectURL("?mod=$mod");
				exit();
			}
		}
	}else{
		if (is_array($article)){
			$_POST['article_id'] = (isset($article['id']))? $article['id'] : 0;
			$_POST['from_date'] = $_POST['to_date'] = "";
			if (isset($article['from_date'])) $_POST['from_date'] = date("Y/m/d", $article['from_date']);
			if (isset($article['to_date'])) $_POST['to_date'] = date("Y/m/d", $article['to_date']);
			$_POST['top_ok'] = (isset($article['top_ok']))?  $article['top_ok'] : "";
			$_POST['pickup_order'] = (isset($article['pickup_order']))?  $article['pickup_order'] : "";
		}
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
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