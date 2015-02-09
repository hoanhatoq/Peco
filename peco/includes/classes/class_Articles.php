<?php
/******************************************************
 * Class Articles
 *
 * Articles Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  class_Articles.php
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
class Articles extends DbBasic{
	/**
	 * Init class
	 */
	function Articles(){
		$this->pkey = "id";
		$this->tbl = "articles";
	}
	/**
	 * Check exists article or not
	 *
	 * @param 			: int $article_id
	 * @return 			: true of false
	 */
	static function isExists($article_id=0){
		global $dbconn;
		$sql = "SELECT * FROM articles WHERE id=$article_id";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['id']) && $row['id']>0)? $row : 0;
	}
	/**
	 * Get detail of an article
	 *
	 * @param 			: int $start, int $limit
	 * @return 			: array
	 */
	function getDetail($article_id){
		global $dbconn;
		$cond = "a.id=$article_id";
		$sql = "SELECT a.*, b.name AS username, c.page_view FROM articles AS a
				LEFT JOIN users AS b ON a.created_by = b.id
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond";
		return $dbconn->GetRow($sql);
	}
	/**
	 * Get all articles order by priority, score, lastest
	 *
	 * @param 			: int $start, int $limit
	 * @return 			: array
	 */
	function getListSummary(&$totalItem, $start=0, $limit=20){
		global $dbconn;
		$cond = "a.status=".ST_PUBLIC." AND a.review_status>=0";
		$sqlc = "SELECT COUNT(*) AS totalItem FROM articles AS a
				LEFT JOIN users AS b ON a.created_by = b.id
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond";
		$row = $dbconn->GetRow($sqlc);
		$totalItem = $row['totalItem'];
		$sql = "SELECT a.*, b.name AS username, c.page_view FROM articles AS a
				LEFT JOIN users AS b ON a.created_by = b.id
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond
				ORDER BY a.priority DESC, a.score DESC, a.updated_at DESC
				LIMIT $start, $limit";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Get all articles from $limit, $start
	 *
	 * @param 			: int $user_id, int $start, int $limit
	 * @return 			: array
	 */
	function getListByUser(&$totalItem, $user_id=0, $status='ALL', $start=0, $limit=30){
		global $dbconn;
		$cond = "";
		if ($status=='ALL'){
			$cond = "1";
		}else{
			$cond = "a.status=".$status;
		}
		if ($user_id>0){
			$cond.= " AND a.created_by=$user_id";
		}
		$orderby = " ORDER BY a.published_at DESC";
		$startlimit = " LIMIT $start, $limit";
		$sqlc = "SELECT COUNT(*) AS totalItem FROM articles AS a
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond";
		$row = $dbconn->GetRow($sqlc);
		$totalItem = $row['totalItem'];
		$sql = "SELECT a.*, c.page_view FROM articles AS a				
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond $orderby $startlimit";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Get all articles by category from $limit, $start
	 *
	 * @param 			: int $cat_id, int $start, int $limit
	 * @return 			: array
	 */
	function getListByCategory($cat_id=0, $start=0, $limit=30){
		global $dbconn;
		$cond = "a.status=".ST_PUBLIC;		
		$cond.= " ORDER BY a.published_at DESC";
		$cond.= " LIMIT $start, $limit";
		$sql = "SELECT a.*, b.name AS username, c.page_view FROM articles AS a
				LEFT JOIN users AS b ON a.created_by = b.id
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Get all articles by topic from $limit, $start
	 *
	 * @param 			: int $topic_id, int $start, int $limit
	 * @return 			: array
	 */
	function getListByTopic(&$totalItem, $topic_id=0, $start=0, $limit=30){
		global $dbconn;
		$cond = "a.status=".ST_PUBLIC." AND t.topic_id = $topic_id";
		$orderby = " ORDER BY a.priority DESC, a.score DESC, c.page_view DESC";
		$startlimit = " LIMIT $start, $limit";
		$sqlc = "SELECT COUNT(*) AS totalItem FROM articles AS a
				JOIN topic_articles AS t ON a.id = t.article_id
				LEFT JOIN users AS b ON a.created_by = b.id
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond";
		$row = $dbconn->GetRow($sqlc);
		$totalItem = $row['totalItem'];
		$sql = "SELECT a.*, b.name AS username, c.page_view FROM articles AS a
				JOIN topic_articles AS t ON a.id = t.article_id
				LEFT JOIN users AS b ON a.created_by = b.id
				LEFT JOIN page_views AS c ON a.id = c.article_id
				WHERE $cond $orderby $startlimit";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Check valid ID with Creator (user id)
	 *
	 * @param 			: int $ID, int $user_id
	 * @return 			: true or false
	 */
	function checkValidID($ID, $user_id){
		$arr = $this->getOne($ID);
		return (is_array($arr) && $arr['created_by']==$user_id);
	}
	/**
	 * Insert a new empty Article and return last inserted ID
	 *
	 * @param 			: int $created_by
	 * @return 			: int
	 */
	function getNewID($created_by=0){
		global $core, $dbconn;
		if ($created_by==0 && SITE_ROOT=='root') $created_by = $core->_USER['id'];
		$now = time();
		$title = "";
		$detail = "";
		$thumbnail_type = "";
		$thumbnail_path = "";
		$thumbnail_ext = "";
		$status = ST_DRAFT;
		$review_status = ST_REVIEW_NO;
		$from_date = 0;//$now;
		$to_date = 0;//$now + 30*24*3600;
		$updated_at = 0;
		$created_at = $now;
		$published_at = 0;
		$priority = 1;
		$score = 0;
		$fields = "title, detail, thumbnail_type, thumbnail_path, thumbnail_ext, created_by, status, review_status, from_date, to_date, updated_at, created_at, published_at, priority, score";
		$values = "'$title', '$detail', '$thumbnail_type', '$thumbnail_path', '$thumbnail_ext', $created_by, $status, $review_status, $from_date, $to_date, $updated_at, $created_at, $published_at, $priority, $score";
		$ok = $this->insertOne($fields, $values);
		if ($ok){
			$sql = "SELECT LAST_INSERT_ID() AS ID";
			$arr = $dbconn->GetRow($sql);
			return $arr['ID'];
		}
		return 0;
	}
	/**
	 * Insert a new content to Article ID
	 *
	 * @param 			: ...
	 * @return 			: int
	 */
	function insertContent($curItemId=0, $article_id=0, $ctype=0, $priority=1, $content=""){
		global $core, $dbconn;
		if ($curItemId==0){
			$fields = "article_id, ctype, priority, content";
			$values = "$article_id, $ctype, $priority, '$content'";
			$sql = "INSERT INTO article_content($fields) VALUES($values)";
			$ok = $dbconn->Execute($sql);
			if ($ok){
				$sql = "SELECT LAST_INSERT_ID() AS ID";
				$arr = $dbconn->GetRow($sql);
				return $arr['ID'];
			}
		}else{
			$set = "priority='$priority', content='$content'";
			$sql = "UPDATE article_content SET $set WHERE id=$curItemId";
			$ok = $dbconn->Execute($sql);
			if ($ok) return $curItemId;
		}
		return 0;
	}
	/**
	 * Delete a content of Article
	 *
	 * @param 			: ...
	 * @return 			: true or false
	 */
	function deleteContent($itemId){
		global $dbconn;
		$sql = "DELETE FROM article_content WHERE id=$itemId";
		$ok = $dbconn->Execute($sql);
		return $ok;
	}
	/**
	 * Update title + detail of an Article
	 *
	 * @param 			: int article_id, string title, string detail
	 * @return 			: true or false
	 */
	function updateTitleDetail($article_id=0, $title="", $detail="", $status=""){
		if ($status=='draft' || $status=='preview'){
			$status = ST_DRAFT;
		}else if ($status=='publish'){
			$status = ST_PUBLIC;
		}else if ($status=='private'){
			$status = ST_PRIVATE;
		}
		$now = time();
		$set = "title='$title', detail='$detail', updated_at=$now";
		if ($status!="") $set.= ", status=$status";
		if ($status==1) $set.= ", published_at=$now";
		return $this->updateOne($article_id, $set);
	}
	/**
	 * Update priority of list Article
	 *
	 * @param 			: array $itemsOrder
	 * @return 			: true or false
	 */
	function updateContentPriority($itemsOrder){
		global $dbconn;
		$ok = 1;
		$c = count($itemsOrder);
		if (is_array($itemsOrder))
		foreach ($itemsOrder as $key => $val){
			$id = str_replace('item', '', $val);
			$priority = $c - $key + 1;
			$sql = "UPDATE article_content SET priority='$priority' WHERE id=$id";
			$dbconn->Execute($sql);
		}
		return $ok;
	}
	/**
	 * Save image from base64 encode
	 *
	 * @param 			: int article_id, string img
	 * @return 			: true or false
	 */
	function saveImageBase64($article_id=0, $img=""){
		$img_type = (substr($img, 11, 3)=='png')? 'png' : 'jpg';
		if ($img_type=='png') $img = str_replace('data:image/png;base64,', '', $img);
		if ($img_type=='jpg') $img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$fname = uniqid().'.'.$img_type;
		$fout = DIR_ARTICLES.'/'.$fname;
		$success = file_put_contents($fout, $data);
		if ($success){
			$set = "thumbnail_type='upload', thumbnail_path='$fname', thumbnail_ext='$img_type'";
			return $this->updateOne($article_id, $set);
		}
		return 0;
	}
	/**
	 * Save image from Url
	 *
	 * @param 			: int article_id, string url
	 * @return 			: true or false
	 */
	function saveImageUrl($article_id=0, $url=""){
		$fname = basename($url);
		$img_type = strtolower(substr(strrchr($fname,"."), 1));
		$data = fetchURL($url);
		$fout = DIR_ARTICLES . '/'.$fname;
		$success = file_put_contents($fout, $data);
		if ($success){
			$set = "thumbnail_type='url', thumbnail_path='$fname', thumbnail_ext='$img_type'";
			return $this->updateOne($article_id, $set);
		}
		return 0;
	}
	/**
	 * Get all article_content
	 *
	 * @param 			: int article_id
	 * @return 			: array
	 */
	function getAllContent($article_id=0, $start=0, $limit=100){
		global $dbconn;
		$sql = "SELECT * FROM article_content 
				WHERE article_id=$article_id 
				ORDER BY priority DESC, id DESC 
				LIMIT $start, $limit";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Check validate add form
	 *
	 * @param 			: &$errors
	 * @return 			: true of false
	 */
	static function checkValidAddForm(&$errors){
		return true;
	}
	/**
	 * Add or Update a article
	 *
	 * @param 			: &$errors
	 * @return 			: true of false
	 */
	static function doAddRecord(&$errors){
		global $dbconn;echo "A";
		$article_id = POST("article_id");
		$created_by = POST("created_by", 0);
		$old_list_topic_id = POST("old_list_topic_id");
		$list_topic_id = POST("list_topic_id");
		$priority = POST("priority", 0);
		$score = POST("score", 0);
		$created_at = POST("created_at");
		$updated_at = POST("updated_at");
		$created_at = mystrtotime($created_at, "%Y/%m/%d");
		$updated_at = mystrtotime($updated_at, "%Y/%m/%d");
		$new_status = POST("new_status", "");
		$set = "created_by=$created_by, priority=$priority, score=$score, created_at=$created_at, updated_at=$updated_at";
		if ($new_status!="") $set.=", status=$new_status";
		$sql = "UPDATE articles SET $set WHERE id=$article_id";
		$dbconn->Execute($sql);
		$ok = Topic_Articles::addTopicListToArticle($article_id, $list_topic_id, $old_list_topic_id);
		if ($ok){
			
		}
		return true;
	}
}
?>