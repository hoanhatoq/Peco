<?php
/******************************************************
 * Class Topics
 *
 * Topics Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  class_Topics.php
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
class Topics extends DbBasic{
	/**
	 * Init class
	 */
	function Topics(){
		$this->pkey = "id";
		$this->tbl 	= "topics";
	}
	/**
	 * Check exists topic or not
	 *
	 * @param 			: int $topic_id
	 * @return 			: true of false
	 */
	static function isExists($topic_id=0){
		global $dbconn;
		$sql = "SELECT * FROM topics WHERE id=$topic_id";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && isset($row['id']) && $row['id']>0)? $row : 0;
	}
	/**
	 * Get list all of topics
	 *
	 * @param 			: none
	 * @return 			: array
	 */
	static function getListAll($start=0, $limit=10){
		global $dbconn;
		$sql = "SELECT * FROM topics WHERE display_flags=1 ORDER BY priority DESC, score DESC LIMIT $start, $limit";
		return $dbconn->GetAll($sql);
	}
	/**
	 * Check exists topic path
	 *
	 * @param 			: string $path
	 * @return 			: true of false
	 */
	function isExistsByPath($path="", $old_path=""){
		$cond = "`path`='$path'";
		if ($old_path!="") $cond.= " AND `path`!='$old_path'";
		$arr = $this->getByCond($cond);
		return (is_array($arr) && $arr['id']>0);
	}
	/**
	 * Check validate add form
	 *
	 * @param 			: &$errors
	 * @return 			: true of false
	 */
	function checkValidAddForm(&$errors){
		global $core;
		$old_path = POST("old_path");
		$name = POST("name");
		$path = POST("path");
		$detail = POST("detail");
		$display_flags = POST("display_flags", 0);
		$priority = POST("priority", 1);
		$created_by = POST("created_by", 0);
		$ok = 1;
		if (isNull($name)){
			$errors['name'] = $core->getLang("Name_is_null");
			$ok = 0;
		}
		if (isNull($path)){
			$errors['path'] = $core->getLang("Path_is_null");
			$ok = 0;
		}else
			if ($this->isExistsPath($path, $old_path)){
			$errors["path"] = $core->getLang("Path_is_exists");
			$ok = 0;
		}
		if (isNull($detail)){
			$errors['detail'] = $core->getLang("Detail_is_null");
			$ok = 0;
		}
		if (!isNumber($priority)){
			$errors['priority'] = $core->getLang("Priority_must_be_number");
			$ok = 0;
		}
		if (!isNumber($created_by)){
			$errors['created_by'] = $core->getLang("CreatedBy_must_be_number");
			$ok = 0;
		}
		return $ok;
	}
	/**
	 * Add new record
	 *
	 * @param 			: &$errors
	 * @return 			: last inserted id or false
	 */
	function doAddRecord(&$errors){
		global $core;
		$ID = POST("id");
		$old_thumbnail = POST("old_thumbnail");
		$name = POST("name");
		$path = POST("path");
		$detail = POST("detail");
		$display_flags = POST("display_flags");
		$priority = POST("priority", 1);
		$score = POST("score", 1);
		$created_by = POST("created_by", 0);
		$created_at = POST("created_at", "");
		$updated_at = POST("updated_at", "");
		if ($created_at=="") $created_at = time(); else $created_at = mystrtotime($created_at, "%Y/%m/%d");
		if ($updated_at=="") $updated_at = time(); else $updated_at = mystrtotime($updated_at, "%Y/%m/%d");
		if ($ID==0){
			$fields = "name, path, detail, display_flags, priority, score, created_by, updated_at, created_at";
			$values = "'$name', '$path', '$detail', '$display_flags', $priority, $score, $created_by, $updated_at, $created_at";
			$ok = $this->insertOne($fields, $values);
			if ($ok){
				$ID = $this->getLastInsertId();
				$ok = uploadImage($errors, "thumbnail", DIR_UPLOADS, 't'.$ID, 160, 160);
				if ($ok && $errors['_uploaded_file_name']!=""){
					$thumbnail = $errors['_uploaded_file_name'];
					$set = "thumbnail='$thumbnail'";
					$ok = $this->updateOne($ID, $set);
					if (!$ok){
						$errors['msg'] = $core->getLang("Cannot_update_to_database");
					}
				}
			}else{
				$errors['msg'] = $core->getLang("Cannot_insert_to_database");
			}
		}else{
			$set = "name='$name', path='$path', detail='$detail', display_flags='$display_flags', priority=$priority, score=$score, created_by=$created_by, updated_at=$updated_at, created_by=$created_by";
			$ok = $this->updateOne($ID, $set);
			if ($ok){
				$ok = uploadImage($errors, "thumbnail", DIR_UPLOADS, 't'.$ID, 160, 160);
				if ($ok && $errors['_uploaded_file_name']!=""){
					$thumbnail = $errors['_uploaded_file_name'];
					$set = "thumbnail='$thumbnail'";
					$ok = $this->updateOne($ID, $set);
					if (!$ok){
						$errors['msg'] = $core->getLang("Cannot_update_to_database");
					}else{
						unlink(DIR_UPLOADS."/".$old_thumbnail);
					}
				}
			}
		}
		return $ok;
	}
}