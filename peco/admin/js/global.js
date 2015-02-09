/**
 * Show error after element
 * 
 */
function show_validate_message(obj, msg){
	remove_validate_message(obj);
	$(obj).after("<div class='validate_message'>" + msg + "</div>");
}
/**
 * Remove validate message
 * 
 */
function remove_validate_message(obj){
	$(obj).parent().find(".validate_message").remove();
}
/** 		
* Resize and crop view port of image
*  
* @param 			: object obj, int width, int height
* @return 			: false
*/
function resizeCropThumb(obj, fw, fh){
	var w = obj.width;
	var h = obj.height;	 
	if (typeof fw == 'undefined') fw = 160;
	if (typeof fh == 'undefined') fh = 160;
	//console.log(w + " "+h);
	if (w<h){		
		$(obj).attr('width', '100%');
		$(obj).attr('height', 'auto');
		var mgtop = (h-fw)/2;
		$(obj).attr('style', 'margin-top:-'+mgtop+'px; margin-left:0px');					
	}else{
		var newh = fw, neww = fh*w / h;
		$(obj).attr('width', 'auto');
		$(obj).attr('height', '100%');
		var mgleft = (neww-fw)/2;
		$(obj).attr('style', 'margin-top:0px; margin-left:-'+mgleft+'px');					 
	}
}
/** 		
* Preview thumbnail of image when browser
*  
* @param 			: object input, object imgobj
* @return 			: false
*/
function setPreviewAvatar(input, imgobj) {
	if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(input.files[0].name)) {
		alert('Only file JPG, JPEG, GIF, PNG are accepted');
		input.value = "";
		return false;
	}
	if (input.files[0].size > 1*1024*1024){
		alert("File size must be smaller than 1 MB");
		input.value = "";
		return false;
	}

	if (input.files && input.files[0]) {
		var reader = new FileReader();			
		reader.onload = function (e) {
			$(imgobj).attr('src', e.target.result);			
			$(imgobj).load(function(){
				resizeCropThumb(this);
				var n = $(input).attr('name');
				if ($("#"+n+"_base64").length>0){
					$("#"+n+"_base64").val(e.target.result);
				}
			});
		}			
		reader.readAsDataURL(input.files[0]);
	}
	return false;
}
/**
 * Check validate Add User Form
 * 
 * @param 			: none
 * @return 			: true of false
 */
function check_validate_user_add(){	
	return true;
}
/**
 * Check validate Add Category Form
 * 
 * @param 			: none
 * @return 			: true of false
 */
function check_validate_category_add(){	
	return true;
}
/**
 * Check validate Add Topic Form
 * 
 * @param 			: none
 * @return 			: true of false
 */
function check_validate_topic_add(){	
	return true;
}
/**
 * Check validate Add Feature Form
 * 
 * @param 			: none
 * @return 			: true of false
 */
function check_validate_feature_add(){	
	return true;
}