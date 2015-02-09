<?
/******************************************************
 * Global file, Init Session, Cooki
 * 
 * Define some variables & contants
 * Require some files and init some class
 * Refine input from POST, GET
 *
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  global.php
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
if (SITE_ROOT=="admin"){
	define("DIR_CMS", 				$_SERVER['DOCUMENT_ROOT'].trim(dirname(" ".dirname(" ".$_SERVER['SCRIPT_NAME']))));
	define("URL_CMS", 				"http://".$_SERVER['HTTP_HOST'].trim(dirname(" ".dirname(" ".$_SERVER['SCRIPT_NAME']))));
}else{
	define("DIR_CMS", 				$_SERVER['DOCUMENT_ROOT'].trim(dirname(" ".$_SERVER['SCRIPT_NAME'])));
	define("URL_CMS", 				"http://".$_SERVER['HTTP_HOST'].trim(dirname(" ".$_SERVER['SCRIPT_NAME'])));	
}
//=================================================================================
//Definition constants
//=================================================================================
#Common Directory Definition
define("DIR_INCLUDES", 				DIR_CMS."/includes");
define("DIR_CONFIGS", 				DIR_CMS."/configs");
define("DIR_LANG", 					DIR_CMS."/lang");
define("DIR_LOGS", 					DIR_CMS."/logs");
define("DIR_THEMES", 				DIR_CMS."/themes");
define("URL_THEMES", 				URL_CMS."/themes");//full url of themes
define("DIR_CACHE", 				DIR_CMS."/cache");
define("DIR_CLASSES", 				DIR_INCLUDES."/classes");
define("DIR_COMMON", 				DIR_INCLUDES."/common");
define("DIR_SMARTY", 				DIR_INCLUDES."/smarty");
define("DIR_ADODB", 				DIR_INCLUDES."/adodb");
define("DIR_LIB", 					DIR_INCLUDES."/lib");
define("DIR_PEAR", 					DIR_INCLUDES."/PEAR");
define("DIR_ICON",					DIR_CMS."/user/icon");//icon directory
define("URL_ICON", 					URL_CMS."/user/icon");//full url of icon
define("DIR_ARTICLES",				DIR_CMS."/article");//articles directory
define("URL_ARTICLES", 				URL_CMS."/article");//full url of articles
define("DIR_UPLOADS",				DIR_CMS."/uploads");//articles directory
define("URL_UPLOADS", 				URL_CMS."/uploads");//full url of uploads
define("FACEBOOK_SDK_V4_SRC_DIR", DIR_CMS."/Facebook/");//Facebook SDK Directory
//=================================================================================
//Include needle file
//=================================================================================
//Include database & contant file
require_once(DIR_CONFIGS."/contants.inc.php");
require_once(DIR_CONFIGS."/database.inc.php");

//Include handling & logging file
require_once DIR_COMMON."/clsLogging.php";
require_once DIR_COMMON."/jpErrorHandler.php";

//Include session controller file
require_once DIR_COMMON."/jpSession.php";
//Setup a session
if (!jpSessionSetup()) { trigger_error('Session setup failed', E_USER_ERROR); exit(); }
//Initialize a session
if (!jpSessionInit()) { trigger_error('Session initiation failed', E_USER_ERROR); exit(); }

//Include cookie controller file
require_once DIR_COMMON."/clsCookie.php";
//Setup a cookie
$clsCookie = new VnCookie($COOKIE_NAME, $COOKIE_TIME_OUT);

//Include Std In/Out file
require_once DIR_COMMON."/clsStdio.php";
//Refine variables: $_GET, $_POST
$stdio = new Stdio();
$_GET = $stdio->parse_incoming(true);
$_POST = $stdio->parse_incoming(false);

//Initialize an array globally which contain all variables to assigning to Smarty
$assign_list = array();
?>