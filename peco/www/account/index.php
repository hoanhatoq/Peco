<?
/******************************************************
 * SubIndex File of module: [home]
 *
 * Control Module depend on 2 vars $sub, $act
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
//If run alone
if (!defined("DIR_CMS")){die("Access denied!");}

$sub = $stdio->GET("sub", "default");
$act = $stdio->GET("act", "default");
//Initialize class Module with param: $mod
$clsModule = new Module($mod);
//Call to run module (home, $sub, $act)
$clsModule->run($sub, $act);
//Assign vars to $assign_list
$assign_list["sub"] = $sub;
$assign_list["act"] = $act;	
?>