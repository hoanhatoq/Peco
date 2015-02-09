<?
/** 		
 * Module: [account]
 * Home function with $sub=default, $act=signin_facebook
 * Display SignIn Page
 *  
 * @param 				: no params
 * @return 				: no need return
 * @exception 		
 * @throws 		
 */ 		
require_once FACEBOOK_SDK_V4_SRC_DIR.'/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
function default_signin_facebook(){
	global $core, $assign_list, $mod, $sub, $act;
	global  $_CONFIG, $clsRewrite;
	// added in v4.0.0
	$error = GET("error", "");
	$error_code = GET("error_code", 0);
	if ($error!="" && $error_code!=""){
		$error_reason = GET("error_reason", "");
		$state = GET("state", "");
		$msg = GET("error_description");
		$assign_list["msg"] = $msg;
	}else{
		// init app with app id and secret
		FacebookSession::setDefaultApplication( $_CONFIG['FB_APP']['appId'], $_CONFIG['FB_APP']['secret'] );
		// login helper with redirect_uri
		$helper = new FacebookRedirectLoginHelper($clsRewrite->url_signin_facebook());
		try {
			$session = $helper->getSessionFromRedirect();
		} catch( FacebookRequestException $ex ) {
			// When Facebook returns an error
		} catch( Exception $ex ) {
			// When validation fails or other local issues
		}
		// see if we have a session
		if ( isset( $session ) ) {
			// graph api request for user data
			$request = new FacebookRequest( $session, 'GET', '/me' );
			$response = $request->execute();
			// get response
			$graphObject = $response->getGraphObject();
			//register this user
			$clsUsers = new Users();
			$clsUsers->doRegisterFB($graphObject);
			//do login
			$core->doLoginFB($graphObject);
			//redirect to home page
			header("location: ".$clsRewrite->url_home());
			exit();
		} else {
			$scope = array("email", "public_profile");
			$loginUrl = $helper->getLoginUrl($scope);
			//redirect to login page
			header("location: ".$loginUrl);
			exit();
		}
	}
}
?>