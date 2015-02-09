<?
/******************************************************
 * Class Paging
 *
 * Pagination for admin page purpose
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsPaging.php
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
class Paging{
	var $baseURL			=	"";
	var $formName 			=	"";	
	var $curPage			=	0;
	var $hasPaging			=	true;
	var $totalRows			=	0;
	var $totalPage 			=	0;
	var $rowsPerPage		=	10;
	var $itemname			=	"row";
	var $showPageNums		=	5;
	var $showStatstic		=	true;
	var $showPrevLink		=	true;
	var $showNextLink		=	true;
	var $showFirstLink 		=	false;
	var $showLastLink		=	false;
	var $showGotoBox		=	true;
	
	function Paging($_curPage="", $_rowsPerPage=10, $_itemname="record"){
		if (isset($_POST["gotoPage"]) && $_POST["gotoPage"]!=""){
			$this->curPage = $_POST["gotoPage"];
		}else{
			if ($_curPage=="" && $_curPage!="0"){
				$_curPage = isset($_GET["page"])? $_GET["page"] : 0;
			}
			$this->curPage = $_curPage;
		}
		$this->rowsPerPage = $_rowsPerPage;
		$this->itemname = $_itemname;
	}
	
	function setBaseURL($_baseURL=""){
		$this->baseURL = $_baseURL;
	}
	
	function getQueryLimit($sql){
		$start = $this->rowsPerPage*($this->curPage);
		return $sql." LIMIT $start, ".$this->rowsPerPage;
	}
	
	function setFormName($_formName="theForm"){
		$this->formName = $_formName;
	}
	
	function setCurPage($_curPage=0){
		$this->curPage = $_curPage;
	}
	
	function setHasPaging($_hasPaging=true){
		$this->hasPaging = $_hasPaging;
	}
	
	function setTotalRows($_totalRows=0){
		$this->totalRows = $_totalRows;
	}
	
	function setRowsPerPage($_rowsPerPage=10){
		$this->rowsPerPage = $_rowsPerPage;
	}
	
	function setShowStatstic($_showStatstic=true){
		$this->showStatstic = $_showStatstic;
	}
	
	function setShowPageNums($_showPageNums=0){
		$this->showPageNums = $_showPageNums;
	}
	
	function setShowPrevLink($_showPrevLink=true){
		$this->showPrevLink = $_showPrevLink;
	}
	
	function setShowNextLink($_showNextLink=true){
		$this->showNextLink = $_showNextLink;
	}
	
	function setShowFirstLink($_showFirstLink=true){
		$this->showFirstLink = $_showFirstLink;
	}
	
	function setShowLastLink($_showLastLink=true){
		$this->showLastLink = $_showLastLink;
	}

	function setShowGotoBox($_showGotoBox=true){
		$this->showGotoBox = $_showGotoBox;
	}
	function getLang($key){
		global $_LANG;
		if (strpos($key, " ")!==false){
			$arr = str_word_count($key, 1);
			foreach ($arr as $k => $v){
				$val = trim($v, "'?,");
				$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
				$key = str_replace($val, $trans, $key);
				
			}
			return $key;
		}else{
			$val = trim($key, "'?,");
			$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
			$key = str_replace($val, $trans, $key);
			return $key;
		}
		return $key;
	}
	function showPaging($theForm="theForm"){
		if ($this->baseURL=="" || $flag==0){
			$this->baseURL = "?".preg_replace("/\&page=(\w+)/e", "", $_SERVER['QUERY_STRING']);
		}
		if ($theForm=="") $theForm = $this->formName;
		$this->totalPage = ceil($this->totalRows/$this->rowsPerPage);
		if ($this->totalPage<1) return "";
		//echo $this->curPage;
		$gotoPageOptions = "";
		for ($i=0; $i<$this->totalPage; $i++){
			$selected = ($this->curPage==$i)? "selected" : "";
			$gotoPageOptions.="<option value='$i' $selected >".($i+1)."</option>";
		}
		$butNext = ($this->curPage < $this->totalPage-1)? "<a href='$this->baseURL&page=".($this->curPage+1)."' title='".($this->curPage+2)."'>".$this->getLang("Next")."</a>" : $this->getLang("Next");
		$butPrev = ($this->curPage > 0)? "<a href='$this->baseURL&page=".($this->curPage-1)."' title='".($this->curPage)."'>".$this->getLang("Prev")."</a>" : $this->getLang("Prev");
		$listPage = "";
		$first = intval($this->curPage/$this->showPageNums)*$this->showPageNums;
		for ($i=0; $i<$this->showPageNums; $i++)
		if ($first+$i<$this->totalPage){
			$p = $first+$i;
			$t = ($this->curPage == $p)? "<b>".($p+1)."</b>" : ($p+1);
			$listPage .= ($this->curPage!=$p)? "<a href='".$this->baseURL."&page=$p' title='".($p+1)."'>$t</a>&nbsp" : "$t&nbsp;";		
		}
		if ($listPage=="") $listPage = "0";
		$butNNext = ($first+$this->showPageNums<$this->totalPage-1)? "<a href='$this->baseURL&page=".($first+$this->showPageNums)."'  title='".($first+$this->showPageNums+1)."'>...</a>" : "";
		$butPPrev = ($first-$this->showPageNums>=0)? "<a href='$this->baseURL&page=".($first-$this->showPageNums)."' title='".($first-$this->showPageNums+1)."'>...</a>" : "";
		
		
		if ($this->className!="")
			$html ="<table class='".$this->className."'>";
		else
			$html ="<table cellpadding='0' cellspacing='0' width='100%' border='0' style='font-size:14px'>";
		$html.="<tr>";
		if ($this->showStatstic){
			$html.=	"<td width='30%' align='left' nowrap>".$this->getLang("Total").": ".$this->totalRows." ".$this->getLang($this->itemname).", ".$this->totalPage." ".$this->getLang("page")."</td>";
		}else{
			$html.=	"<td width='30%' align='left' nowrap></td>";
		}
		$align = ($this->showGotoBox)? 'center' : 'right';
		$html.= "<td align='$align' nowrap>  $butPrev | $butPPrev $listPage $butNNext | $butNext </td>";
		if ($this->showGotoBox){
			$html.= "<td width='30%' align='right' nowrap>".$this->getLang("Goto").":";
			$html.= "<select name='gotoPage' style='font-size:11px' onChange='document.$theForm.submit()'>$gotoPageOptions</select></td>";
		}else{
			//$html.= "<td width='30%' align='right' nowrap></td>";
		}
		$html.="</tr>";
		$html.="</table>";
		return $html;
	}
	//Begin Added 08/10/2012
	function getRewriteURL($page=1){
		if ($page==1) return $this->baseURL;
		return $this->baseURL."/page/".$page;
	}
	function getNoRewriteURL($page=1){
		if ($page==0) return $this->baseURL;
		return $this->baseURL."?page=".$page;
	}
	function showPagingNew2($theForm="theForm"){
		if ($theForm=="") $theForm = $this->formName;
		$this->totalPage = ceil($this->totalRows/$this->rowsPerPage);
		if ($this->totalPage<2) return "";
		$gotoPageOptions = "";
		for ($i=0; $i<$this->totalPage; $i++){
			$selected = ($this->curPage==$i)? "selected" : "";
			$gotoPageOptions.="<option value='$i' $selected >".($i+1)."</option>";
		}
		if ($this->curPage < $this->totalPage-1){
			$butNext = "<li>";
			$butNext.= "<a href='".$this->getNoRewriteURL($this->curPage+1)."' title='".($this->curPage+2)."'>".$this->getLang("Next")."&raquo;</a>";
			$butNext.= "</li>";
		}else{
			$butNext = "<li class='disabled'>";
			$butNext.= "<a>".$this->getLang("Next")."&raquo;</a>";
			$butNext.= "</li>";
		}
		if ($this->curPage > 0){
			$butPrev = "<li>";
			$butPrev.= "<a href='".$this->getNoRewriteURL($this->curPage-1)."' title='".($this->curPage)."'>&laquo;".$this->getLang("Prev")."</a>";
			$butPrev.= "</li>";
		}else{
			$butPrev = "<li class='disabled'>";
			$butPrev.= "<a>&laquo;".$this->getLang("Prev")."</a>";
			$butPrev.= "</li>";		
		}
		$listPage = $butPPrev = $butNNext = "";
		$first = intval($this->curPage/$this->showPageNums)*$this->showPageNums;
		for ($i=0; $i<$this->showPageNums; $i++)
		if ($first+$i<$this->totalPage){
			$p = $first+$i;
			$t = ($this->curPage == $p)? "".($p+1)."" : ($p+1);
			if ($this->curPage!=$p){
				$listPage .= "<li>";
				$listPage .= "<a href='".$this->getNoRewriteURL($p)."' title='".($p+1)."'>$t</a>";
				$listPage .= "</li>";
			}else{
				$listPage .= "<li class='active'>";
				$listPage .= "<a>$t</a>";
				$listPage .= "</li>";			
			}
		}
		if ($first >= $this->showPageNums){
			$butPPrev = "<li><a href='".$this->getNoRewriteURL($first-$this->showPageNums)."' title='".($first-$this->showPageNums+1)."'>...</a></li>";
		}
		if ($p+1 < $this->totalPage){
			$butNNext = "<li><a href='".$this->getNoRewriteURL($p+1)."' title='".($p+2)."'>...</a></li>";
		}
				
		$html.= " $butPrev $butPPrev $listPage $butNNext $butNext";
		return $html;
	}
	//End Added 08/10/2012
}
?>