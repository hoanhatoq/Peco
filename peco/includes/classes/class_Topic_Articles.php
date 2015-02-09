<?php
/******************************************************
 * Class Topics
 *
 * Topics Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  class_Topic_Articles.php
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
class Topic_Articles{
	/**
	 * Count total article of topic_id
	 *
	 * @param 			: string $topic_id
	 * @return 			: int total_article
	 */
	static function countTotalArticle($topic_id=0){
		global $dbconn;
		$sql = "SELECT COUNT(*) AS total_article
				FROM topic_articles AS a
				INNER JOIN articles AS b ON a.article_id = b.id
				WHERE topic_id=$topic_id AND b.status=".ST_PUBLIC;
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['total_article']))? $row['total_article'] : 0;
	}
	/**
	 * Get string list article_id from topic_id
	 *
	 * @param 			: string $topic_id
	 * @return 			: string
	 */
	static function getStringArticleIdFromTopic($topic_id){
		global $dbconn;
		$sql = "SELECT GROUP_CONCAT(article_id SEPARATOR ',') AS list_article_id FROM topic_articles WHERE topic_id=".$topic_id." ORDER BY article_id ASC";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['list_article_id']))? $row['list_article_id'] : 0;
	}
	/**
	 * Get string list topic_id from article_id
	 *
	 * @param 			: string $article_id
	 * @return 			: string
	 */
	static function getStringTopicIdFromArticle($article_id){
		global $dbconn;
		$sql = "SELECT GROUP_CONCAT(topic_id SEPARATOR ',') AS list_topic_id FROM topic_articles WHERE article_id=$article_id ORDER BY topic_id ASC";
		$row = $dbconn->GetRow($sql);
		return $row['list_topic_id'];
	}
	/**
	 * Get string list topic_name from article_id
	 *
	 * @param 			: string $article_id
	 * @return 			: string
	 */
	static function getStringTopicNameFromArticle($article_id){
		global $dbconn;
		$sql = "SELECT GROUP_CONCAT(t.name SEPARATOR ',') AS list_topic_name FROM topic_articles AS ta
				INNER JOIN topics AS t ON t.id = ta.topic_id
				WHERE ta.article_id=$article_id ORDER BY ta.topic_id ASC";
		$row = $dbconn->GetRow($sql);
		return $row['list_topic_name'];
	}
	/**
	 * Assign an article id to topic_id
	 *
	 * @param 			: string $article_id
	 * @return 			: true of false
	 */
	static function addArticleToTopic($topic_id=0, $article_id=0){
		global $dbconn;
		if (!Articles::isExists($article_id)) return 0;
		if (!Topics::isExists($topic_id)) return 0;
		$priority = 1;
		$score = 1;
		$created_by = 0;
		$updated_at = 0;
		$created_at = time();
		$fields = "topic_id, article_id, priority, score, created_by, updated_at, created_at";
		$values = "$topic_id, $article_id, $priority, $score, $created_by, $updated_at, $created_at";
		$dbconn->Execute("INSERT INTO topic_articles($fields) VALUES ($values)");
		return 1;
	}
	/**
	 * Assign list article id to topic_id
	 *
	 * @param 			: string $list_article_id
	 * @return 			: true of false
	 */
	static function addArticleListToTopic($topic_id=0, $list_article_id=""){
		global $dbconn;
		$arr_article_id = explode(',', $list_article_id);
		$ok = 1;
		if (is_array($arr_article_id)){
			Topic_Articles::deleteArticlesFromTopic($topic_id);
			foreach ($arr_article_id as $key => $val){
				$article_id = trim($val);
				if (!is_numeric($article_id)) continue;
				$ok = $ok * Topic_Articles::addArticleToTopic($topic_id, $article_id);
			}
		}
		return $ok;
	}
	/**
	 * Assign list topic id to article_id
	 *
	 * @param 			: string $list_topic_id
	 * @return 			: true of false
	 */
	static function addTopicListToArticle($article_id=0, $list_topic_id="", $old_list_topic_id=""){
		global $dbconn;
		if ($list_topic_id==$old_list_topic_id) return 1;
		$arr_topic_id = explode(',', $list_topic_id);
		$ok = 1;
		if (is_array($arr_topic_id)){
			Topic_Articles::deleteTopicsFromArticle($article_id);
			foreach ($arr_topic_id as $key => $val){
				$topic_id = trim($val);
				if (!is_numeric($topic_id)) continue;
				$ok = $ok * Topic_Articles::addArticleToTopic($topic_id, $article_id);
			}
			Topic_Articles::updateTotalArticle2($old_list_topic_id);
			Topic_Articles::updateTotalArticle2($list_topic_id);
		}
		return $ok;
	}
	/**
	 * Update Score of topic_id & article_id
	 *
	 * @param 			: int $article_id, int $topic_id, int $score
	 * @return 			: true of false
	 */
	static function updateScore($article_id=0, $topic_id=0, $score=0){
		global $dbconn;
		$updated_at = time();
		$sql = "UPDATE topic_articles SET score=$score, updated_at=$updated_at WHERE topic_id=$topic_id AND article_id=$article_id";
		$dbconn->Execute($sql);
		return 1;
	}
	/**
	 * Update Total article of topic_id
	 *
	 * @param 			: string $topic_id
	 * @return 			: true of false
	 */
	static function updateTotalArticle($topic_id=0){
		global $dbconn;
		$total_article = Topic_Articles::countTotalArticle($topic_id);
		$sql = "UPDATE topics SET total_article=$total_article WHERE id=$topic_id";
		$dbconn->Execute($sql);
		return 1;
	}
	/**
	 * Update Total article of list_topic_id
	 *
	 * @param 			: string $list_topic_id
	 * @return 			: true of false
	 */
	static function updateTotalArticle2($list_topic_id=""){
		global $dbconn;
		$arr_topic_id = explode(',', $list_topic_id);
		if (is_array($arr_topic_id)){
			foreach ($arr_topic_id as $key => $val){
				$topic_id = trim($val);
				if (!is_numeric($topic_id)) continue;
				Topic_Articles::updateTotalArticle($topic_id);
			}
		}
		return 1;
	}
	/**
	 * Delete all articles from topic_id
	 *
	 * @param 			: string $list_article_id
	 * @return 			: true of false
	 */
	static function deleteArticlesFromTopic($topic_id=0){
		global $dbconn;
		$sql = "DELETE FROM topic_articles WHERE topic_id=$topic_id";
		$dbconn->Execute($sql);
		return 1;
	}
	/**
	 * Delete all topics from article_id
	 *
	 * @param 			: string $list_topic_id
	 * @return 			: true of false
	 */
	static function deleteTopicsFromArticle($article_id=0){
		global $dbconn;
		$sql = "DELETE FROM topic_articles WHERE article_id=$article_id";
		$dbconn->Execute($sql);
		return 1;
	}
}