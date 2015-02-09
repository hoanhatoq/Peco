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
class Token extends DbBasic{
	/**
	 * Init class
	 */
	function Token(){
		$this->pkey = "id";
		$this->tbl = "token";	
	}
	/** 		
	* Get Token Record
	*  
	* @param 				: $token string
	* @return 			: string
	*/
	function getEmailByToken($token=""){
		$now = time();
		$arr = $this->getByCond("token='$token' AND expired_at > $now");
		return (is_array($arr) && $arr['id']>0)? $arr['email'] : "";
	}
	/** 		
	* Create new token
	*  
	* @param 				: $email string
	* @return 			: string
	*/
	function createToken($email=""){
		if ($email=="") return 0;
		$i = rand(25, 32);
		$token = simpleRandString($i);
		$expired_at = time() + 1*60*60;
		$fields = "token, email, expired_at";
		$values = "'$token', '$email', $expired_at";
		$ok = $this->insertOne($fields, $values);
		if ($ok) return $token;
		return 0;
	}
	/** 		
	* Verify a token
	*  
	* @param 				: $token string
	* @return 			: string
	*/
	function verifyToken($token=""){
		$now = time();
		$arr = $this->getByCond("token='$token' AND expired_at > $now");
		return (is_array($arr) && $arr['id']>0);
	}
	/** 		
	* Delete a token
	*  
	* @param 				: $token string
	* @return 			: string
	*/
	function deleteToken($token=""){
		return $this->deleteByCond("token='$token'");
	}
	/** 		
	* Delete expired token
	*  
	* @param 				: $token string
	* @return 			: string
	*/
	function deleteExpired($token=""){
		$now = time();
		return $this->deleteByCond("expired_at < $now");
	}
}
?>