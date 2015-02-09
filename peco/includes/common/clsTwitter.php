<?php
class TwitterUtil {
	private $oauth_access_token;
	private $oauth_access_token_secret;
	private $consumer_key;
	private $consumer_secret;
	private $getParams;
	private $postParams;
	private $reqMethod = 'GET';
	private $url;
	public $config;
	public function __construct($config) {
		$this->oauth_access_token = $config ['oauth_access_token'];
		$this->oauth_access_token_secret = $config ['oauth_access_token_secret'];
		$this->consumer_key = $config ['consumer_key'];
		$this->consumer_secret = $config ['consumer_secret'];
	}
	public function searchTweetById($apiUrl, $statusUrl) {
		$statusId = end ( explode ( '/', $statusUrl ) );
		$params = '?id=' . $statusId;
		
		$this->url = $apiUrl;
		$this->setGetParam ( $params );
		
		$response = $this->doRequest (); // echo $response; return;
		$result = $this->parseTweet ( $response );
		return $result;
	}
	public function searchTweetByKeyword($apiUrl, $keyword) {
		// $params = '?q='.$keyword;
		$params = $keyword;
		
		$this->url = $apiUrl;
		$this->setGetParam ( $params );
		
		$response = $this->doRequest ();
		$result = $this->parseTweetList ( $response );
		return $result;
	}
	public function searchUserTimeline($apiUrl, $keyword) {
		$keyword = urldecode ( $keyword );
		$this->url = $apiUrl;
		$this->setGetParam ( $keyword );
		
		$part = parse_url ( $keyword );
		parse_str ( $part ['query'], $query );
		
		$response = $this->doRequest ();
		$result = $this->parseTimeline ( $response, $query ["max_id"] );
		return $result;
	}
	private function doRequest() {
		$oath = $this->buildOauth ();
		$header = array (
				$this->buildAuthorizationHeader ( $oath ),
				'Expect:' 
		);
		
		$getFields = $this->getGetParam ();
		$postFields = $this->getPostParam ();
		
		$options = array (
				CURLOPT_HTTPHEADER => $header,
				CURLOPT_HEADER => false,
				CURLOPT_URL => $this->url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_SSL_VERIFYPEER => false 
		);
		
		if (! is_null ( $postFields )) {
			$options [CURLOPT_POSTFIELDS] = $postFields;
		} else {
			if ($getfield !== '') {
				$options [CURLOPT_URL] .= $getFields;
			}
		}
		
		$feed = curl_init ();
		curl_setopt_array ( $feed, $options );
		$result = curl_exec ( $feed );
		curl_close ( $feed );
		
		return $result;
	}
	
	/**
	 * Set getPram string
	 *
	 * @param string $string
	 *        	Get key and value pairs as string
	 *        	
	 */
	public function setGetParam($params) {
		if (! is_null ( $this->getPostParam () )) {
			throw new Exception ( 'Post params already exits.' );
		}
		
		$search = array (
				'#',
				',',
				'+',
				':',
				' ' 
		);
		$replace = array (
				'%23',
				'%2C',
				'%2B',
				'%3A',
				'%20' 
		);
		$string = str_replace ( $search, $replace, $params );
		
		$this->getParams = $string;
	}
	
	/**
	 * Get getPram string
	 *
	 * @return string $this->getParams
	 */
	public function getGetParam() {
		return $this->getParams;
	}
	
	/**
	 * Set postParam array
	 *
	 * @param array $array
	 *        	Array of parameters for the API
	 *        	
	 */
	public function setPostParam($params) {
		if (! is_null ( $this->getGetParam () )) {
			throw new Exception ( 'Get params already exits.' );
		}
		
		if (isset ( $params ['status'] ) && substr ( $params ['status'], 0, 1 ) === '@') {
			$params ['status'] = sprintf ( "\0%s", $params ['status'] );
		}
		
		$this->postParams = $params;
	}
	
	/**
	 * Get postParam array
	 *
	 * @return array $this->postParams
	 */
	public function getPostParam() {
		return $this->postParams;
	}
	
