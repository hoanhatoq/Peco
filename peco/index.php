<?
/******************************************************
 * Index File
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
//error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	ob_start("ob_gzhandler");
} else {
	ob_start();
}
//Setup site root & module dir
define("SITE_ROOT", "root");
define("WWW", "www");
//Include Global file
require_once("global.php");
//Include Class Rewrite for control URL Friendly
require_once("url_rewrite.php");
//Include SubIndex
require_once(DIR_CMS."/".WWW."/index.php");
?>