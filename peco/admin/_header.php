<?
/******************************************************
 * Admin Header File
 * Load before module file called
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  header.php
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
#Button Navigation
$clsButtonNav = new  ButtonNav();

$clsCP->addSection("articles", $core->getLang("Articles_Management"), "Articles_Management", "content.png");
	$clsCP->addLink("articles", "articles_default_default", $core->getLang("Articles_List"),"?mod=articles", "largeicon/news.png");
	$clsCP->addLink("articles", "articles_default_add", $core->getLang("Articles_Add_New"),"?mod=articles&act=add", "largeicon/news.png");

$clsCP->addSection("pickup", $core->getLang("Pickup_Management"), "Pickup_Management", "content.png");
	$clsCP->addLink("pickup", "pickup_default_default", $core->getLang("Pickup_List"),"?mod=pickup", "largeicon/pickup.png");
	$clsCP->addLink("pickup", "pickup_default_add", $core->getLang("Pickup_Add_New"),"?mod=pickup&act=add", "largeicon/pickup.png");

$clsCP->addSection("users", $core->getLang("Users_Management"), "Users_Management", "docs.png");
	$clsCP->addLink("users", "users_default_default", $core->getLang("Users_List"),"?mod=users", "largeicon/user.png");
	$clsCP->addLink("users", "users_default_add", $core->getLang("Users_Add_New"),"?mod=users&act=add", "largeicon/user.png");

$clsCP->addSection("topics", $core->getLang("Topics_Management"), "Topics_Management", "content.png");
	$clsCP->addLink("topics", "topics_default_default", $core->getLang("Topics_List"),"?mod=topics", "largeicon/tag.png");
	$clsCP->addLink("topics", "topics_default_add", $core->getLang("Topics_Add_New"),"?mod=topics&act=add", "largeicon/tag.png");

$clsCP->addSection("category", $core->getLang("Category_Management"), "Category_Management", "content.png");
	$clsCP->addLink("category", "category_default_default", $core->getLang("Category_List"),"?mod=category", "largeicon/folder.png");
	$clsCP->addLink("category", "category_default_add", $core->getLang("Category_Add_New"),"?mod=category&act=add", "largeicon/folder.png");
	
$clsCP->addSection("features", $core->getLang("Features_Management"), "Features_Management", "content.png");
	$clsCP->addLink("features", "features_default_default", $core->getLang("Features_List"),"?mod=features", "largeicon/feature.png");
	$clsCP->addLink("features", "features_default_add", $core->getLang("Features_Add_New"),"?mod=features&act=add", "largeicon/feature.png");

	
?>