	/**
	 * Build the Oauth object.
	 * For v1.1, see: https://dev.twitter.com/docs/api/1.1
	 *
	 * @param string $url
	 *        	The API url
	 * @param string $requestMethod
	 *        	POST or GET
	 * @return string $oauth Oauth object.
	 */
	public function buildOauth() {
		if (! in_array ( strtolower ( $this->reqMethod ), array (
				'post',
				'get' 
		) )) {
			throw new Exception ( 'Request method must be either POST or GET' );
		}
		
		$consumer_key = $this->consumer_key;
		$consumer_secret = $this->consumer_secret;
		$oauth_access_token = $this->oauth_access_token;
		$oauth_access_token_secret = $this->oauth_access_token_secret;
		
		$oauth = array (
				'oauth_consumer_key' => $consumer_key,
				'oauth_nonce' => time (),
				'oauth_signature_method' => 'HMAC-SHA1',
				'oauth_token' => $oauth_access_token,
				'oauth_timestamp' => time (),
				'oauth_version' => '1.0' 
		);
		
		$getValue = $this->getGetParam ();
		
		if (! is_null ( $getValue )) {
			$getValue = str_replace ( '?', '', explode ( '&', $getValue ) );
			foreach ( $getValue as $g ) {
				$split = explode ( '=', $g );
				$oauth [$split [0]] = $split [1];
			}
		}
		
		$base_info = $this->buildBaseString ( $this->url, $this->reqMethod, $oauth );
		$composite_key = rawurlencode ( $consumer_secret ) . '&' . rawurlencode ( $oauth_access_token_secret );
		$oauth_signature = base64_encode ( hash_hmac ( 'sha1', $base_info, $composite_key, true ) );
		$oauth ['oauth_signature'] = $oauth_signature;
		
		return $oauth;
	}
	
	/**
	 * Generate the base string for cURL
	 *
	 * @param string $baseURI        	
	 * @param string $method        	
	 * @param array $params        	
	 *
	 * @return string Built base string
	 */
	private function buildBaseString($baseURI, $method, $params) {
		$return = array ();
		ksort ( $params );
		
		foreach ( $params as $key => $value ) {
			$return [] = "$key=" . $value;
		}
		
		return $method . "&" . rawurlencode ( $baseURI ) . '&' . rawurlencode ( implode ( '&', $return ) );
	}
	
	/**
	 * Generate authorization header for cURL
	 *
	 * @param array $oauth
	 *        	Array of oauth data generated by calling buildOauth()
	 *        	
	 * @return string $return Header for cURL
	 */
	private function buildAuthorizationHeader($oauth) {
		$return = 'Authorization: OAuth ';
		$values = array ();
		
		foreach ( $oauth as $key => $value ) {
			$values [] = "$key=\"" . rawurlencode ( $value ) . "\"";
		}
		
		$return .= implode ( ', ', $values );
		return $return;
	}
	private function parseTweet($response) { 
		$hashTagLink = "http://twitter.com/search?q=%23";
		$response = json_decode ( $response );
		
		$text = $response->text;
		$text = $this->linkifyTweet( $text, $response );
		$name = $response->user->name;
		$screen_name = $response->user->screen_name;
		$profile_image_url = $response->user->profile_image_url;
		$time = $this->convertDate ( $response->created_at );
		$media = $response->entities->media[0]->media_url;
		$mediaTarget = $response->entities->media[0]->url;
		
		$tweet ['text'] = $text;
		$tweet ['name'] = $name;
		$tweet ['screen_name'] = $screen_name;
		$tweet ['avatar'] = $profile_image_url;
		$tweet ['media_url'] = $media;
		$tweet ['media_target'] = $mediaTarget;
		$tweet ['time'] = $time;
		
		return json_encode ( $tweet , JSON_HEX_QUOT | JSON_HEX_TAG);
	}
	private function parseTweetList($response) { 
		$responses = json_decode ( $response );
		
		foreach ( $responses->statuses as $status ) {
			$text = $this->linkifyTweet( $status->text, $status );
			
			$tweet ['text'] = $text;
			$tweet ['name'] = $status->user->name;
			$tweet ['screen_name'] = $status->user->screen_name;
			$tweet ['avatar'] = $status->user->profile_image_url;
			$tweet ['media_url'] = $status->entities->media [0]->media_url;
			$tweet ['media_target'] = $status->entities->media [0]->url;
			$tweet ['created_at'] = $this->convertDate ( $status->created_at );
			
			$tweetList ['results'] [] = $tweet;
		}
		$tweetList ['metadata'] ['next_results'] = $responses->search_metadata->next_results;
		
		return json_encode ( $tweetList );
	}
	private function parseTimeline($response, $maxId) {
		$responses = json_decode ( $response );
		
		foreach ( $responses as $status ) {
			
			if ($status->id_str == $maxId)
				continue;
			
			$tweet ['text'] = $status->text;
			$tweet ['name'] = $status->user->name;
			$tweet ['screen_name'] = $status->user->screen_name;
			$tweet ['avatar'] = $status->user->profile_image_url;
			$tweet ['media_url'] = $status->entities->media [0]->media_url;
			$tweet ['media_target'] = $status->entities->media [0]->url;
			$tweet ['created_at'] = $this->convertDate ( $status->created_at );
			
			$tweetList ['results'] [] = $tweet;
			$tmpId = $status->id_str;
		}
		$tweetList ['metadata'] ['next_results'] = $tmpId;
		
		return json_encode ( $tweetList );
	}
	private function convertDate($str) {
		return date ( 'Y.m.d H:i', strtotime ( $str ) );
	}

