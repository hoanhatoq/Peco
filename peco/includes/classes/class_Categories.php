<?php
/******************************************************
 * Class Categories
 *
 * Categories Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  class_Categories.php
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
class Categories extends DbBasic{
	/**
	 * Init class
	 */
	function Categories(){
		$this->pkey = "id";
		$this->tbl 	= "categories";
	}
	/**
	 * Get list all of categories
	 *
	 * @param 			: none
	 * @return 			: array
	 */
	function getListAll(){
		return $this->getAll("disabled=0 ORDER BY priority DESC, id DESC");
	}
	/**
	 * Get ID of category from slug
	 *
	 * @param 			: string $slug
	 * @return 			: array
	 */
	function getIdFromSlug($slug=""){
		$arr = $this->getByCond("short_title='$slug'");
		return (is_array($arr) && $arr['id']>0)? $arr['id'] : 0;
	}
	/**
	 * Check exists category
	 *
	 * @param 			: string $short_title
	 * @return 			: true of false
	 */
	function isExists($short_title="", $old_short_title=""){
		$cond = "short_title='$short_title'";
		if ($old_short_title!="") $cond.= " AND short_title!='$old_short_title'";
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
		$old_short_title = POST("old_short_title");
		$title = POST("title");
		$short_title = POST("short_title");
		$summary = POST("summary");
		$catch = POST("catch");
		$priority = POST("priority", 1);
		$disabled = POST("disabled", 0);
		$ok = 1;
		if (isNull($title)){
			$errors['title'] = $core->getLang("Title_is_null");
			$ok = 0;
		}
		if (isNull($short_title)){
			$errors['short_title'] = $core->getLang("Short_title_is_null");
			$ok = 0;
		}else
		if ($this->isExists($short_title, $old_short_title)){
			$errors["short_title"] = $core->getLang("Category_is_exists");
			$ok = 0;
		}
		if (isNull($summary)){
			$errors['summary'] = $core->getLang("Summary_is_null");
			$ok = 0;
		}
		if (!isNumber($priority)){
			$errors['priority'] = $core->getLang("Priority_must_be_number");
			$ok = 0;
		}
		if (!isNumber($disabled)){
			$errors['disabled'] = $core->getLang("Disabled_must_be_number");
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
		$title = POST("title");
		$short_title = POST("short_title");
		$summary = POST("summary");
		$catch = POST("catch");
		$priority = POST("priority", 1);
		$disabled = POST("disabled", 0);		
		if ($ID==0){
			$fields = "title, short_title, summary, catch, priority, disabled";
			$values = "'$title', '$short_title', '$summary', '$catch', $priority, $disabled";
			$ok = $this->insertOne($fields, $values);
			if ($ok){
				$ID = $this->getLastInsertId();
				$ok = uploadImage($errors, "thumbnail", DIR_UPLOADS, 'c'.$ID, 160, 160);
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
			$set = "title='$title', short_title='$short_title', summary='$summary', catch='$catch', priority=$priority, disabled=$disabled";
			$ok = $this->updateOne($ID, $set);
			if ($ok){
				$ok = uploadImage($errors, "thumbnail", DIR_UPLOADS, 'c'.$ID, 160, 160);				
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