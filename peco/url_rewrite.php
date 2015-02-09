<?
/******************************************************
 * Class Rewrite (URL Rewrite Controller)
 *
 * Parse URL string to corresponding vars
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsRewrite.php
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
class Rewrite{
	var $base;
	var $actual;
	var $path;
	var $rules;
	var $variables;
	var $e404		=	"error404.php";
	/** 		
	* Initialize class
	*  
	* @param 			: string $base
	* @return 			: no
	*/
	function Rewrite($base){
		$this->path = parse_url($_SERVER['REQUEST_URI']);	
		$this->actual = $this->path ==  "/" ?  array("") : explode("/",$this->path['path']);
		$this->base = $base;
		$this->execute();
	}
	/** 		
	* Return page 404
	*  
	* @param 			: no
	* @return 			: no
	*/
	function error404() {
		header('HTTP/1.1 404 Not Found');
		header('Status: 404 Not Found');
		if ( $this->e404 != '')
				require $this->e404;
		exit();
	}
	/** 		
	* Parse URL path to detect params and assign to $_GET
	*  
	* @param 			: no
	* @return 			: no
	*/
	function execute(){
		if (strpos($this->path['path'], 'http:')!==false || strpos($this->path['path'], '?')!==false){
			$this->error404();
		}
		$ok = preg_match("/\.(jpg|jpeg|gif|ico|png|js|css|txt|swf|tpl|ttf|xml|doc|zip|rar|xls|mp3|avi)$/i", $this->path['path'], $match);
		if ($ok){
			$this->error404();
			return 0;
		}		
		//match /users, /sign_up, /sign_in, /sign_in_facebook, /logout
		$ok = preg_match("/^\/users\/(sign_up|sign_in|sign_in_facebook|logout)(\/)*$/i" , $this->path['path'], $match);
		if ($ok){
			if ($match[1]=='sign_up') $match[1] = 'signup';else
			if ($match[1]=='sign_in') $match[1] = 'signin';else
			if ($match[1]=='sign_in_facebook') $match[1] = 'signin_facebook';
			$_GET["mod"] = "account";
			$_GET["act"] = $match[1];
			return 1;
		}
		//match /users/password/new
		$ok = preg_match("/^\/users\/password\/new(\/)*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "account";
			$_GET["act"] = "forgot";
			return 1;
		}
		//match /users/password/edit
		$ok = preg_match("/^\/users\/password\/edit*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "account";
			$_GET["act"] = "resetpass";
			return 1;
		}
		//match /mypage, /setting
		$ok = preg_match("/^\/(mypage|setting)(\/)*$/i" , $this->path['path'], $match);
		if ($ok){
			if ($match[1]=='mypage') $match[1] = 'default';
			$_GET["mod"] = "account";
			$_GET["act"] = $match[1];
			return 1;
		}
		//match /usr/AZ09/favorites
		$ok = preg_match("/^\/user\/([a-zA-Z0-9_]+)\/favorites(\/)*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "account";
			$_GET["act"] = "favorites";
			return 1;
		}		
		//match /caegories, /features, /topics
		$ok = preg_match("/^\/(categories|features|topics|search|curators|ranking)(\/)*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = $match[1];
			return 1;
		}
		//match /topic/ID, /feature/ID
		$ok = preg_match("/^\/(topic|feature)\/([0-9]+)*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = $match[1];
			$_GET["ID"] = $match[2];
			return 1;
		}
		//match /contact, /sitemap
		$ok = preg_match("/^\/(sitemap|contact)(\/)*$/" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = $match[1];
			return 1;
		}
		//match /site/peco, /site/rules, /site/policy
		$ok = preg_match("/^\/site\/(peco|rules|policy)(\/)*$/" , $this->path['path'], $match);
		if ($ok){
			if ($match[1]=='peco') $match[1] = 'about';
			$_GET["mod"] = "home";
			$_GET["act"] = $match[1];
			return 1;
		}
		//match /new_post
		$ok = preg_match("/^\/new_post(\/)*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "account";
			$_GET["act"] = "createpost";
			return 1;
		}
		//match /add/ID
		$ok = preg_match("/^\/add\/([0-9]+)*$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "account";
			$_GET["act"] = "createpost";
			$_GET["ID"] = $match[1];
			return 1;
		}
		//match /post_ID/preview
		$ok = preg_match("/^\/([0-9]+)\/preview$/" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = "post_detail";
			$_GET["ID"]  = $match[1];
			$_GET["mode"] = "preview";
			return 1;
		}
		//match /post_ID/public
		$ok = preg_match("/^\/([0-9]+)\/public$/" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = "post_detail";
			$_GET["ID"]  = $match[1];
			$_GET["mode"] = "public";
			return 1;
		}
		//match /post_ID
		$ok = preg_match("/^\/([0-9]+)$/" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = "post_detail";
			$_GET["ID"]  = $match[1];
			return 1;
		}
		//match /category_slug
		$ok = preg_match("/^\/([a-zA-Z]+)$/i" , $this->path['path'], $match);
		if ($ok){
			$_GET["mod"] = "home";
			$_GET["act"] = "category";
			$_GET["slug"] = $match[1];
			return 1;
		}
		if ($this->path['path']==''){
			$_GET["mod"] = "home";
			$_GET["act"] = "default";			
			return 1;
		}		
		return 0;
	}
	/** 		
	* Return URL of homepage
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_home(){
		return URL_CMS;
	}
	/**
	 * Return URL of static page
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_staticpage($slug){
		if ($slug=='peco' || $slug=='policy' || $slug=='rules'){
			$slug = "site/$slug";
		}
		return URL_CMS."/$slug";
	}
	/**
	 * Return URL of contact page
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_contact(){
		return URL_CMS."/contact";
	}
	/** 		
	* Return URL of signin page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_signin(){
		return URL_CMS."/users/sign_in";
	}
	/** 		
	* Return URL of signin facebook page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_signin_facebook(){
		return URL_CMS."/users/sign_in_facebook";
	}
	/** 		
	* Return URL of signup page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_signup(){
		return URL_CMS."/users/sign_up";
	}
	/** 		
	* Return URL of logout page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_logout(){
		return URL_CMS."/users/logout";
	}
	/** 		
	* Return URL of forgot page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_forgot(){
		return URL_CMS."/users/password/new";
	}
	/** 		
	* Return URL of resetpass page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_resetpass($token=""){
		return URL_CMS."/users/password/edit?resetpass_token=$token";
	}
	/** 		
	* Return URL of mypage page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_mypage(){
		return URL_CMS."/mypage";
	}
	/** 		
	* Return URL of setting page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_setting(){
		return URL_CMS."/setting";
	}
	/** 		
	* Return URL of favorites page
	*  
	* @param 			: string $username
	* @return 			: string
	*/
	function url_favorites($username=''){
		return URL_CMS."/user/$username/favorites";
	}
	/**
	 * Return URL of user page
	 *
	 * @param 			: string $username
	 * @return 			: string
	 */
	function url_userpage($username=''){
		return URL_CMS."/user/$username";
	}
	/**
	 * Return URL of user list
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_curators(){
		return URL_CMS."/curators";
	}
	/** 		
	* Return URL of create post page
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_createpost(){
		return URL_CMS."/new_post";
	}
	/** 		
	* Return URL of create post page with ID
	*  
	* @param 			: no
	* @return 			: string
	*/
	function url_addID($ID){
		return URL_CMS."/add/$ID";
	}
	/**
	 * Return URL of post detail ID
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_postdetail($ID){
		return URL_CMS."/$ID";
	}
	/**
	 * Return URL of preview post ID
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_previewpost($ID){
		return URL_CMS."/$ID/preview";
	}
	/**
	 * Return URL of public post ID
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_publicpost($ID){
		return URL_CMS."/$ID/public";
	}
	/**
	 * Return URL of category
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_category($category){
		return URL_CMS."/".$category['short_title'];
	}
	/**
	 * Return URL of topic list
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_topics(){
		return URL_CMS."/topics";
	}
	/**
	 * Return URL of topic
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_topic($topic){
		return URL_CMS."/topic/".$topic['id'];
	}
	/**
	 * Return URL of feature list
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_features(){
		return URL_CMS."/features";
	}
	/**
	 * Return URL of feature
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_feature($feature){
		return URL_CMS."/feature/".$feature['id'];
	}
	/**
	 * Return URL of ranking
	 *
	 * @param 			: no
	 * @return 			: string
	 */
	function url_ranking(){
		return URL_CMS."/ranking";
	}
}
$base = trim(dirname(" ".$_SERVER['SCRIPT_NAME']));
$clsRewrite = new Rewrite($base);
?>