	private function linkifyTweet($raw_text, $tweet = NULL) {
		// first set output to the value we received when calling this function
		$output = $raw_text;
		
		// create xhtml safe text (mostly to be safe of ampersands)
		$output = htmlentities ( html_entity_decode ( $raw_text, ENT_NOQUOTES, 'UTF-8' ), ENT_NOQUOTES, 'UTF-8' );
		
		// parse urls
		if ($tweet == NULL) {
			// for regular strings, just create <a> tags for each url
			$pattern = '/([A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+)/i';
			$replacement = '<a href="${1}" rel="external">${1}</a>';
			$output = preg_replace ( $pattern, $replacement, $output );
		} else {
			// for tweets, let's extract the urls from the entities object
			foreach ( $tweet->entities->urls as $url ) {
				$old_url = $url->url;
				$expanded_url = (empty ( $url->expanded_url )) ? $url->url : $url->expanded_url;
				$display_url = (empty ( $url->display_url )) ? $url->url : $url->display_url;
				$replacement = '<a href="' . $expanded_url . '" rel="external">' . $display_url . '</a>';
				$output = str_replace ( $old_url, $replacement, $output );
			}
			
			// let's extract the hashtags from the entities object
			foreach ( $tweet->entities->hashtags as $hashtags ) {
				$hashtag = '#' . $hashtags->text;
				$replacement = '<a href="http://twitter.com/search?q=%23' . $hashtags->text . '" rel="external">' . $hashtag . '</a>';
				$output = str_ireplace ( $hashtag, $replacement, $output );
			}
			
			// let's extract the usernames from the entities object
			foreach ( $tweet->entities->user_mentions as $user_mentions ) {
				$username = '@' . $user_mentions->screen_name;
				$replacement = '<a href="http://twitter.com/' . $user_mentions->screen_name . '" rel="external" title="' . $user_mentions->name . ' on Twitter">' . $username . '</a>';
				$output = str_ireplace ( $username, $replacement, $output );
			}
			
			// if we have media attached, let's extract those from the entities as well
			if (isset ( $tweet->entities->media )) {
				foreach ( $tweet->entities->media as $media ) {
					$old_url = $media->url;
					$replacement = '<a href="' . $media->expanded_url . '" rel="external" class="twitter-media" data-media="' . $media->media_url . '">' . $media->display_url . '</a>';
					$output = str_replace ( $old_url, $replacement, $output );
				}
			}
		}
		
		return $output;
	}
}
?>