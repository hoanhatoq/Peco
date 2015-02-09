<?
/******************************************************
 * Admin Control Panel File
 * Control to show Menu & Icon of Dashboard
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  header.php
 * Environment                :  PHP  version version 4, 5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/
class ControlPanel{
	var $arrSection		=	array();
	var $onLoadFunc		=	"";
	
	function ControlPanel(){
		//do nothing
	}
	/** 		
	* Add new Section
	*  
	* @param 				: string $title, string short_title, string imgsrc, string width
	* @return 			: none
	*/	
	function addSection($section_name, $title="Title of Section", $short_title = "Short Title", $imgsrc="", $width="120px"){
		$this->arrSection[$section_name] = array();
		$this->arrSection[$section_name]["title"] = $title;
		$this->arrSection[$section_name]["short_title"] = $short_title;
		$this->arrSection[$section_name]["imgsrc"] = $imgsrc;
		$this->arrSection[$section_name]["width"] = $width;
		$this->arrSection[$section_name]["totallink"] = 0;
	}
	/** 		
	* Add new link to section
	*  
	* @param 				: string $section_name, string site_name, string link_name, string link_href, string imgsrc
	* @return 			: none
	*/
	function addLink($section_name, $site_name, $link_name="", $link_href="", $imgsrc=""){
		global $core;
		$arr = array();
		$arr["site_name"] = $site_name;
		$arr["link_name"] = $link_name;
		$arr["link_href"] = $link_href;
		$arr["imgsrc"] = $imgsrc;
		$this->arrSection[$section_name]["link"][] = $arr;
		$this->arrSection[$section_name]["totallink"]++;
	}
	/** 		
	* Return image src of module_sub_act (site_name)
	*  
	* @param 				: string site_name
	* @return 			: string
	*/
	function getImgSrc($site_name=""){
		if ($site_name==""){
			global $mod;
			$site_name = $mod."_default_default";
		}
		if (is_array($this->arrSection))
		foreach ($this->arrSection as $key => $val){
			if (is_array($val["link"]))
			foreach ($val["link"] as $key1 => $val1){
				if ($val1['site_name']==$site_name){
					return ADMIN_URL_IMAGES."/".$val1['imgsrc'];
				}
			}
		}
		return ADMIN_URL_IMAGES."/largeicon/noavatar.png";
	}
	/** 		
	* Display section $section_name
	*  
	* @param 				: string $section_name
	* @return 			: html
	*/	
	function showSection($section_name){
		global $core;
		$html = "<div class='jpsection'>";
		if (is_array($this->arrSection[$section_name]["link"]) && ($this->arrSection[$section_name]["totallink"]>0)){
			$section_title = $this->arrSection[$section_name]["title"];
			$html.= "<h2>$section_title</h2>";
			$html.= "<ul id='section_$section_name'>";
			foreach ($this->arrSection[$section_name]["link"] as $key => $val){
				$link_href = $val["link_href"];
				$link_name = $val["link_name"];
				$html.= "<li><a href='$link_href'>$link_name</a></li>";				
			}
			$html.= "</ul>";
		}		
		$html.= "</div>";
		return $html;
	}
	/** 		
	* Expand a section 
	*  
	* @param 				: string $section_name
	* @return 			: none
	*/
	function expandSection($section_name){
		if ($this->arrSection[$section_name]["totallink"]>0)
		$this->onLoadFunc.= "expandSection('tbl_$section_name', 'img_$section_name');";
	}
	/** 		
	* Collapse a section
	*  
	* @param 				: string $section_name
	* @return 			: none
	*/
	function collapseSection($section_name){
		if ($this->arrSection[$section_name]["totallink"]>0)	
		$this->onLoadFunc.= "collapseSection('tbl_$section_name', 'img_$section_name');";
	}
	/** 		
	* Show onload function to run when page loaded
	*  
	* @param 				: none
	* @return 			: html
	*/
	function showOnLoadFunc(){
		$html.= "<script language='javascript'>";
		$html.= "function onLoadFunc(){";
		$html.= $this->onLoadFunc;
		$html.= "}"; 
		$html.= "</script>";
		return $html;
	}
	/** 		
	* Show all section
	*  
	* @param 				: none
	* @return 			: html
	*/
	function showAllSection(){
		$html = "";
		if (is_array($this->arrSection))
		foreach ($this->arrSection as $key => $val){
			$html.= $this->showSection($key);
		}
		return $html;
	}
	/** 		
	* Show navigation header
	*  
	* @param 				: none
	* @return 			: html
	*/
	function showNaviHeader(){
		global $core;
		$html = "";
		if (is_array($this->arrSection))
		foreach ($this->arrSection as $key => $val)
		if ($val['totallink']>0){		
			$img = ($val['imgsrc']!="")? "<img src='".ADMIN_URL_IMAGES."/".$val['imgsrc']."' border='0' align='left' >" : "";
			$html .= "
			<td class='menubutton' id='m_".$key."' nowrap  min-width='".$val['width']."' onmouseover=\"this.className='menubuttonActive';menuLayers.show('menu_".$key."', event, 'm_".$key."')\" onmouseout=\"this.className='menubutton';menuLayers.hide()\" title='".$core->getLang($val['title'])."'>".$img."&nbsp;".$core->getLang($val['short_title'])."</td>
			";
		}
		
		return $html;
	}
	/** 		
	* Show div header
	*  
	* @param 				: string $section_name, string class_name
	* @return 			: html
	*/
	function showDivHeader($section_name, $class_name='menu'){
		global $core;
		$html= "<div id='menu_$section_name' class='$class_name'><ul>";
		if (is_array($this->arrSection[$section_name]["link"]))
		foreach ($this->arrSection[$section_name]["link"] as $key => $val){
			$html.= "<li><a href='".$val["link_href"]."'>&curren; ".$val["link_name"]."</a></li>";
		}	
		$html.= "</ul></div>";
		return $html;
	}
}
?>