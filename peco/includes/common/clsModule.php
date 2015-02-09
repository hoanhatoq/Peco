<?
/******************************************************
 * Class Module
 *
 * Run corsesponding function with there params: $mod, $sub, $act
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsModule.php
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
if (!defined("DIR_MODULES")){
	trigger_error("Cannot find constant 'DIR_MODULES'", E_USER_ERROR);	
	die();
}

class Module extends DbBasic{
	var $mod = "";//name of module
	var $path = DIR_MODULES;//path to module file
	var $arrSub = array();//array submod of module
	var $arrAct = array();//array action of submod
	var $errNo = 0;//error code
	var $requireLogin = 0;//0 is no need log in
	//function
	function Module($_mod="", $_path=""){	
		$this->pkey = "moduleid";
		$this->tbl = "module";
		if ($_mod!="")
			$this->mod = $_mod;
		if ($_path!="")
			$this->path = $_path;
		if (!is_dir($this->path."/".$this->mod)){
			//ModuleFolder is not exists
			$this->error404();
			exit();
		}
	}
	/** 		
	* Return page 404
	*  
	* @param 				: no
	* @return 			: no
	*/
	function error404() {
		header('HTTP/1.1 404 Not Found');
		header('Status: 404 Not Found');
		require DIR_CMS."/error404.php";
		exit();
	}
	//function
	function addSub($sub){
		array_push($this->arrSub, $sub);
		$this->arrAct[$sub] = array();
	}
	//function
	function addAct($sub, $act){
		array_push($this->arrAct[$sub], $act);
	}
	//function
	function existsSub($sub){
		return in_array($sub, $this->arrSub);
	}
	//function
	function existsAct($sub, $act){
		return in_array($act, $this->arrAct[$sub]);
	}
	//function
	function run($sub="default", $act="default"){
		global $default_permiss_name ;
		$this->addSub($sub);
		$this->addAct($sub, $act);
		if ($this->existsSub($sub) && $this->existsAct($sub, $act)){
			$file_mod_sub = $this->path."/".$this->mod."/sub_".$sub.".php";			
			if (file_exists($file_mod_sub)){
				require_once($file_mod_sub);
				$funcdef = $sub."_default";
				$func = $sub."_".$act;
				if (function_exists($func)){						
						$func();//call function sub_act()
				}else{
						$file_mod_act = $this->path."/".$this->mod."/".$sub."_".$act.".php";	
						if (file_exists($file_mod_act)){
							require_once($file_mod_act);
						}		
						if (function_exists($func)){
							$func();//call function sub_act()
						}else{
							//function sub_act() is not installed
							$this->error404();
							exit();					
						}
				}
			}else{
					//SubModule file is not exists	
					$this->error404();
					exit();					
			}
		}else{
				//not exists act of sub or act is not registered to sub
				$this->error404();
				exit();					
		}
	}	
}
?>