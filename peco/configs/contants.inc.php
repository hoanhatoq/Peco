<?
/******************************************************
 * Vars&Conts Definition
 * 
 * Define some variables & contants for project
 * 
 *
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  contants.inc.php
 * Environment                :  PHP  version 4,5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/
#Define Error Handle
define("HANDLE_ERROR", 			0);//system error handling, 0: no, 1: yes
define("STOP_APP_IF_ERROR", 	1);//application with stop if error happen? 0: no, 1: yes

#Define LogFile
define("LOG_SYSTEM_FILE", 		DIR_LOGS."/system.log");
define("LOG_MAIL_FILE", 		DIR_LOGS."/mail.log");

#Define Language default
define("LANG_DEFAULT", 			"jp");

//Define Debug vars
define("SMARTY_DEBUG", 			false);//smarty debug or not
define("COMPILE_CHECK", 		true);//smarty compile checking newest source
define("ADODB_DEBUG", 			false);//adodb debug or not

//Define Status of Article
define("ST_DRAFT", 				0);
define("ST_PUBLIC", 			1);
define("ST_PRIVATE", 			2);
define("ST_DISABLED", 			3);

define("ST_REVIEW_NO", 			0);
define("ST_REVIEW_YES",			1);


#Define Cookie vars
$COOKIE_NAME 					= "peco";
$COOKIE_TIME_OUT 				= 5*24*3600;//5 days
$COOKIE_PREFIX 					= "peco_";
$COOKIE_USER 					= $COOKIE_PREFIX."UID";
$COOKIE_PASS 					= $COOKIE_PREFIX."PKEY";

#Define Session vars
$SESSION_NAME 					= "peco";
$SESSION_PATH 					= "/tmp";
$SESSION_COOKIE 				= 1; //1: use cookie, 0: no cookie
$SESSION_TIME_OUT 				= 5*3600;	//5 hours

#Config array
$_CONFIG = array(
	'smtp_server'						=>	"",
	'smtp_port'							=>	"",
	'smtp_user'							=>	"",
	'smtp_pass'							=>	"",
	'webmaster_email'					=>	"",
	'site_name'							=>	"",
);

//Facebook App definition
$_CONFIG['FB_APP'] = array(
	"appId"								=>	"115378268489529",
	"secret"							=>	"340683ea74b86b27990443c552daab85",
	"cookie"							=>	true
);

//Twitter Authenticate Token
$_CONFIG['auth_token'] = array(
	'oauth_access_token' 				=> "335037102-vRaf0kOYhTCPFPpixjzdU2rhYwEoh7yQbdBClhpm",
	'oauth_access_token_secret' 		=> "RweReES4ShYK5jlh2rOwFNAZfths6JXli1ki9Vp1dDdm8",
	'consumer_key' 						=> "jvvcsbjiUQnqMue1koVHy5gpb",
	'consumer_secret' 					=> "xn0NtuWgZPvJuqpVCx88qAiJ0bkSNlCumD1Qj1LoqZKo2UZfVu"
);

//Twitter API
$_CONFIG['tweet_api'] = array(
	'search_tweet' 						=> "https://api.twitter.com/1.1/statuses/show.json",
	'search_tweet_list' 				=> "https://api.twitter.com/1.1/search/tweets.json",
	'search_user_timeline' 				=> "https://api.twitter.com/1.1/statuses/user_timeline.json"
);

//Google API
$_CONFIG['google_api'] = array(
	'time'								=>	300,
	'urlGSearch'						=>	"https://www.googleapis.com/customsearch/v1",
	'urlGVideo'							=>	"https://www.googleapis.com/youtube/v3/videos",
	'urlGVideoSearch'					=>	"https://www.googleapis.com/youtube/v3/search",
	'key'								=>	"AIzaSyD66N-rpsNozrdT0cSa8B_va2cOCpnCJTU",
	//'key'								=>	"AIzaSyAtieGCjzx4U1HMeQTcl_pPTZimqVZ742k",
	//'key'								=>  "AIzaSyDP4oldXn7WifK8d5rwGgi4IOPPbKdQibw",
	'cx'								=>	"011522656237832129764:tpstukcprmy",
	'cx_video'							=>	"011522656237832129764:y_5wjpuf80y",
	'num'								=>	10,
);

//Image Size
$_CONFIG['thumb_size'] = array(
	'tiny_thumb'						=>	array(50, 50),
	'normal_thumb'						=>	array(75, 75),
	'user_avatar'						=>	array(120, 120),
	'article_thumb'						=>	array(160, 160),
	'pickup_thumb'						=>	array(340, 220),//at pickup	articles
);

$_ADMIN = array(
	"username"	=>	"admin",
	"userpass"	=>	"admin"
)
?>
