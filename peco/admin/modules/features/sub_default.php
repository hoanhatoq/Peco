<?
function filter_thumbnail($c, $value, $pval, $row){
	if ($value=="") return "No Thumb";
	$html = "<img src='".URL_UPLOADS."/".$value."' style='max-height:160px; width:auto'>";	
	return $html;
}
function filter_disabled($c, $value, $pval, $row){	
	return ($value>0)? 'Y' : 'N';
}
/** 		
 * Module: [features]
 * Home function with $sub=default, $act=default
 * Display Features Management Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */
function default_default(){
	global $core, $assign_list, $mod;
	global $clsButtonNav;
	$classTable = "Features";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	//get _GET, _POST
	$curPage = GET("page", 0);
	$btnSave = POST("btnSave", "");
	$rowsPerPage = 50;	
	$return = (isset($_GET["return"]))? base64_decode($_GET["return"]) : "mod=$mod";
	$returnExp = "return=".base64_encode($_SERVER['QUERY_STRING']);

	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?mod=$mod&act=add&$returnExp",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?mod=$mod&act=delete", 1, "confirmDelete");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?");

	//################### CHANGE BELOW CODE ###################	
	$baseURL = "?mod=$mod";
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL($baseURL);
	$clsDataGrid->setDbTable($tableName, $cond);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->noJs = 1;
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setOrderBy("priority DESC");
	$clsDataGrid->setTitle($core->getLang("Features"));
	$clsDataGrid->setTitle2($core->getLang("Features_Management"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="gridtable"');
	$clsDataGrid->addColumnLabel("id", "特集id", "width='3%' align='left' nowrap");
	$clsDataGrid->addColumnLabel("title", "Title", "width='15%' align='left'");
	$clsDataGrid->addColumnLabel("short_title", "特集タイトル", "width='10%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("thumbnail", "特集サムネ画像", "width='5%' align='center' nowrap");
	$clsDataGrid->addColumnLabel("summary", "Summary", "width='auto' align='center'");
	$clsDataGrid->addColumnLabel("catch", "Catch", "width='auto' align='center'");
	$clsDataGrid->addColumnLabel("priority", "Priority", "width='5%' align='center'");
	$clsDataGrid->addColumnLabel("disabled", "特集ステータス", "width='5%' align='center'");
	$clsDataGrid->addColumnDate("created_at", "特集作成日", "width='8%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addColumnDate("updated_at", "最終更新日", "width='8%' align='center' nowrap", "%Y/%m/%d");
	$clsDataGrid->addFilter("thumbnail", "filter_thumbnail");
	$clsDataGrid->addFilter("disabled", "filter_disabled");
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
 * Module: [features]
 * Home function with $sub=default, $act=add
 * Add new feature
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
	$clsFeatures = new Features();
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?mod=$mod");
	$id = GET("id", 0);
	$arrOneFeature = array();
	if ($id>0){
		$arrOneFeature = $clsFeatures->getOne($id);
	}
	$btnSave = POST("btnSave", "");
	$errors = array();
	$valid = 1;
	if ($btnSave!=""){
		$valid = $clsFeatures->checkValidAddForm($errors);
		if ($valid){
			$valid = $clsFeatures->doAddRecord($errors);
			if ($valid){
				redirectURL("?mod=$mod");
				exit();
			}
		}
	}else
		if (is_array($arrOneFeature)){
		foreach ($arrOneFeature as $key => $val) {$_POST[$key] = $val;}
		$_POST["old_short_title"] = isset($arrOneFeature["short_title"])? $arrOneFeature["short_title"] : "";
		$_POST["old_thumbnail"] = isset($arrOneFeature["thumbnail"])? $arrOneFeature["thumbnail"] : "";
	}
	$assign_list['valid'] = $valid;
	$assign_list['errors'] = $errors;
	unset($clsFeatures);
}
/** 		
 * Module: [features]
 * Home function with $sub=default, $act=delete
 * Delete a exists feature
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