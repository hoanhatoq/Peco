<?
/******************************************************
 * Class User
 *
 * User Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  class_User.php
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
class Users extends DbBasic{
	/**
	 * Init class
	 */
	function Users(){
		$this->pkey = "id";
		$this->tbl = "users";	
	}
	/**
	 * Return total of published article of user_id
	 *
	 * @param 			: int user_id
	 * @return 			: string
	 */
	static function getTotalPublishedArticle($user_id){
		global $dbconn;
		$cond = "a.status=".ST_PUBLIC." AND review_status>=0 AND b.id = $user_id";
		$sql = "SELECT COUNT(a.id) AS total_item FROM articles AS a
				INNER JOIN users AS b ON a.created_by = b.id
				WHERE $cond";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && $row['total_item']>0)? $row['total_item'] : 0;
	}
	/**
	 * Return total of favorited article of user_id
	 *
	 * @param 			: int user_id
	 * @return 			: string
	 */
	static function getTotalFavoriteArticle($user_id){
		global $dbconn;
		$cond = "a.disabled=0 AND b.id = $user_id";
		$sql = "SELECT COUNT(a.id) AS total_item FROM favorites AS a
				INNER JOIN users AS b ON a.user_id = b.id
				WHERE $cond";
		$row = $dbconn->GetRow($sql);
		return (is_array($row) && $row['total_item']>0)? $row['total_item'] : 0;
	}
	/**
	 * Return total of liked all articles of user_id
	 *
	 * @param 			: int user_id
	 * @return 			: string
	 */
	static function getTotalLiked($user_id){
	
	}
	/** 		
	* Return user record by email 
	*  
	* @param 			: $email string
	* @return 			: string
	*/
	function getByEmail($email=""){
		$arr = $this->getByCond("email='$email'");
		if (is_array($arr) && $arr['email']===$email) return $arr;
		return array();
	}	
	/** 		
	* Return encrypt of password
	*  
	* @param 			: no
	* @return 			: string
	*/
	function encrypt($password=""){
		return md5(md5($password));
	}	
	/** 		
	* Check email is exists or not
	*  
	* @param 			: $email string
	* @return 			: string
	*/
	function isExistsEmail($email="", $old_email=""){
		$arr = $this->getByCond("email='$email' AND email!='$old_email'");
		return (is_array($arr) && $arr['email']===$email);
	}
	/** 		
	* Check correct password is exists or not
	*  
	* @param 			: $email, $encrypted_password
	* @return 			: string
	*/
	function isExistsEmailPassword($email="", $password=""){
		$password = $this->encrypt($password);
		$arr = $this->getByCond("email='$email' AND password='$password'");
		return (is_array($arr) && $arr['email']===$email);
	}
	/** 		
	* Check username is exists or not
	*  
	* @param 			: $name string
	* @return 			: string
	*/
	function isExistsName($name="", $old_name=""){
		$arr = $this->getByCond("name='$name' AND name!='$old_name'");
		return (is_array($arr) && $arr['name']===$name);
	}
	/**
	 * Check account_name is exists or not
	 *
	 * @param 			: $name string
	 * @return 			: string
	 */
	function isExistsAccountName($account_name="", $old_account_name=""){
		$arr = $this->getByCond("account_name='$account_name' AND account_name!='$old_account_name'");
		return (is_array($arr) && $arr['account_name']===$account_name);
	}
	/** 		
	* Check validate login form
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function checkValidLoginForm(&$errors){
		global $core;
		$email = POST("email");
		$password = POST("password");
		$ok = 1;
		$exists_email = 0;
		//Check Email
		if (isNull($email)){
			$errors['email'] = $core->getLang("Email_is_null");
			$ok = 0;
		}else
		if (!isValidEmail($email)){
			$errors['email'] = $core->getLang("Email_is_not_valid_format");
			$ok = 0;
		}else
		if (!$this->isExistsEmail($email)){
			$errors['email'] = $core->getLang("Email_is_not_exists");
			$ok = 0;			
		}else{
			$exists_email = 1;
		}
		//Check Password
		if (isNull($password)){
			$errors['password'] = $core->getLang("Password_is_null");
			$ok = 0;
		}else
		if ($exists_email && !$this->isExistsEmailPassword($email, $password)){
			$errors['password'] = $core->getLang("Password_is_not_correct");
			$ok = 0;
		}
		return $ok;
	}
	/** 		
	* Check validate forgot form
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function checkValidForgotForm(&$errors){
		global $core;
		$email = POST("email");
		$ok = 1;
		//Check Email
		if (isNull($email)){
			$errors['email'] = $core->getLang("Email_is_null");
			$ok = 0;
		}else
		if (!isValidEmail($email)){
			$errors['email'] = $core->getLang("Email_is_not_valid_format");
			$ok = 0;
		}else
		if (!$this->isExistsEmail($email)){
			$errors['email'] = $core->getLang("Email_is_not_exists");
			$ok = 0;			
		}
		return $ok;
	}
	/** 		
	* Check validate resetpass form
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function checkValidResetPassForm(&$errors){
		global $core;
		$password = POST("password");
		$password_confirm = POST("password_confirm");
		$ok = 1;
		//Check Password
		if (isNull($password)){
			$errors['password'] = $core->getLang("Password_is_null");
			$ok = 0;
		}else
		if (!isValidLength($password, 6, 255)){
			$errors['password'] = $core->getLang("Password_must_be_at_least_6_chars");
			$ok = 0;		
		}else
		if (!isValidPassword($password)){
			$errors['password'] = $core->getLang("Password_is_null");
			$ok = 0;
		}
		//Check Password Confirm
		if (isNull($password_confirm)){
			$errors['password_confirm'] = $core->getLang("Password_confirm_is_null");
			$ok = 0;
		}else
		if ($password!=$password_confirm){
			$errors['password_confirm'] = $core->getLang("Password_and_password_confirm_is_not_match");
			$ok = 0;		
		}
		return $ok;
	}
	/** 		
	* Check validate register form
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function checkValidRegisterForm(&$errors){
		global $core;
		$name = POST("name");
		$email = POST("email");
		$password = POST("password");
		$password_confirm = POST("password_confirm");
		$ok = 1;
		//Check Name
		if (isNull($name)){
			$errors['name'] = $core->getLang("User_name_is_null");
			$ok = 0;
		}else
		if (!isValidUserName($name)){
			$errors['name'] = $core->getLang("User_name_is_not_valid_format");
			$ok = 0;		
		}else
		if ($this->isExistsName($name)){
			$errors['name'] = $core->getLang("User_name_is_exists");
			$ok = 0;
		}
		//Check Email
		if (isNull($email)){
			$errors['email'] = $core->getLang("Email_is_null");
			$ok = 0;
		}else
		if (!isValidEmail($email)){
			$errors['email'] = $core->getLang("Email_is_not_valid_format");
			$ok = 0;
		}else
		if ($this->isExistsEmail($email)){
			$errors['email'] = $core->getLang("Email_is_exists");
			$ok = 0;			
		}
		//Check Password
		if (isNull($password)){
			$errors['password'] = $core->getLang("Password_is_null");
			$ok = 0;
		}else
		if (!isValidLength($password, 6, 255)){
			$errors['password'] = $core->getLang("Password_must_be_at_least_6_chars");
			$ok = 0;		
		}else
		if (!isValidPassword($password)){
			$errors['password'] = $core->getLang("Password_is_null");
			$ok = 0;
		}
		//Check Password Confirm
		if (isNull($password_confirm)){
			$errors['password_confirm'] = $core->getLang("Password_confirm_is_null");
			$ok = 0;
		}else
		if ($password!=$password_confirm){
			$errors['password_confirm'] = $core->getLang("Password_and_password_confirm_is_not_match");
			$ok = 0;		
		}
		return $ok;
	}
	/** 		
	* Check validate setting form
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function checkValidSettingForm(&$errors){
		global $core;
		$old_email = POST("old_email");
		$email = POST("email");
		$account_name = POST("account_name");
		$ok = 1;
		//Check Name
		if (isNull($account_name)){
			$errors['account_name'] = $core->getLang("Account_name_is_null");
			$ok = 0;
		}
		//Check Email
		if (isNull($email)){
			$errors['email'] = $core->getLang("Email_is_null");
			$ok = 0;
		}else
		if (!isValidEmail($email)){
			$errors['email'] = $core->getLang("Email_is_not_valid_format");
			$ok = 0;
		}else
		if ($this->isExistsEmail($email, $old_email)){
			$errors['email'] = $core->getLang("Email_is_exists");
			$ok = 0;			
		}
		
		return $ok;
	}
	/** 		
	* Register new user
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function doRegister(){
		$name = strtolower(POST("name"));
		$email = POST("email");
		$password = $this->encrypt(POST("password"));
		$icon = $icon_ext = "";
		$introduction = $introduction_url = "";		
		$created_at = $updated_at = time();
		$is_verified = 1;
		$status = 1;//valid, withdrawed, force-withdrawed
		$fields = "`name`, email, `password`, is_verified, icon, icon_ext, introduction, introduction_url, created_at, updated_at";
		$values = "'$name', '$email', '$password', $is_verified, '$icon', '$icon_ext', '$introduction', '$introduction_url', '$created_at', '$updated_at'";
		return $this->insertOne($fields, $values);
	}
	/** 		
	* Update user profile
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function doUpdateProfile(&$errors){
		global $core;
		$user_id = POST("user_id");
		$account_name = POST("account_name");
		$email = POST("email");
		$introduction = POST("introduction");
		$introduction_url = POST("introduction_url");
		$updated_at = time();
		$set = "account_name='$account_name', email='$email', introduction='$introduction', introduction_url='$introduction_url', updated_at='$updated_at'";
		$ok = $this->updateOne($user_id, $set);
		if ($ok){
			//begin update image
			$image = isset($_FILES["icon"])? $_FILES["icon"] : "";
			if ($image["name"]!=""){
				$newimage_tmp = $user_id."_".strtolower($image["name"]);
				$newpath_tmp = DIR_ICON."/".$newimage_tmp;
				if (strpos($image["name"], ".php")!==false){
					$errors['icon'] = $core->getLang("Extension_is_not_allowed");
					$valid = $ok = 0;
				}else
				if (filesize($image['tmp_name']) > 1*1024*1024){
					$errors['icon'] = $core->getLang("File_size_is_invalid");
					$valid = $ok = 0;
				}else
				if ($image["tmp_name"]!="" && @move_uploaded_file($image["tmp_name"], $newpath_tmp)){
					if ($core->_USER['icon']!='noavatar.jpg'){
						unlink(DIR_ICON."/".$core->_USER['icon']);
					}
					resize_thumbs($newpath_tmp, $newpath_tmp, 120, 120);
					$icon_ext = strtolower(substr(strrchr($newimage_tmp,"."),1));
					$this->updateOne($user_id, "icon='$newimage_tmp', icon_ext='$icon_ext'");
				}else{
					$errors['icon'] = $core->getLang("Cannot_upload_to_server");
					$valid = $ok = 0;
				}
			}
			//end update image
		}
		return $ok;
	}
	/** 		
	* Register new user
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function doRegisterFB($graphObject){
		$name = $graphObject->getProperty('name');
		$email = $graphObject->getProperty('email');
		if (!$this->isExistsEmail($email)){
			$password = "";
			$auth_type = "facebook";
			$auth_id = $graphObject->getProperty('id');
			$icon = $icon_ext = "";
			$introduction = $introduction_url = "";		
			$created_at = $updated_at = time();
			$is_verified = 1;
			$status = 1;//valid, withdrawed, force-withdrawed
			$fields = "`name`, email, `password`, is_verified, icon, icon_ext, introduction, introduction_url, created_at, updated_at, auth_type, auth_id";
			$values = "'$name', '$email', '$password', $is_verified, '$icon', '$icon_ext', '$introduction', '$introduction_url', '$created_at', '$updated_at', '$auth_type', '$auth_id'";
			return $this->insertOne($fields, $values);
		}else
			return 0;
	}
	/** 		
	* Update new password
	*  
	* @param 			: &$errors
	* @return 			: true of false
	*/
	function updateNewPassword($email){
		$password = $this->encrypt(POST("password"));
		$updated_at = time();
		return $this->updateByCond("email='$email'", "password='$password', updated_at=$updated_at");
	}	
	/**
	 * Check validate add form
	 *
	 * @param 			: &$errors
	 * @return 			: true of false
	 */
	function checkValidAddForm(&$errors){
		global $core;
		$old_name = POST("old_name");
		$old_account_name = POST("old_account_name");
		$old_email = POST("old_email");
		$name = POST("name");
		$account_name = POST("account_name");
		$email = POST("email");
		$introduction = POST("introduction");
		$introduction_url = POST("introduction_url");
		$receive_email = POST("receive_email", 0);
		$ok = 1;
		if (isNull($name)){
			$errors['name'] = $core->getLang("Name_is_null");
			$ok = 0;
		}else
		if ($this->isExistsName($name, $old_name)){
			$errors["name"] = $core->getLang("Name_is_exists");
			$ok = 0;
		}
		if (isNull($account_name)){
			$errors['account_name'] = $core->getLang("Account_name_is_null");
			$ok = 0;
		}else
		if ($this->isExistsAccountName($account_name, $old_account_name)){
			$errors["account_name"] = $core->getLang("Account_name_is_exists");
			$ok = 0;
		}
		if (isNull($email)){
			$errors['email'] = $core->getLang("Email_is_null");
			$ok = 0;
		}else
		if ($this->isExistsEmail($email, $old_email)){
			$errors["email"] = $core->getLang("Email_is_exists");
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
		$old_icon = POST("old_icon");
		$name = strtolower(POST("name"));
		$account_name = POST("account_name");
		$email = POST("email");
		$password = POST("password");
		$introduction = POST("introduction");
		$introduction_url = POST("introduction_url");
		$receive_email = POST("receive_email", 1);
		$created_at = POST("created_at", "");
		$updated_at = POST("updated_at", "");
		$is_verified = POST("is_verified", 0);		
		if ($created_at=="") $created_at = time(); else $created_at = mystrtotime($created_at, "%Y/%m/%d");
		if ($updated_at=="") $updated_at = time(); else $updated_at = mystrtotime($updated_at, "%Y/%m/%d");
		if ($ID==0){
			$password = $this->encrypt($password);
			$fields = "name, account_name, email, password, introduction, introduction_url, created_at, updated_at, is_verified, receive_email";
			$values = "'$name', '$account_name', '$email', '$password', '$introduction', '$introduction_url', $created_at, $updated_at, $is_verified, $receive_email";
			$ok = $this->insertOne($fields, $values);
			if ($ok){
				$ID = $this->getLastInsertId();
				$ok = uploadImage($errors, "icon", DIR_UPLOADS, 'u'.$ID, 160, 160);
				if ($ok && $errors['_uploaded_file_name']!=""){
					$icon = $errors['_uploaded_file_name'];
					$icon_ext = strtolower(substr(strrchr($icon,"."),1));
					$set = "icon='$icon', icon_ext='$icon_ext'";
					$ok = $this->updateOne($ID, $set);
					if (!$ok){
						$errors['msg'] = $core->getLang("Cannot_update_to_database");
					}
				}
			}else{
				$errors['msg'] = $core->getLang("Cannot_insert_to_database");
			}
		}else{			
			$set = "name='$name', account_name='$account_name', email='$email', introduction='$introduction', introduction_url='$introduction_url', created_at=$created_at, updated_at=$updated_at, is_verified=$is_verified, receive_email=$receive_email";
			$old_password = POST("old_password");
			if ($old_password!=$password && $password!=""){
				$password = $this->encrypt($password);
				$set.= ", password='$password'";
			}
			$ok = $this->updateOne($ID, $set);
			if ($ok){
				$ok = uploadImage($errors, "icon", DIR_ICON, 'u'.$ID, 120, 120);
				if ($ok && $errors['_uploaded_file_name']!=""){
					$icon = $errors['_uploaded_file_name'];
					$icon_ext = strtolower(substr(strrchr($icon,"."),1));
					$set = "icon='$icon', icon_ext='$icon_ext'";
					$ok = $this->updateOne($ID, $set);
					if (!$ok){
						$errors['msg'] = $core->getLang("Cannot_update_to_database");
					}else{
						@unlink(DIR_ICON."/".$old_icon);
					}
				}
			}
		}
		return $ok;
	}
}
?>