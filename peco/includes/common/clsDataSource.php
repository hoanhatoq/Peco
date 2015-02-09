<?
/******************************************************
 * Class DataSource
 *
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsDataSource.php
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
class DataSource{
	var $table 		= 	"";
	var $cond 		= 	"";
	var $query 		= 	"";
	var $queryc 	= 	"";
	var $fields 	= 	array();
	function DataSource(){
		//nothing
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
	function addField($field){
		array_push($this->fields, $field);
	}
	//function
	function addFieldString($fieldStr=""){
		if (strpos($fieldStr, ",")!==false){
			$arr = explode(',', $fieldStr);
			if (is_array($arr))
			foreach ($arr as $key => $val){
				array_push($this->fields, trim($val));
			}
		}
	}
	//function
	function getFieldStr(){
		if (is_array($this->fields)){
			$str = "";
			foreach ($this->fields as $v){
				$str .= ($str=="")? "$v" : ", $v";
			}
		}
		return $str;
	}
	//function
	function getTotalRows(){
		global $dbconn, $_EX_TABLE;
		if ($this->table!=""){
			$where = ($this->cond!="")? " WHERE $this->cond" : "";
			$sql = "SELECT count(*) as totalRows FROM $this->table $where";
			$res = $dbconn->GetRow($sql);
			if ($res['totalRows']=="" && $res['totalRows']==null) return 0;
			return $res['totalRows'];
		}else
		if ($this->query!=""){
			$res = $dbconn->GetRow($this->queryc);
			if ($res['totalRows']!="" && $res['totalRows']!=null) return $res['totalRows'];
			if ($res[0]!="" && $res[0]!=null) return $res[0];
			return 0;
		}
	}
	//function
	function getDataGrid($orderby="", $start="", $limit=""){
		global $dbconn, $_EX_TABLE;
		if ($this->table!=""){
			$fieldStr = $this->getFieldStr();
			$where = ($this->cond!="")? " WHERE $this->cond" : "";
			$orderby = ($orderby!="")? "ORDER BY $orderby" : "";
			$limit = ($limit!="")? "LIMIT $start, $limit" : "";
			$sql = "SELECT $fieldStr FROM $this->table $where $orderby $limit";
			$rs = $dbconn->Execute($sql); 
			$arrObj = array();
			if ($rs){
				while ($obj = $rs->FetchNextObject(false)) {
					$obj1 = new ADOFetchObj; 
					foreach ($obj as $key => $val){
						$obj1->$key = $val;
					}  	
					array_push($arrObj, $obj1);	
				} 
			}
			//print_r($arrObj);
			return $arrObj;							
		}else
		if ($this->query!=""){					
			$orderby = ($orderby!="")? "ORDER BY $orderby" : "";
			$limit = ($limit!="")? "LIMIT $start, $limit" : "";
			$rs = $dbconn->Execute($this->query." $orderby $limit"); 
			$arrObj = array();
			if ($rs){
				while ($obj = $rs->FetchNextObject(false)) {
					$obj1 = new ADOFetchObj; 
					foreach ($obj as $key => $val){
						$obj1->$key = $val;
					}  	
					array_push($arrObj, $obj1);	
				} 
			}
			return $arrObj;
		}
		return 0;
	}	
}
?>