<?
/******************************************************
 * Class DatePicker
 *
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsDatePicker.php
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
class DatePicker{
	var $name		=	"";
	var $format		=	"%m/%d/%Y %H:%M";
	var $value		=	"";
	var $attr		=	"style='width:110px'";
	var $showTime	=	1;//1: Yes, 0:No
	var $iconCal	=	"";
	
	function DatePicker($_name="", $_value="", $_format="%m/%d/%Y %H:%M", $_showTime=1, $_attr="style='width:110px'"){
		$this->name = $_name;
		$this->value = $_value;
		$this->format = $_format;
		$this->showTime = $_showTime;
		$this->attr = $_attr;
		$this->iconCal = ADMIN_URL_IMAGES."/icon/imgcal.gif";
	}
	
	function showJSCSS(){
		$html = "<SCRIPT src='".ADMIN_URL_JS."/calendar.js' type='text/javascript'></SCRIPT>";
		$html.= "<SCRIPT src='".ADMIN_URL_JS."/calendar-en.js' type='text/javascript'></SCRIPT>";
		$html.= "<SCRIPT src='".ADMIN_URL_JS."/calendar-setup.js' type='text/javascript'></SCRIPT>";
		$html.= "<link 	href='".ADMIN_URL_CSS."/calendar-system.css'	type='text/css' rel='stylesheet'/>";
		return $html;
	}
	
	function showInputDate($showlink=true){
		$strShowTime = ($this->showTime)? "true" : "false";
		$id = "datepicker_".$this->name;
		$html = "<input type=\"text\" name=\"".$this->name."\" id=\"".$this->name."\" type=\"text\" value=\"".
					$this->value."\" ".$this->attr." />\n";
		$now_format = strftime($this->format, time());					
		$html.= "<a href='#' id='$id'>\n";
		$html.= "<img align=\"middle\" border=\"0\" src=\"".$this->iconCal."\" alt=\"Choose Date\" />\n";
		$html.= "</a>";
		if ($showlink){
			$html.= "<a href='#' onClick=\"javascript:document.getElementById('".$this->name."').value = '".$now_format."';return false;\" title='Get current time'>[Now]</a>\n";
		}
		$html.= "<script type=\"text/javascript\" language=\"JavaScript\">\n";
		$html.= "Calendar.setup({\n";
		$html.= "inputField     :    \"".$this->name."\",\n";
		$html.= "ifFormat       :    \"".$this->format."\",\n";		
		$html.= "showsTime      :    ".$strShowTime.",\n";
		$html.= "button         :    \"$id\",\n";
		$html.= "singleClick    :    false\n";
		$html.= "});\n";
		$html.= "</script>\n";
		$html.= "<script>\n";
		//$format1 = str_replace("%", "", $this->format);
		//$value_format = ($this->value!="" && intval($this->value)>61200)? @date($format1, $this->value) : "";
		$value_format = ($this->value!="")? strftime($this->format, $this->value) : "";
		$html.= "document.getElementById(\"".$this->name."\").value = '".$value_format."';\n";
		$html.= "</script>\n";
		return $html;		
	}
}
?>