<?php
set_time_limit(0);

include_once(DIR_COMMON."/class.simple_html_dom.php");
include_once(DIR_PEAR."/Request.php");

class Parser {
	public function __construct() {}
	
	public function processLink($link) {
		$charset = "UTF-8";	
		$request = new HTTP_Request($link);
		$request->_allowRedirects = true;
		$error = $request->sendRequest();
		
		if( PEAR::isError($error) ) {
			return null;
		}
		
		if($request->getResponseCode() != '200' ) {
			return null;
		}
		
		$html = $request->getResponseBody();
		
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		
		$title = "";
		$description = "";
		
		$titleList = $dom->getElementsByTagName('title');
		if($titleList->length > 0){
			$title = $titleList->item(0)->nodeValue;
		}
		
		$metaList = $dom->getElementsByTagName('meta');
		$len = $metaList->length;
		for ($i = 0; $i < $len; $i++) {
			$meta = $metaList->item($i);
			$metaName = strtolower($meta->getAttribute('name'));
			$metaProp = strtolower($meta->getAttribute('property'));
			
			if($metaName == 'description')
				$description = $meta->getAttribute('content');
			
			if($metaProp == 'og:image') {
				$metaImg = $meta->getAttribute('content');
				$images[] 	 = $metaImg;
			}
				
		}
		
		$imgList = $dom->getElementsByTagName('img');
		$len = $imgList->length;
		for ($i = 0; $i < $len; $i++) {
			$img = $imgList->item($i);
			$imgSrc = $img->getAttribute('src');
			
			if (strpos($imgSrc, ".jpg")===false && strpos($imgSrc, ".jpeg")===false && strpos($imgSrc, ".png")===false && strpos($imgSrc, ".gif")===false)
				continue;
			
			if (filter_var($imgSrc, FILTER_VALIDATE_URL) === FALSE) {
				$domain = parse_url($link);
				$imgSrc = $domain['scheme'] . '://' . $domain['host'] . '/' . $imgSrc;
			}
			
			list($width, $height) = getimagesize($imgSrc);
			if($width<120 && $height<120)
				continue;
			
			$images[] = $imgSrc;
		}	
		
		$images   = array_unique($images);
		$totalImg = count($images);
		
		$res["title"] = $title;
		$res["description"] = $description;
		$res["url"] = $link;
		$res["images"] = $images;
		$res["totalImg"] = $totalImg;
		
		return $res;
	}
}
?>