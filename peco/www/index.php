<?
/******************************************************
 * SubIndex File
 *
 * Run after index.php at root directory /
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  index.php
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
//Prevent run alone
if (!defined("DIR_CMS")){die("Access denied!");}

//Define var: Root & Modules
define("DIR_MODULES", 			DIR_CMS."/".WWW);//Module dir
//=================================================================================
//Include needle file
//=================================================================================
//Include core file
require_once DIR_COMMON."/clsDbBasic.php";
require_once DIR_COMMON."/clsCore.php";
require_once DIR_COMMON."/clsModule.php";

//Include all Classes in class directory
if (is_dir(DIR_CLASSES)){
	$arrClsCustom = array();
	if ($fp = opendir(DIR_CLASSES)) {
		while (($file = readdir($fp)) !== false) { if (substr($file, -3)=='php') array_push($arrClsCustom, $file); } closedir($fp);
	}	
	foreach ($arrClsCustom as $file){require_once(DIR_CLASSES."/".$file);}
}

//Include all Function in lib directory
if (is_dir(DIR_LIB)){
	$arrLibCustom = array();
	if ($fp = opendir(DIR_LIB)) {
		while (($file = readdir($fp)) !== false) { if (substr($file, -3)=='php') array_push($arrLibCustom, $file); } closedir($fp);
	}	
	foreach ($arrLibCustom as $file){require_once(DIR_LIB."/".$file);}	
}

//Initiation Driver ADODB
require_once(DIR_ADODB."/adodb.inc.php");
$dbconn = ADONewConnection(DB_TYPE);
$dbconn->debug = ADODB_DEBUG;
$dbconn->SetFetchMode(ADODB_FETCH_ASSOC);
$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

#Load SiteTheme
$_SITE_THEME = "pc";

/*
 * =====================================================================
 * INITIATION SECTION  
 * =====================================================================
*/ 
//Get module variable
$mod = $stdio->GET("mod" ,"home");

//Define some vars
define("DIR_IMAGES",					DIR_THEMES."/".$_SITE_THEME."/images");//images directory
define("DIR_CSS",						DIR_THEMES."/".$_SITE_THEME."/css");//css directory
define("DIR_JS",						DIR_THEMES."/".$_SITE_THEME."/js");//javascript directory
define("DIR_TEMPLATES",					DIR_THEMES."/".$_SITE_THEME);	//template directory of smarty
define("DIR_TEMPLATES_C", 				DIR_CMS."/".WWW."_c/".$_SITE_THEME);//compiled directory of smarty

//Define some URL vars with absolute path
define("URL_IMAGES",					URL_THEMES."/".$_SITE_THEME."/images");//full url of images
define("URL_CSS",						URL_THEMES."/".$_SITE_THEME."/css");//full url of css
define("URL_JS",						URL_THEMES."/".$_SITE_THEME."/js");//full url of js

//Include Smarty core & initialize Smarty
require_once(DIR_SMARTY."/Smarty.class.php");	
$smarty = new Smarty;
$smarty->compile_check = COMPILE_CHECK;
$smarty->debugging = SMARTY_DEBUG;
$smarty->template_dir = DIR_TEMPLATES;
$smarty->compile_dir = DIR_TEMPLATES_C;
$smarty->config_overwrite = true;

//Load Language
$_LANG_ID = LANG_DEFAULT;
$_LANG = array();
require_once(DIR_LANG."/$_LANG_ID/lang_frontend.php");
/*
 * =====================================================================
 * CONTROL SECTION  
 * =====================================================================
*/
//Initialize class Core
$core = new Core();
//Include module by $mod (call modulde file)
require_once(DIR_MODULES."/$mod/index.php");

//Get list of categories at homepage
$arrListTopics = Topics::getListAll(0, 500);
$assign_list["arrListTopics"] = $arrListTopics;
//Get list of top pickup
$arrListTopPickup = Pickup::getTopPickup(3);
$assign_list["arrListTopPickup"] = $arrListTopPickup;
//Get list of artile is top daily danking
$arrListTopDaily = Ranking::getTopDailyRanking(0, 5);
$assign_list["arrListTopDaily"] = $arrListTopDaily;
//Get list of recommend article
$arrListRecommendList = Ranking::getTopLifetimeRanking(5);
$assign_list["arrListRecommendList"] = $arrListRecommendList;


//Assign vars to $assign_list
$assign_list["URL_ICON"] = URL_ICON;
$assign_list["URL_ARTICLES"] = URL_ARTICLES;
$assign_list["URL_IMAGES"] = URL_IMAGES;
$assign_list["URL_UPLOADS"] = URL_UPLOADS;
$assign_list["URL_CSS"] = URL_CSS;
$assign_list["URL_JS"] = URL_JS;
$assign_list["URL_CMS"] = URL_CMS;
$assign_list["stdio"] = $stdio;
$assign_list["mod"] = $mod;
$assign_list["core"] = $core;
$assign_list["clsRewrite"] = $clsRewrite;

//Assign $assign_list to Smarty & output
$smarty->assign($assign_list);
if ($smarty->template_exists("$mod.htm")){
	$smarty->display("$mod.htm");
}else{
	$smarty->display("index.htm");
}
//Free memory
unset($core, $stdio, $smarty, $assign_list, $clsRewrite);
?>