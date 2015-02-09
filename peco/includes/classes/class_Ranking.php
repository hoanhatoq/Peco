<?php
/******************************************************
 * Class Ranking
*
* Ranking, page views Handling
*
* Project Name               :  PECO
* Package Name            		:
* Program ID                 :  class_Ranking.php
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
class Ranking{
	/**
	 * Check exists or not record of pv_ranking
	 *
	 * @param 			: string $article_id, int $date
	 * @return 			: true of false
	 */
	static function isExistsDailyPV($article_id=0, $date=0){
		global $dbconn;
		$sql = "SELECT * FROM pv_ranking WHERE date=$date AND article_id=$article_id";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['id']) && $row['id']>0)? $row : 0;
	}
	/**
	 * Check exists or not record of page_views
	 *
	 * @param 			: string $article_id
	 * @return 			: true of false
	 */
	static function isExistsLifetimePV($article_id=0){
		global $dbconn;
		$sql = "SELECT * FROM page_views WHERE article_id=$article_id";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['id']) && $row['id']>0)? $row : 0;
	}
	/**
	 * Update page view for $article_id at $date
	 *
	 * @param 			: string $article_id, int $date, int $step
	 * @return 			: true of false
	 */
	static function updateDailyPV($article_id=0, $date=0, $step=1){
		global $dbconn;
		if ($date==0){
			$date = date('Ymd', time());
		}
		$row = Ranking::isExistsDailyPV($article_id, $date);
		if (!$row){
			$fields = "date, article_id, PV";
			$values = "$date, $article_id, $step";
			$sql = "INSERT INTO pv_ranking($fields) VALUES($values)";
			if (!$dbconn->Execute($sql)) return false;
		}else{
			$sql = "UPDATE pv_ranking SET PV = PV + $step WHERE id=".$row['id'];
			$dbconn->Execute($sql);
		}
		Ranking::updateLifetimePV($article_id, $step);
		return true;
	}
	/**
	 * Update page view for $article_id life time
	 *
	 * @param 			: string $article_id, int $date, int $step
	 * @return 			: true of false
	 */
	static function updateLifetimePV($article_id=0, $step=1){
		global $dbconn;
		$row = Ranking::isExistsLifetimePV($article_id);
		$updated_at = time();
		if (!$row){
			$fields = "article_id, page_view, updated_at";
			$values = "$article_id, $step, $updated_at";
			$sql = "INSERT INTO page_views($fields) VALUES($values)";
			return $dbconn->Execute($sql);
		}else{
			$sql = "UPDATE page_views SET updated_at = $updated_at, page_view = page_view + $step WHERE id=".$row['id'];
			$dbconn->Execute($sql);
		}
		return true;
	}
	/**
	 * Get list top daily ranking
	 *
	 * @param 			: int $limit
	 * @return 			: array
	 */
	static function getTopDailyRanking($date=0, $limit=10){
		global $dbconn;
		if ($date==0) $date = date('Ymd', time());
		$now = time();
		$cond = "a.status=".ST_PUBLIC." AND a.review_status>=0 AND b.date=$date";		
		$cond.= " ORDER BY a.priority DESC, a.score DESC, b.PV DESC";
		$cond.= " LIMIT 0, $limit";
		$sql = "SELECT a.*, b.PV, c.name AS username FROM articles AS a
				LEFT JOIN pv_ranking AS b ON a.id = b.article_id
				LEFT JOIN users AS c ON a.created_by = c.id
				WHERE $cond";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Get list top lifetime ranking
	 *
	 * @param 			: int $limit
	 * @return 			: array
	 */
	static function getTopLifetimeRanking($limit=10){
		global $dbconn;
		$now = time();
		$cond = "a.status=".ST_PUBLIC." AND a.review_status>=0";
		$cond.= " ORDER BY a.priority DESC, a.score DESC, b.page_view DESC";
		$cond.= " LIMIT 0, $limit";
		$sql = "SELECT a.*, b.page_view, c.name AS username FROM articles AS a
				LEFT JOIN page_views AS b ON a.id = b.article_id
				LEFT JOIN users AS c ON a.created_by = c.id
				WHERE $cond";
		return $dbconn->GetAll($sql);
	}
}