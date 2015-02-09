// JavaScript Document
/*************************************************************************
  This code is from Dynamic Web Coding at http://www.dyn-web.com/
  Copyright 2003 by Sharon Paine 
  See Terms of Use at http://www.dyn-web.com/bus/terms.html
  regarding conditions under which you may use this code.
  This notice must be retained in the code as is!
*************************************************************************/

var menuLayers = {
  timer: null,
  activeMenuID: null,
  offX: 4,   // horizontal offset 
  offY: 6,   // vertical offset 
  show: function(id, e, idroot) {
    var mnu = document.getElementById? document.getElementById(id): null;
    var mnu1 = document.getElementById? document.getElementById(idroot): null;
    if (!mnu) return;
    this.activeMenuID = id;
    if ( mnu.onmouseout == null ) mnu.onmouseout = this.mouseoutCheck;
    if ( mnu.onmouseover == null ) mnu.onmouseover = this.clearTimer;
    viewport.getAll();
    this.position(mnu,e, mnu1);
  },
  
  hide: function() {
    this.clearTimer();
    if (this.activeMenuID && document.getElementById) 
      this.timer = setTimeout("document.getElementById('"+menuLayers.activeMenuID+"').style.visibility = 'hidden'", 200);
  },
  
  position: function(mnu, e, mnu1) {
    var x = e.pageX? e.pageX: e.clientX + viewport.scrollX;
    var y = e.pageY? e.pageY: e.clientY + viewport.scrollY;
//	alert(mnu1.offsetHeight);
	var o = findPos(mnu1);

	if ( x + mnu.offsetWidth + this.offX > viewport.width + viewport.scrollX )
    	x = x - mnu.offsetWidth - this.offX;
    else 
		x = x + this.offX;
  
    if ( y + mnu.offsetHeight + this.offY > viewport.height + viewport.scrollY )
    	y = ( y - mnu.offsetHeight - this.offY > viewport.scrollY )? y - mnu.offsetHeight - this.offY : viewport.height + viewport.scrollY - mnu.offsetHeight;
    else 
		y = y + this.offY;
    
	mnu.style.width = mnu1.offsetWidth + 1 + "px";
    mnu.style.left = o[0] + "px"; 
	mnu.style.top = o[1] + mnu1.offsetHeight + "px";
    this.timer = setTimeout("document.getElementById('" + menuLayers.activeMenuID + "').style.visibility = 'visible'", 200);
  },
  
  mouseoutCheck: function(e) {
    e = e? e: window.event;
    // is element moused into contained by menu? or is it menu (ul or li or a to menu div)?
    var mnu = document.getElementById(menuLayers.activeMenuID);
    var toEl = e.relatedTarget? e.relatedTarget: e.toElement;
    if ( mnu != toEl && !menuLayers.contained(toEl, mnu) ) menuLayers.hide();
  },
  
  // returns true of oNode is contained by oCont (container)
  contained: function(oNode, oCont) {
    if (!oNode) return; // in case alt-tab away while hovering (prevent error)
    while ( oNode = oNode.parentNode ) 
      if ( oNode == oCont ) return true;
    return false;
  },

  clearTimer: function() {
    if (menuLayers.timer) clearTimeout(menuLayers.timer);
  }
  
}

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
}