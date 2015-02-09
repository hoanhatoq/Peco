<?php
/******************************************************
 * Class Favorites
*
* Favorites, page views Handling
*
* Project Name               :  PECO
* Package Name            		:
* Program ID                 :  class_Favorites.php
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
class Favorites{
	/**
	 * Check exists or not record of pv_ranking
	 *
	 * @param 			: string $article_id
	 * @return 			: true of false
	 */
	static function isExists($article_id=0){
		global $dbconn;
		$sql = "SELECT * FROM favorites WHERE article_id=$article_id";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['id']) && $row['id']>0)? $row : 0;
	}
	/**
	 * Add favorite
	 *
	 * @param 			: string $article_id
	 * @return 			: true of false
	 */
	static function addFavorites($article_id=0){
		global $dbconn, $core;
		$user_id = $core->_USER['id'];
		$created_at = $time();
		$updated_at = 0;
		$disabled = 0;
		$row = Favorites::isExists($article_id);
		if (!$row){
			$fields = "user_id, article_id, created_at, updated_at, disabled";
			$values = "$user_id, $article_id, $created_at, $updated_at, $disabled";
			$sql = "INSERT INTO favorites($fields) VALUES($values)";
			if (!$dbconn->Execute($sql)) return false;
		}else{
			$updated_at = time();
			$sql = "UPDATE favorites SET updated_at= WHERE id=".$row['id'];
			$dbconn->Execute($sql);
		}
		return true;
	}
}