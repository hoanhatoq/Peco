<?php
class CurlUtil {
	private $core;
	public $result;
	public $pathCookies = false;
	public $show_header = false;
	public $referer = false;
	public $follow = false;
	
	public function __construct() {
		
	}
	
// 	public function __construct(&$core) {
// 		$this->core = &$core;
// 	}
	
	private function doRequest($method, $url, $vars) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, $this->show_header );
		// curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0' );
		curl_setopt ( $ch, CURLOPT_REFERER, $this->referer );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, $this->follow );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		if ($this->pathCookies) {
			curl_setopt ( $ch, CURLOPT_COOKIEJAR, $this->pathCookies );
			curl_setopt ( $ch, CURLOPT_COOKIEFILE, $this->pathCookies );
		}
		
		if ($method == 'POST') {
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $vars );
		}
		
		$data = curl_exec ( $ch );
		curl_close ( $ch );
		
		if ($data) {
			if (isset ( $this->callback )) {
				$callback = $this->callback;
				$this->callback = false;
				return call_user_func ( $callback, $data );
			} else {
				return $data;
			}
		} else {
			return @curl_error ( $ch );
		}
	}
	
	public function get($url) {
		return $this->doRequest ( 'GET', $url, 'NULL' );
	}
	
	public function post($url, $vars) {
		return $this->doRequest ( 'POST', $url, $vars );
	}
}
?>