<?
/******************************************************
 * Class DbBasic
 *
 * Daatabase Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsDbBasic.php
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
class DbBasic{
	var $pkey 		= 	"";
	var $tbl 		= 	"";	
	var $arrCond 		= 	array();
	var $arrOperator 	=	array();
	var $arrError 	= 	array();
	var $hasError 	= 	0;
	var $objName	=	"ObjTable";
	function DbBasic(){
		//nothing
	}
	//Set debug mode On/Off
	function SetDebug($debug=true){
		global $dbconn;
		$dbconn->debug = $debug;
	}
	//set condition $cond + $operator(AND, OR)
	function SetCond($cond, $operator=""){
		array_push($this->arrCond, $cond);
		//if ($operator!=""){
			array_push($this->arrOperator, $operator);
		//}
	}
	//get contition string
	function GetCond(){
		$condStr = "";
//		echo "<pre>";
//		print_r($this->arrOperator);
//		echo "</pre>";
		if (is_array($this->arrCond)){
			foreach ($this->arrCond as $key => $val){
				$condStr.= " $val ".$this->arrOperator[$key];
			}
		}
		return $condStr;
	}
	//empty condition
	function EmptyCond(){
		$this->arrCond = array();
		$this->arrOperator = array();
	}
	//Select One
	function SelectOne($_pkey=""){
		global $dbconn;		
		//get condition
		$cond = $this->getCond();
		if ($cond==""){
			$pkey = $this->pkey;
			$pkeyvalue = $_pkey;
			$cond = ($pkeyvalue!="")? "".$pkey."='".$pkeyvalue."'" : "";
		}
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT * FROM ".$this->tbl." $where";
		$rs = $dbconn->Execute($sql); 
		$obj = new $this->objName;
		if ($rs){
			$arr = $rs->FetchRow();//get a row
			if (is_array($arr)){
				foreach ($arr as $key => $val){
					$obj->set($key, $val);
				}  		
			}
		}
		return $obj;		
	}
	//Select All
	function SelectAll($orderby="", $start=0, $limit=0){
		global $dbconn;
		//get condition
		$cond = $this->getCond();
		$where = ($cond!="")? " WHERE $cond" : "";
		$orderby = ($orderby!="")? "ORDER BY $orderby" : "";
		$limit = ($limit!="")? "LIMIT $start, $limit" : "";
		$sql = "SELECT * FROM ".$this->tbl." $where $orderby $limit";
		$rs = $dbconn->Execute($sql); 
		$arrObj = array();
		if ($rs){
			while ($arr = $rs->FetchRow()) { 
				$obj = new $this->objName; 
				foreach ($arr as $key => $val){
					$obj->set($key, $val);
				}  	
				array_push($arrObj, $obj);	
			} 
		}
		return $arrObj;				
	}
	//Insert obj
	function Insert($objTable){
		global $dbconn;
		$class_vars = get_class_vars(get_class($objTable));
		$fields = $values = "";
		//foreach ($class_vars as $name => $value) {
		foreach ($objTable->arrSet as $key => $name){
			$fields .= ($fields=="")? $name : ",".$name;
			$values .= ($values=="")? "'".$objTable->$name."'" : ",'".$objTable->$name."'";
		}
		$sql  = "INSERT INTO ".$this->tbl."($fields) VALUES($values)";
		if (!$dbconn->Execute($sql)){
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}		
		return 1;
	}
	//Update obj
	function Update($objTable){
		global $dbconn;
		$class_vars = get_class_vars(get_class($objTable));
		$set = "";
		//foreach ($class_vars as $name => $value) 
		foreach ($objTable->arrSet as $key => $name){
			$set .= ($set=="")? "$name = '".$objTable->$name."'" : ", $name = '".$objTable->$name."'";
		}
		//get condition
		$cond = $this->GetCond();
		if ($cond==""){
			$pkey = $this->pkey;
			$pkeyvalue = $this->$pkey;
			$cond = ($pkeyvalue!="")? "".$pkey."='".$pkeyvalue."'" : "";
		}
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "UPDATE ".$this->tbl." SET $set $where";
		if (!$dbconn->Execute($sql)){
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}
		return 1;				
	}
	//Delete obj
	function Delete(){
		global $dbconn;
		//get condition
		$cond = $this->GetCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "DELETE FROM ".$this->tbl." $where";
		if (!$dbconn->Execute($sql)){
			trigger_error("Cannot run SQL: `$sql", E_USER_ERROR);
			return 0;
		}
		return 1;		
	}
	//Count Item
	function Count($cond=""){
		global $dbconn;
		
		//get condition
		$cond = $this->GetCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT COUNT(*) AS total FROM ".$this->tbl." $where";
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 0;
		return $res['total'];
	}
	function Max($field, $cond=""){
		global $dbconn;
		
		//get condition
		$cond = $this->GetCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT MAX($field) AS total FROM ".$this->tbl.$where;
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 1;
		return ($res['total']+1);
	}
	function Min($field, $cond=""){
		global $dbconn;
		//get condition
		$cond = $this->GetCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT MIN($field) AS total FROM ".$this->tbl.$where;
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 1;
		return ($res['total']+1);
	}
	function Sum($field, $cond=""){
		global $dbconn;
		
		//get condition
		$cond = $this->GetCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT SUM($field) AS total FROM ".$this->tbl.$where;
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 0;
		return $res['total'];
	}
	//Execute a sql
	function ExecSql($sql){
		global $dbconn;
		return $dbconn->Execute($sql);
	}
	//=======================================
	//Integrate with old version
	//=======================================
	function getAll($cond=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT * FROM ".$this->tbl." $where";
		$res = $dbconn->GetAll($sql, false);
		if (count($res)>0){
			return $res;
		}else{
			return 0;
		}
	}
	function getOne($_pkey=""){
		global $dbconn;
		$sql = "SELECT * FROM ".$this->tbl." WHERE ".$this->pkey."='$_pkey'";
		$res = $dbconn->GetRow($sql, false);
		if (count($res)>0){
			return $res;
		}else{
			return 0;
		}
	}
	function getByCond($cond=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT * FROM ".$this->tbl." $where";
		$res = $dbconn->GetRow($sql, false);
		if (count($res)>0){
			return $res;
		}else{
			return 0;
		}
	}
	function getLastInsertId(){
		global $dbconn;
		$sql = "SELECT LAST_INSERT_ID() AS ID";
		$arr = $dbconn->GetRow($sql);
		return $arr['ID'];
	}
	//Insert
	function insertOne($fields="", $values=""){
		global $dbconn;
		if (count($fields)!=count($values))return 0;
		$sql  = "INSERT INTO ".$this->tbl."($fields) VALUES($values)";
		if (!$dbconn->Execute($sql)) return 0;
		
		return 1;
	}
	//Update
	function updateOne($_pkey="", $set=""){
		global $dbconn;
		if ($set=="") return;
		$sql = "UPDATE ".$this->tbl." SET $set WHERE ".$this->pkey."='$_pkey'";
		$dbconn->Execute($sql);
		return 1;
	}
	//Update by condition
	function updateByCond($cond="", $set=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "UPDATE ".$this->tbl." SET $set $where";
		$dbconn->Execute($sql);
		return 1;	
	}
	//Delete
	function deleteOne($_pkey=""){
		global $dbconn;
		$sql = "DELETE FROM ".$this->tbl." WHERE ".$this->pkey."='$_pkey'";
		$dbconn->Execute($sql);
		return 1;
	}
	function deleteByCond($cond=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "DELETE FROM ".$this->tbl." $where";
		$dbconn->Execute($sql);
		return 1;
	}
	function countItem($cond=""){
		global $dbconn;
		$sql = "SELECT COUNT(*) AS totalitem FROM ".$this->tbl;
		if ($cond!=""){
			$sql.= "  WHERE $cond";
		}
		$res = $dbconn->GetRow($sql, false);
		if ($res['totalitem']=="" || $res['totalitem']==null)
			return 0;
		return $res['totalitem'];
	}
	function maxItem($field, $cond=""){
		global $dbconn;
		$sql = "SELECT MAX($field) AS total FROM ".$this->tbl;
		if ($cond!=""){
			$sql.= " WHERE $cond";
		}
		
		$res = $dbconn->GetRow($sql, false);
		if ($res['total']=="" || $res['total']==null)
			return 1;
		return ($res['total']+1);
	}
	function sumItem($field, $cond=""){
		global $dbconn;
		$sql = "SELECT SUM($field) AS total FROM ".$this->tbl;
		if ($cond!=""){
			$sql.= " WHERE $cond";
		}
	
		$res = $dbconn->GetRow($sql, false);
		if ($res['total']=="" || $res['total']==null)
			return 0;
		return $res['total'];
	}
	function getByField($_pkey, $field){
		global $dbconn;
		$sql = "SELECT $field FROM ".$this->tbl." WHERE ".$this->pkey."='$_pkey'";
		$res = $dbconn->GetRow($sql, false);
		if (count($res)>0){
			return $res[$field];
		}else{
			return 0;
		}
	}	
	function getByFieldByCond($cond, $field){
		global $dbconn;
		$sql = "SELECT $field FROM ".$this->tbl." WHERE $cond";
		
		$res = $dbconn->GetRow($sql, false);
		if (count($res)>0){
			return $res[$field];
		}else{
			return 0;
		}
	}	
	function makeSelectHtml($selectName="", $fieldvalue="", $fieldoption="", $cond="", $selectedvalue="", $tag=true){
		$arrSelect = $this->getAll($cond);
		$html = "";
		if ($selectName=="") $selectName = $fieldvalue;
		if ($tag==true){
			$html.= "<select name=\"$selectName\"  id=\"$selectName\">";
		}		
		if (is_array($arrSelect)){
			foreach ($arrSelect as $k => $v){
				if (is_array($selectedvalue)){
					$selected = (in_array($v[$fieldvalue], $selectedvalue))? "selected" : "";
				}else{	
					$selected = ($v[$fieldvalue]==$selectedvalue)? "selected" : "";
				}
				$value = $v[$fieldvalue];
				$option = $v[$fieldoption];
				$html.= "<option value=\"$value\" $selected>".$option."</option>";
			}	
		}		
		if ($tag==true){
			$html.="</select>";
		}
		return $html;
	}
		
}

/**
*  Table Handling
*  @author		: JVB
*  @date		: 25/11/2006
*  @version		: 1.0.0
*/
class ObjTable{
	var $arrSet = array();
	//init class
	function ObjTable(){
		//nothing
	}
	//set value to field
	function set($field, $value){
		$this->$field = $value;
		array_push($this->arrSet, $field);
	}
	//get value from a field
	function get($field){
		return $this->$field;
	}
}
?>