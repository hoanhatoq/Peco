<?
function filter_icon($c, $value, $pval, $row){
	if ($value=="") return "No Avatar";
	$html = "<img src='".URL_ICON."/".$value."'>";	
	return $html;
}
function filter_is_verified($c, $value, $pval, $row){
	$html = "Unverified";
	if ($value>0) $html = "OK";
	return $html;
}
function filter_is_receive_email($c, $value, $pval, $row){
	$html = "N";
	if ($value>0) $html = "Y";
	return $html;
}
function filter_total_article($c, $value, $pval, $row){
	$html = Users::getTotalPublishedArticle($row->id);
	return $html;
}
function filter_total_favorite($c, $value, $pval, $row){
	$html = Users::getTotalFavoriteArticle($row->id);
	return $html;
}
/** 		
 * Module: [users]
 * Home function with $sub=default, $act=default
 * Display Users Management Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */
function default_default(){
	global $core, $assign_list, $mod;
	global $clsButtonNav;
	$classTable = "Users";
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
	$s_user_id = POST("s_user_id", "");

	//init Button
	//$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("ExportCSV", "/icon/export2.png", "?mod=$mod&act=export&$returnExp",1);
	$clsButtonNav->set("New", "/icon/add2.png", "?mod=$mod&act=add&$returnExp",1);
	//$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	//$clsButtonNav->set("Delete", "/icon/delete2.png", "?mod=$mod&act=delete", 1, "confirmDelete");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?");

	//################### CHANGE BELOW CODE ###################	
	$baseURL = "?mod=$mod";
	$cond = "id>0";
	if ($s_keyword!="") $cond.= " AND name LIKE '%$s_keyword%'";
	if ($s_user_id!="") $cond.= " AND id='$s_user_id'";
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL($baseURL);
	$clsDataGrid->setDbTable($tableName, $cond);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->noJs = 1;
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setOrderBy("created_at DESC");
	$clsDataGrid->setTitle($core->getLang("Users"));
	$clsDataGrid->setTitle2($core->getLang("Users_Management"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="gridtable"');
	$clsDataGrid->addColumnLabel("name", "ライター名", "width='10%' align='left'");
	$clsDataGrid->addColumnLabel("account_name", "ステータス", "width='10%' align='left'");
	$clsDataGrid->addColumnLabel("id", "ユーザーid", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("icon", "サムネ画像", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("is_verified", "ステータス", "width='5%' align='center'");
	$clsDataGrid->addColumnAction("total_article", "公開記事数", "width='3%' align='center' nowrap");
	$clsDataGrid->addColumnAction("total_favorite", "お気に入り記事数", "width='3%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("introduction", "自己紹介文", "width='' align='center'");
	$clsDataGrid->addColumnUrl("introduction_url", "登録URL", "width='2%' align='center'");	
	$clsDataGrid->addColumnEmail("email", "メールアドレス", "width='10%' align='center'");
	$clsDataGrid->addColumnLabel("receive_email", "メルマガ有無", "width='5%' align='center' nowrap");
	$clsDataGrid->addColumnDate("created_at", "登録日日", "width='5%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("updated_at", "最終更新日", "width='5%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addFilter("icon", "filter_icon");
	$clsDataGrid->addFilter("is_verified", "filter_is_verified");
	$clsDataGrid->addFilter("receive_email", "filter_is_receive_email");
	$clsDataGrid->addFilter("total_article", "filter_total_article");
	$clsDataGrid->addFilter("total_favorite", "filter_total_favorite");
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
 * Module: [users]
 * Home function with $sub=default, $act=add
 * Add new user
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 
function default_add(){
	global $core, $assign_list, $mod;
	global $smarty, $clsButtonNav;
	//init Button
	$clsUsers = new Users();	
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?mod=$mod");
	$id = GET("id", 0);	
	$arrOneUser = array();
	if ($id>0){
		$arrOneUser = $clsUsers->getOne($id);		
	}
	$btnSave = POST("btnSave", "");
	$errors = array();
	$valid = 1;
	if ($btnSave!=""){
		$valid = $clsUsers->checkValidAddForm($errors);
		if ($valid){
			$valid = $clsUsers->doAddRecord($errors);
			if ($valid){
				redirectURL("?mod=$mod");
				exit();
			}
		}
	}else
		if (is_array($arrOneUser)){
		foreach ($arrOneUser as $key => $val) {$_POST[$key] = $val;}
		$_POST["old_name"] = isset($arrOneUser["name"])? $arrOneUser["name"] : "";
		$_POST["old_account_name"] = isset($arrOneUser["account_name"])? $arrOneUser["account_name"] : "";
		$_POST["old_email"] = isset($arrOneUser["email"])? $arrOneUser["email"] : "";
		$_POST["old_icon"] = isset($arrOneUser["icon"])? $arrOneUser["icon"] : "";
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsUsers);
}
/** 		
 * Module: [users]
 * Home function with $sub=default, $act=delete
 * Delete a exists user
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 
function default_delete(){
	global $core, $assign_list;
	
}
/**
 * Module: [users]
 * Home function with $sub=default, $act=export
 * Export list user to CSV
 *
 * @param 				: no params
 * @return 				: no need return
 * @exception
 * @throws
 */
function default_export(){
	global $core, $assign_list;
	$clsUsers = new Users();
	$arrListUsers = $clsUsers->getAll();
	$filename = "ListUsers.xls";
	require_once(DIR_INCLUDES."/PEAR/Spreadsheet/Excel/Writer.php");
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8, 'utf-8');
	$worksheet1 = &$workbook->addWorksheet('worksheet 1');
	$worksheet1->setInputEncoding('UTF-8');
	$x = 0;
	$row = array("No", "ライター名", "ステータス", "ユーザーid", "ステータス", "自己紹介文", "登録URL", "メールアドレス", "メルマガ有無", "登録日日", "最終更新日");
	$worksheet1->writeRow($x, 0, $row);
	if (is_array($arrListUsers))
	foreach ($arrListUsers as $k => $v){
		$x++;
		$row = array();
		$row[] = $x;//No
		$row[] = $v['name'];
		$row[] = $v['account_name'];
		$row[] = $v['id'];
		$row[] = $v['is_verified'];
		$row[] = $v['introduction'];
		$row[] = $v['introduction_url'];
		$row[] = $v['email'];
		$row[] = $v['receive_email'];
		$row[] = date("Y/m/d", $v['created_at']);
		$row[] = date("Y/m/d", $v['updated_at']);
		$worksheet1->writeRow($x, 0, $row);
	}
	$workbook->send($filename);
	$workbook->close();
	exit();
}
?>