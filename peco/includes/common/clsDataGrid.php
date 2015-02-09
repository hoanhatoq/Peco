<?
/******************************************************
 * Class DataGrid
 *
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsDataGrid.php
 * Environment                :  PHP  version 4, 5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/
class DataGrid extends Paging{
	var $columns 			=	array();
	var $totalCols			=	0;	
	var $tableAttrib		=	"";
	var $headerClass		=	"gridheader";
	var $headerClass1		=	"gridheader1";
	var $gridrowClass		=	"gridrow";
	var $gridrowClass1		=	"gridrow1";
	var $gridrowClass2		=	"gridrow2";
	var $gridrowClass3		=	"gridrow3";
	//
	var $orderby 	= "";
	var $table 		= 	"";
	var $cond 		= 	"";
	var $query 		= 	"";
	var $queryc 	= 	"";
	var $pkey 		= 	"";
	var $dataGrid 	= 	"";
	var $title		=	"Title";
	var $title2		=	"Title2";
	var $showEditLink = 1;
	var $urlImage	= URL_UPLOADS;
	var $returnExp	=	"";
	var $action_add = "add";
	var $action_delete = "delete";
	var $noJs = 0;//default is 0 is display JS, 1 is no diplay JS
	var $noSort = 0;//default is 0 is display sortable, 1 is no diplay sortable
	//function
	function DataGrid($_curPage="", $_rowsPerPage=10){
		Paging::Paging($_curPage, $_rowsPerPage);
	}
	//function
	function setDbTable($_table, $_cond=""){
		$this->table = $_table;
		$this->cond = $_cond;
	}
	//function
	function setDbQuery($_query, $_queryc){
		$this->query = $_query;
		$this->queryc = $_queryc;
	}	
	//function
	function setTitle($_title){
		$this->title = $_title;
	}
	function setTitle2($_title){
		$this->title2 = $_title;
	}
	function setReturnExp($_returnExp){
		$this->returnExp = $_returnExp;
	}	
	//function
	function getTitle(){
		return $this->title;
	}
	function getTitle2(){
		return $this->title2;
	}
	//function
	function setPkey($_pkey){
		$this->pkey = $_pkey;
	}
	//function
	function setOrderBy($_orderby=""){
		$this->orderby = $_orderby;
	}
	//function
	function addColumnHidden($colname){
		$this->columns[] = array("colname"=>$colname, "coltype"=>"hidden", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function	
	function addColumnArray($colname, $coltitle="", $attrib="align='left'", $arr_format=""){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"array", "attrib"=>$attrib, "arr_format"=>$arr_format);
		$this->totalCols++;
	}
	//function	
	function addColumnLabel($colname, $coltitle="", $attrib="align='left'", $decode=1, $format=''){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"label", "attrib"=>$attrib, "decode"=>$decode, "format"=>$format);
		$this->totalCols++;
	}
	//function
	function addColumnText($colname,$coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"text", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnEmail($colname,$coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"email", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnUrl($colname, $coltitle="", $attrib="align='left'", $tagA="<a href='%1%' target='_blank'>%1%</a>"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"url", "attrib"=>$attrib, "tagA"=>$tagA);
		$this->totalCols++;
	}
	//function
	function addColumnImage($colname,$coltitle="", $imgattr="border:0", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"image", "imgattr"=>$imgattr, "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnCheckBox($colname,$coltitle="", $attrib="align='left'", $arrContants=""){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"checkbox", "attrib"=>$attrib, "arrContants"=>$arrContants);
		$this->totalCols++;
	}
	//function
	function addColumnSelect($colname,$coltitle="", $attrib="align='left'", $arrOptions="", $valueSameOption=0, $istext=0, $href=""){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"select", "attrib"=>$attrib, "arrOptions"=>$arrOptions, "valueSameOption"=> $valueSameOption, "istext" => $istext, "href"=>$href);
		$this->totalCols++;
	}
	//function
	function addColumnDate($colname, $coltitle="", $attrib="align='left'", $date_format="%m/%d/%Y"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"date", "attrib"=>$attrib, "date_format"=>$date_format);
		$this->totalCols++;
	}
	//function
	function addColumnAction($colname, $coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"action", "attrib"=>$attrib);
		$this->totalCols++;
	}
	function addFilter($colname, $func){
		$i = $this->findColumnIndex($colname);
		$this->columns[$i]['func'] = $func;
	}
	//function
	function showColumnArray($c, $value){
		$arr_format = $c['arr_format'];
		$arr_value = unserialize($value);
		$html = "";
		if (is_array($arr_format))
		foreach ($arr_format as $k => $v){
			$html.= '['.$v[0].']: '.$arr_value[$k]."<BR>";
		}
		return $html;
	}
	function showColumnLabel($c, $value){
		if (strlen($value)>300) $value = mb_substr($value, 0, 300)."...";
		if ($c['decode']==1) return htmlDecode($value);
		return $value;
	}
	//function
	function showColumnEmail($c, $value){
		return "<a href='mailto:$value'>".$value."</a>";
	}
	//function
	function showColumnUrl($c, $value){
		//$value.= "&return=".base64_encode($_SERVER['QUERY_STRING']);
		$tagA = str_replace("%1%", $value, $c["tagA"]);
		return $tagA;
	}
	//function
	function showColumnImage($c, $value){
		$html ="";
		$ext_allow = " .jpg, .jpeg, .gif, .png";
		$ext = strtolower(strrchr($value,"."));
		if ($value!="" && (@strpos($ext_allow, $ext)!==false)){
			if (file_exists(DIR_UPLOADS."/".$value)){
				$html = "<img src='".$this->urlImage."/$value' ".$c["imgattr"]." title='".$value."'>";
			}else{
				$html = "No Image";
			}
		}else
			$html = ($value=="")? "No Image" : $value;//strtoupper("$ext FILE");
		return $html;
	}
	//function
	function showColumnText($c, $value, $pval){
		$name = $c["colname"];
		$html = "<input type=\"text\" name=\"".$name."List[".$pval."]\" id=\"$name\" value=\"$value\" >\n";
		return $html;
	}
	//function
	function showColumnCheckBox($c, $value, $pval){
		return $value;
	}
	//function
	function showColumnSelect($c, $value, $pval=""){
		$html = "<select name='".$c["colname"]."List[".$pval."]' style='font-size:12px'>";
		if (is_array($c["arrOptions"])){
			foreach ($c["arrOptions"] as $key => $val){
				$val1 = ($valueSameOption==1)? $val : $key;
				$selected = ($val1==$value)? "selected" : "";
				if ($c["istext"]==1 && $val1==$value) {
					if ($c["href"]=="") return $val;
					else{
						$href = str_replace("%1%", $val1, $c["href"]);
						return "<a href='$href'>$val</a>";
					}
				}
				$html.= "<option value='$val1' $selected >$val</option>\n";
			}
		}
		$html.= "</select>";
		if ($c["istext"]==1) return "";
		return $html;
	}
	//function
	function showColumnDate($c, $value, $pval){
		if ($value=="" || $value=="0") return "N/A";
		return @strftime($c["date_format"], $value);
	}
	//function
	function showColumn($c, $value, $pval="", $row=""){
		$html = "";
		if ($c["func"]!=""){
			$html.= $c["func"]($c, $value, $pval, $row);
		}else{
			switch ($c["coltype"]){
				case "label"	: $html.= $this->showColumnLabel($c, $value); break;
				case "text"		: $html.= $this->showColumnText($c, $value, $pval); break;
				case "checkbox"	: $html.= $this->showColumnCheckBox($c, $value, $pval); break;
				case "select"	: $html.= $this->showColumnSelect($c, $value, $pval); break;
				case "date"		: $html.= $this->showColumnDate($c, $value, $pval); break;
				case "email"	: $html.= $this->showColumnEmail($c, $value, $pval); break;
				case "url"		: $html.= $this->showColumnUrl($c, $value, $pval); break;
				case "image"	: $html.= $this->showColumnImage($c, $value, $pval); break;
				case "array"	: $html.= $this->showColumnArray($c, $value); break;
			}
		}
		return $html;
	}
	function findColumn($colname){
		if (is_array($this->columns))
		foreach ($this->columns as $k => $v)
		if ($v['colname']==$colname){
			return $v;
		}	
		return 0;
	}
	function findColumnIndex($colname){
		if (is_array($this->columns))
		foreach ($this->columns as $k => $v)
		if ($v['colname']==$colname){
			return $k;
		}	
		return 0;
	}
	//function
	function setTableAttrib($_attrib=""){
		$this->tableAttrib = $_attrib;
	}
	//function
	function setHeaderClass($_headerClass, $_headerClass1){
		$this->headerClass = $_headerClass;
		$this->headerClass1 = $_headerClass1;
	}
	//function
	function showJS(){
		if ($this->noJs==1) return;
		$html="
<script language='javascript'>
function CheckAll() {
	 var fmobj = document.".$this->formName.";
	 var rowpp = ".$this->rowsPerPage.";
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
			 e.checked = fmobj.allbox.checked;
		 }
	 }
	 for (var i=0;i<rowpp;i++){
	 	toggle_grid_chk2(i);
	 }
	 return true;
}
function savecontinue(){
	document.".$this->formName.".btnSave.value= \"SaveContinue\";
	document.".$this->formName.".submit();
}
function save(){
	document.".$this->formName.".btnSave.value= \"Save\";
	document.".$this->formName.".submit();
}
function confirmDelete() {
	var total = 0;
	var fmobj = document.".$this->formName.";
	for (var i=0;i<fmobj.elements.length;i++) {
	 var e = fmobj.elements[i];
	 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
		 if (e.checked) total++;
	 }
	}
	if (total==0){ 
		alert('Choose at least 1 record!');
		return false;
	}
	if (confirm(\"Do you want to delete [OK]:Yes [Cancel]:No?\")) {
		document.".$this->formName.".action = \"".$this->baseURL."&act=".$this->action_delete."&".$this->returnExp."\";
		document.".$this->formName.".btnDelete.value= \"Delete\";
		document.".$this->formName.".submit();
		return true;
	}
	return false;
}
function confirmEdit() {
	var total = 0;
	var fmobj = document.".$this->formName.";
	var pvalue = 0;
	for (var i=0;i<fmobj.elements.length;i++) {
	 var e = fmobj.elements[i];
	 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
		 if (e.checked){ 
		 	total++;
			pvalue = e.value;
		 }
	 }
	}
	if (total==0 ){ 
		alert('Choose at least 1 record!');
		return false;
	}
	if (total>1 ){ 
		alert('Choose only 1 record!');
		return false;
	}
	window.location = \"".$this->baseURL."&act=".$this->action_add."&".$this->pkey."=\"+pvalue+\"&".$this->returnExp."\";
	return true;
}
function toggle_grid_chk(i){
    var x = document.getElementById('grid_chk_'+i);
    var tr = document.getElementById('grid_tr_'+i);
    if (x.checked==true){
		 x.checked=false
		 tr.setAttribute('bgColor', '#FFFFFF');
	}else{
		 x.checked=true
		 tr.setAttribute('bgColor', '#EEEEEE');
	}
}
function toggle_grid_chk2(i){
    var x = document.getElementById('grid_chk_'+i);
    var tr = document.getElementById('grid_tr_'+i);
    if (x.checked==true){
		 tr.setAttribute('bgColor', '#EEEEEE');
	}else{
		 tr.setAttribute('bgColor', '#FFFFFF');
	}
}
</script>"."\n";
		$html.= "<input type='hidden' name='btnSave' id='btnSave' value=''>"."\n";		
		$html.= "<input type='hidden' name='btnDelete' id='btnDelete' value=''>"."\n";
		return $html;
	}
	//function
	function showDataGrid($formName="", $startPage=0){
		global $core;
		if ($theForm=="") $theForm = $this->formName;
		$intStart = ($this->curPage-$startPage)*$this->rowsPerPage;
		$orderby = strtolower($this->orderby);		
		if (isset($_GET["sortby"])){
			$sortby = $_GET["sortby"];
			$stype = isset($_GET["stype"])? $_GET["stype"] : "ASC";
			$orderby = $this->orderby = strtolower($sortby." ".$stype);
		}
		if ($orderby==""){
			$orderby = $this->columns[0]["colname"];
		}
		//link to DataSource
		$clsDataSource = new DataSource();
		if ($this->table!=""){
			$clsDataSource->setDbTable($this->table, $this->cond);
		}else{
			$clsDataSource->setDbQuery($this->query, $this->queryc);
		}
		if ($this->pkey!=""){
			$clsDataSource->addField($this->pkey);
		}
		if (is_array($this->columns))
		foreach ($this->columns as $key => $val)
		if ($val['coltype']!='action'){
			$clsDataSource->addField($val["colname"]);
		}
		$this->totalRows = $clsDataSource->getTotalRows();
		$this->dataGrid = $clsDataSource->getDataGrid($this->orderby, $intStart, $this->rowsPerPage);		
		//output HTML
		$html = $this->showJS();
		$html.= '<table '.$this->tableAttrib.'>'."\n";
		$html.= '<tr>'."\n";
		if (is_array($this->columns)){
			$checkboxname = 'checkList';
			//Begin JVB Added 27/06/2010
			$html.= '<td width="1%" class="'.$this->headerClass.'"></td>';
			//End JVB Added
			if ($this->noJs==0){
				$html.= '<td width="1%" class="'.$this->headerClass.'"><input type="checkbox" name="allbox" value="0" onClick="return CheckAll()"/></td>'."\n";
			}
			foreach ($this->columns as $k => $v)
			if ($v['coltype']!="hidden"){
				$hclass = ($k<$this->totalCols-1)? $this->headerClass : $this->headerClass1;
				$html.= '<td '.$v['attrib'].' class="'.$hclass.'" >';
				if ($this->noSort==0){
					$html.= "<a href='".$this->baseURL."&page=".$this->curPage."&sortby=".$v["colname"].
							"' style='color:black' title='Sort by \"".$v['coltitle']."\"'>".$core->getLang($v['coltitle']).
							"</a>";
				}else{
					$html.= $core->getLang($v['coltitle']);
				}
				if (strpos($orderby, $v["colname"])!==false && $this->noSort==0){
					$sortby = $v["colname"];
					$stype = (strpos($orderby, "desc")===false)? "DESC" : "ASC";
					$stype_text = ($stype=="ASC")? "Ascending" : "Descending";
					$ordertype = (strpos($orderby, "desc")===false)? "up" : "down";
					$html.= "<a href='".$this->baseURL."&page=".$this->curPage.
							"&sortby=$sortby&stype=$stype' title='".$stype_text."'>".
							" <img src='".ADMIN_URL_IMAGES."/icon/sort_{$ordertype}.gif' border='0'>".
							"</a>";
				}
				$html.= "</td>"."\n";
			}
		}
		$html.= '</tr>'."\n";
		if (is_array($this->dataGrid)){
			$hasrow = 0;
			foreach ($this->dataGrid as $key => $val){
				$hasrow++;
				$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass : $this->gridrowClass2;
				$html.= '<tr id="grid_tr_'.$key.'">'."\n";
				//Begin JVB Added 27/06/2010
				$html.= "<td width='1%' class='$rclass' style='color:#666666'>".($key+$intStart+1)."</td>\n";
				//End JVB Added
				if ($this->noJs==0){
					$html.= '<td width="1%" class="'.$rclass.'"><input type="checkbox" id="grid_chk_'.$key.'" name="'.$checkboxname.'[]" value="'.$val->{$this->pkey}.'"  onclick="toggle_grid_chk2('.$key.')"/></td>'."\n";
				}
				foreach ($this->columns as $k => $v)
				if ($v['coltype']!="hidden"){
					$onclick = ($v['coltype']=="label")? 'onclick="toggle_grid_chk('.$key.')"' : '';
					if ($k<$this->totalCols-1){
						$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass : $this->gridrowClass2;	
					}else{
						$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass1 : $this->gridrowClass3;	
					}				
					if ($k==0 && $this->showEditLink==1){				
						$href = $this->baseURL.'&act='.$this->action_add.'&'.$this->pkey.'='.$val->{$this->pkey};
						$href.= "&return=".base64_encode($_SERVER['QUERY_STRING']);
						$html.= '<td '.$v['attrib'].' class="'.$rclass.'" '.$onclick.'><a href="'.$href.'">'.$this->showColumn($v, $val->$v['colname'], $val->{$this->pkey}, $val).'</a></td>'."\n";
					}else{
						$column_value = $this->showColumn($v, $val->$v['colname'], $val->{$this->pkey}, $val);
						if ($column_value=="") $column_value = "&nbsp;";
						$html.= '<td '.$v['attrib'].' class="'.$rclass.'" '.$onclick.' >'.$column_value.'</td>'."\n";
					}
				}
				$html.= '</tr>'."\n";	
			}
			if ($hasrow==0)
			$html.= '<tr><td colspan='.($this->totalCols+2)." style='font-size:12px; padding:5px'>"."<span style='color:#FF0000'>No data !</span>".'</td></tr>'."\n";
		}
		$html.= '</table>'."\n";
		return $html;
	}
	//function
	function saveData(){
		global $dbconn;
		foreach ($this->columns as $key => $val){
			$arrList = $_POST[$val["colname"]."List"];
			if (is_array($arrList))
			foreach ($arrList as $k => $v){
				$set = $val["colname"]."='".$v."'";
				$sql = "UPDATE ".$this->table." SET $set WHERE ".$this->pkey."='$k'";
				$dbconn->Execute($sql);
			}
		}
		return 1;
	}
}
?>