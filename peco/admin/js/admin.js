/** 		
* Redirect to url
*  
* @param 				: string url
* @return 			: false
*/
function gotoUrl(url){
	window.location.href = url;
	return false;
}
/** 		
* Logout system
*  
* @param 				: none
* @return 			: none
*/
function logout(){
	if (confirm("Do you want to log out?\n\n[OK]: Yes     [Cancel]: Cancel")){
		gotoUrl("?mod=_login&act=logout");
		return true;
	}
	return false;
}
/** 		
* Select all item in datagrid
*  
* @param 				: string frmName
* @return 			: none
*/
function SelectItem(frmName) {
	var f = frmName.form;
	var dem = 0;	
	for (var i=0;i<f.elements["chkItem"].length;i++) {
		if (!f.elements["chkItem"][i].checked) {
			f.elements["chkAll"].checked = frmName.unchecked;
			return;
		}		
	}		
	for (var i=0;i<f.elements["chkItem"].length;i++) {
		if (f.elements["chkItem"][i].checked) {
			dem++;		
		}		
	}
	if (dem == i) {
		f.elements["chkAll"].checked = frmName.checked;
	}	
}
/** 		
* Select all item in datagrid
*  
* @param 				: string frmName
* @return 			: none
*/
function SelectAll(frmName) {
	var f = frmName.form;	
	if (!f.elements["chkItem"]) return;
	if (f.elements["chkItem"][0]) {
		for (var i=0; i<f.elements["chkItem"].length; i++)
			f.elements["chkItem"][i].checked = frmName.checked;	
	} else {
		f.elements["chkItem"].checked = frmName.checked;	
	}
}
/** 		
* Get object by name
*  
* @param 				: string name
* @return 			: object
*/
function getObj(name)
{
  if (document.getElementById)
  {	
  	var o = document.getElementById(name);
  	this.obj = o;
	this.style = o.style;
  }
  else if (document.all)
  {
	this.obj = document.all[name];
	this.style = document.all[name].style;
  }
  else if (document.layers)
  {
   	this.obj = document.layers[name];
   	this.style = document.layers[name];
  }
  return this;
}
/** 		
* Submit a form
*  
* @param 				: string formid
* @return 			: none
*/
function submitForm(formid){
	if (typeof formid == "undefined"){
		formid = "theForm";
	}
	$("#"+formid).submit();
	return false;
}
/** 		
* Show popup
*  
* @param 				: string url, string title, string twidth, string theight
* @return 			: none
*/
function openPopup(url, title, twidth, theight){
	var tposx= (screen.width- twidth)/2
	var tposy= (screen.height- theight)/2;		
	var newWin=window.open(url, title, "toolbar=no,width="+ twidth+",height="+ theight+ ",directories=no,status=no,scrollbars=yes,resizable=no,menubar=no, location=no")
	newWin.moveTo(tposx,tposy);
	newWin.focus();	
}
/** 		
* Refesh opener and close
*  
* @param 				: none
* @return 			: none
*/
function refreshAndClose() {
	window.opener.location.reload(true);
	window.close();
}