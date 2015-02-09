<?php
/******************************************************
 * Image Thumbnails
 *
 * Resize image & create thumbs at /uploads/thumbs for caching
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  index.php
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

define("DIR_CMS", $_SERVER['DOCUMENT_ROOT'].trim(dirname(" ".$_SERVER['SCRIPT_NAME'])));
define("URL_CMS", "http://".$_SERVER['HTTP_HOST'].trim(dirname(" ".$_SERVER['SCRIPT_NAME'])));	
define("DIR_UPLOADS", DIR_CMS."/uploads");

if(isset($_GET['pic'])){
	$pic = isset($_GET["pic"])? $_GET["pic"] : "";
	if (isset($_GET["encode"]) && $_GET["encode"]==1 && $pic!=""){
		$pic = base64_decode($_GET['pic']);
	}
	if ($pic=="") $pic = "nopic.jpg";
	
	$w = isset($_GET["w"])? $_GET["w"] : 148;
	$h = isset($_GET["h"])? $_GET["h"] : 101;
	$img = new img(DIR_UPLOADS."/".$pic, $w, $h);
	$img->resize($w, $h, false);
	$img->show();
}
function utf8_nosign_noblank($str){
	$len = strlen($str);
	$tmp = "";
	$f = "";
	for ($i=0; $i<$len; $i++){
		if (($str[$i]>='a' && $str[$i]<='z') || ($str[$i]>='0' && $str[$i]<='9')){
			$ch = $str[$i];
			$f = $ch;
		}else
			$ch = '';
		if ($str[$i]==' ' && $str[$i]!=$f){ 
			$ch = '-'; 
			$f = ' ';
		}
		if ($str[$i]=='-' && $str[$i]!=$f && $f!=' '){
			$ch = '-';
			$f = '-';
		}
		$tmp.= ($tmp=="" && $ch=='-')? '' : $ch;		
	}
	return $tmp;
}
function read_file($fid){
	$file = @fopen($fid,"rb");
	if ($file) {
		while(!feof($file)) {
			print(fread($file, 1024*8));
			flush();
			if (connection_status()!=0) {
				@fclose($file);
				die();
			}
		}
		@fclose($file);
	}
}

/**				
 * Short description for file				
 * 				
 * Long description for file (if any)...				
 *				
 * 				
 * @author An implementor name is described (describe with a half-width alphabetic character). 				
 */ 				

class img {
	var $sourceFile = "";
	var $image = '';
	var $temp = '';
	var $thumbs = "";
	var $image_type = "jpg";
	
	/** 																																				
	 * Describe the purpose of the class in a brief but complete manner																																				
	 *  (Ex: Loads a configuration from a standard configuration XML file.)																																				
	 * @param 								The argument of a method is described. 																												
				: 					 However, @param and one argument describe per line. 																												
	 * @return 								An instruction of the return value of a method is described. 																												
	 * @exception 								The exception class to generate is described. 																												
	 * @throws 								Throws SecurityException																												
	 */ 																																				
	function img($sourceFile, $width=100, $height=100){
		//begin jvb added
		$this->sourceFile = $sourceFile;
		if(!file_exists($sourceFile)){
			$this->sourceFile = DIR_UPLOADS."/nopic.jpg";
		}
		$tmp_thumbs_name = md5($this->sourceFile)."_".basename($this->sourceFile);
		$this->thumbs = "tn_".$width."x".$height."_".$tmp_thumbs_name ;
		if(file_exists(DIR_UPLOADS."/thumbs/".$this->thumbs)){
			$this->sourceFile = DIR_UPLOADS."/thumbs/".$this->thumbs;
			read_file($this->sourceFile);
			exit();
		}
		//end jvb added
		if(file_exists($this->sourceFile)){
			if (strtolower(substr($this->sourceFile, -3))=="jpg" || strtolower(substr($this->sourceFile, -4))=="jpeg"){
				$this->image = imagecreatefromjpeg($this->sourceFile);
				$this->image_type= "jpg";
			}else
			if (strtolower(substr($this->sourceFile, -3))=="gif"){
				$this->image = imagecreatefromgif($this->sourceFile);
				$this->image_type= "gif";
			}else
			if (strtolower(substr($this->sourceFile, -3))=="png"){
				$this->image = imagecreatefrompng($this->sourceFile);
				$this->image_type= "png";
			}
		} else {
			$this->errorHandler();
			
		}
		return;
	}
	
	function resize($width = 100, $height = 100, $aspectradio = true){
		//begin jvb added
		if(file_exists(DIR_UPLOADS."/thumbs/".$this->thumbs)){
			return;
		}
		//end jvb added
		$o_wd = imagesx($this->image);
		$o_ht = imagesy($this->image);
		if(isset($aspectradio)&&$aspectradio) {
			$w = round($o_wd * $height / $o_ht);
			$h = round($o_ht * $width / $o_wd);
			if(($height-$h)<($width-$w)){
				$width =& $w;
			} else {
				$height =& $h;
			}
		}
		if ($o_wd*$height >= $o_ht*$width) $i = 1; else $i = 2;
		$o_x = $o_y = 0;
		if ($i==1){
			$newheight = $height;
			$newwidth = round($o_wd*$newheight/$o_ht);
			$o_x = round(($newwidth-$width)/2);
		}else{
			$newwidth = $width;
			$newheight = round($o_ht*$newwidth/$o_wd);	
			$o_y = round(($newheight-$height)/2);
		}
		$this->temp = imageCreateTrueColor($width,$height);
		imageCopyResampled($this->temp, $this->image, 0, 0, $o_x, $o_y, $newwidth, $newheight, $o_wd, $o_ht);
		$this->sync();
		//begin jvb added
		$this->store(DIR_UPLOADS."/thumbs/".$this->thumbs);
		//end jvb added
		return;
	}
	
	function sync(){
		$this->image =& $this->temp;
		unset($this->temp);
		$this->temp = '';
		return;
	}
	
	function show(){
		$this->_sendHeader();
		imagejpeg($this->image, NULL, 100);
		imagedestroy($this->image);
		return;
	}
	
	function _sendHeader(){
		if ($this->image_type=="jpg"){
			header('Content-Type: image/jpeg');
		}elseif ($this->image_type=="gif"){
			header('Content-Type: image/gif');
		}elseif ($this->image_type=="png"){
			header('Content-Type: image/png');
		}
	}
	
	function errorHandler(){
		echo "error";
		exit();
	}
	
	function store($file){
		if ($this->image_type=="jpg"){
			imagejpeg($this->image,$file, 100);
		}elseif ($this->image_type=="gif"){
			imagegif($this->image,$file);
		}elseif ($this->image_type=="png"){
			imagepng($this->image,$file);
		}
		return;
	}
	
	function watermark($pngImage, $left = 0, $top = 0){
		ImageAlphaBlending($this->image, true);
		$layer = ImageCreateFromPNG($pngImage); 
		$logoW = ImageSX($layer); 
		$logoH = ImageSY($layer); 
		ImageCopy($this->image, $layer, $left, $top, 0, 0, $logoW, $logoH); 
	}
}

?>
