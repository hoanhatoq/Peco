<?
/******************************************************
 * Admin Index File
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  index.php
 * Environment                :  PHP  version version 4, 5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/
error_reporting(E_ALL ^ E_DEPRECATED);
//Define _SITE_ROOT
define("SITE_ROOT", "admin");
//Include global file
require_once("../global.php");
//=================================================================================
//Definition constants
//=================================================================================
//Define Common Directory
define("DIR_ROOT", 					DIR_CMS."/".SITE_ROOT);
define("DIR_MODULES", 			DIR_ROOT."/modules");	
define("DIR_TEMPLATES",			DIR_ROOT."/templates");	
define("DIR_TEMPLATES_C", 	DIR_CMS."/www_c/".SITE_ROOT);
define("ADMIN_DIR_IMAGES", 	DIR_CMS."/".SITE_ROOT."/images");

//Define Common Url
define("ADMIN_URL_IMAGES",	URL_CMS."/".SITE_ROOT."/images");
define("ADMIN_URL_JS",			URL_CMS."/".SITE_ROOT."/js");
define("ADMIN_URL_CSS",			URL_CMS."/".SITE_ROOT."/css");

//=================================================================================
//Include needle file
//=================================================================================
//Core Requirement
require_once DIR_COMMON."/clsDbBasic.php";
require_once DIR_COMMON."/clsCoreAdmin.php";
require_once DIR_COMMON."/clsButtonNav.php";
require_once DIR_COMMON."/clsPaging.php";
require_once DIR_COMMON."/clsDataSource.php";
require_once DIR_COMMON."/clsDataGrid.php";
require_once DIR_COMMON."/clsModule.php";
//End Core Requirement

//Include all Classes in class directory
$arrClsCustom = array();
if (is_dir(DIR_CLASSES)){
	if ($dh = opendir(DIR_CLASSES)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file, -3)=='php')
			array_push($arrClsCustom, $file);
		}
		closedir($dh);
	}	
	foreach ($arrClsCustom as $file){
		require_once(DIR_CLASSES."/".$file);
	}
}

//Include all Function in lib directory
$arrLibCustom = array();
if (is_dir(DIR_LIB)){
	if ($dh = opendir(DIR_LIB)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file, -3)=='php')
			array_push($arrLibCustom, $file);
		}
		closedir($dh);
	}	
	foreach ($arrLibCustom as $file){
		require_once(DIR_LIB."/".$file);
	}	
}

//Initiation Driver ADODB
require_once(DIR_ADODB."/adodb.inc.php");
$dbconn = &ADONewConnection(DB_TYPE);
$dbconn->debug = ADODB_DEBUG;
$dbconn->SetFetchMode(ADODB_FETCH_ASSOC);
if (isset($dbinfo) && is_array($dbinfo)){
	$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
}else{
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

//Initialize Driver Smarty
require_once(DIR_SMARTY."/Smarty.class.php");	
$smarty = new Smarty;
$smarty->compile_check = COMPILE_CHECK;
$smarty->debugging = SMARTY_DEBUG;
$smarty->template_dir = DIR_TEMPLATES;
$smarty->compile_dir = DIR_TEMPLATES_C;
//$smarty->config_overwrite = true;

//Load Language
$_LANG_ID = getPOST("LANG_ID", 'jp');
if (file_exists(DIR_LANG."/".$_LANG_ID."/lang_backend.php")){
	require_once(DIR_LANG."/".$_LANG_ID."/lang_backend.php");
}
$smarty->assign("_LANG_ID", $_LANG_ID);
/*
 * =====================================================================
 * INITIATION SECTION  
 * =====================================================================
*/ 
$mod = $stdio->GET("mod" ,"default");
$core = new Core();
/*
 * =====================================================================
 * CONTROL SECTION  
 * =====================================================================
*/
//$array_lang = array();
//Include file control Dashboard
require_once("clsCPanel.php");
$clsCP = new ControlPanel();
//include header
require_once("_header.php");
//Include module by $mod (call modulde file)
require_once(DIR_MODULES."/$mod/index.php");
//include footer
require_once("_footer.php");
//Display template
$assign_list["mod"] = $mod;
$assign_list["core"] = $core;
$assign_list["clsCP"] = $clsCP;
//Assign $assign_list to Smarty & output
$smarty->assign($assign_list);
if ($smarty->template_exists("$mod.html")){
	$smarty->display("$mod.html");
}else{
	$smarty->display("index.html");
}
$dbconn->Close();

//Free memory
unset($assign_list, $clsCP, $core, $dbconn, $smarty);
?>