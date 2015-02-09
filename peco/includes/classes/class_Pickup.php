<?php
/******************************************************
 * Class Pickup
 *
 * Pickup Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  class_Pickup.php
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
class Pickup{
	/**
	 * Check exists pickup or not
	 *
	 * @param 			: int $article_id
	 * @return 			: true of false
	 */
	static function isExists($article_id=0){
		global $dbconn;
		$sql = "SELECT * FROM article_pickups WHERE id=$article_id";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['id']) && $row['id']>0)? $row : 0;
	}
	/**
	 * Check validate add form
	 *
	 * @param 			: &$errors
	 * @return 			: true of false
	 */
	static function checkValidAddForm(&$errors){
		global $core;
		$article_id = POST("article_id");
		$top_ok = POST("top_ok");
		$from_date = POST("from_date");
		$to_date = POST("to_date");
		$ok = 1;
		if (isNull($article_id)){
			$errors['article_id'] = $core->getLang("Article_is_null");
			$ok = 0;
		}else{
			$row = Articles::isExists($article_id);
			if (!$row){
				$errors['article_id'] = $core->getLang("Article_is_not_exists");
				$ok = 0;
			}
		}
		if (isNull($top_ok)){
			$errors['top_ok'] = $core->getLang("Top_ok_is_null");
			$ok = 0;
		}
		if (isNull($from_date)){
			$errors['from_date'] = $core->getLang("From_date_is_null");
			$ok = 0;
		}
		if (isNull($to_date)){
			$errors['to_date'] = $core->getLang("To_date_is_null");
			$ok = 0;
		}
		if ($ok){
			$from_date = mystrtotime($from_date, "%Y/%m/%d");
			$to_date = mystrtotime($to_date, "%Y/%m/%d");
			if ($from_date > $to_date){
				$errors['from_date'] = $core->getLang("From_date_must_be_smaller_than_to_date");
				$ok = 0;
			}
		}
		return $ok;
	}
	/**
	 * Add or Update a pickup
	 *
	 * @param 			: int $article_id, int top_ok, int pickup_order, string from_date, string to_date
	 * @return 			: true of false
	 */
	static function doAddRecord(&$errors){
		global $dbconn, $core;
		$article_id = POST("article_id");
		$top_ok = POST("top_ok");
		$from_date = POST("from_date");
		$to_date = POST("to_date");
		$pickup_order = POST("pickup_order");
		$row = Pickup::isExists($article_id);
		if (!$row){
			$fields = "id, top_ok, pickup_order";
			$values = "$article_id, $top_ok, $pickup_order";
			echo $sql = "INSERT INTO article_pickups($fields) VALUES($values)";
			if (!$dbconn->Execute($sql)) return false;
		}else{
			$sql = "UPDATE article_pickups SET top_ok=$top_ok, pickup_order=$pickup_order WHERE id=".$row['id'];
			$dbconn->Execute($sql);
		}
		$from_date = mystrtotime($from_date, "%Y/%m/%d");
		$to_date = mystrtotime($to_date, "%Y/%m/%d");
		$sql = "UPDATE articles SET from_date=$from_date, to_date=$to_date WHERE id=$article_id";
		$dbconn->Execute($sql);
		return true;
	}
	/**
	 * Get exists pickup
	 *
	 * @param 			: int $article_id
	 * @return 			: array
	 */
	static function getPickup($article_id=0){
		global $dbconn;
		$sql = "SELECT a.*, ap.top_ok, ap.pickup_order FROM article_pickups AS ap
				INNER JOIN articles AS a ON ap.id = a.id
				WHERE ap.id = $article_id";
		return $dbconn->GetRow($sql);
	}
	/**
	 * Get top 3 pickup
	 *
	 * @param 			: int $limit
	 * @return 			: array
	 */
	static function getTopPickup($limit=3){
		global $dbconn;
		$now = time();
		$cond = "a.from_date <= $now AND a.to_date >= $now AND top_ok=1";
		$cond.= " ORDER BY ap.pickup_order DESC, a.priority DESC, a.score DESC";
		$cond.= " LIMIT 0, $limit";
		$sql = "SELECT a.*, ap.top_ok, ap.pickup_order, c.name AS username, d.page_view FROM article_pickups AS ap
				INNER JOIN articles AS a ON ap.id = a.id
				LEFT JOIN users AS c ON a.created_by = c.id
				LEFT JOIN page_views AS d ON a.id = d.article_id
				WHERE $cond";
		return $dbconn->GetAll($sql);
	}
}