/** 		
* Show/Hidden menu at button Setting
*  
* @param 			: none
* @return 			: false
*/
function toggleSetting(){
	if ($('#nav_sub_setting').is(':hidden')) {
			// add one mousedown event to html
			$('html').one('mousedown', function(event){
				if(!$(event.target).closest('#nav_sub_setting').length) {
						if($('#nav_sub_setting').is(":visible")) {
								$('#nav_sub_setting').hide();
						}
				}
			});
			$('#nav_sub_setting').show();
	} 
	else {
			$('#nav_sub_setting').hide();
	}
	return false;
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
			$('#'+imgobj).attr('src', e.target.result);
		}			
		reader.readAsDataURL(input.files[0]);
	}
	return false;
}
/** 		
* Increase favorite of article_id
*  
* @param 			: int article_id
* @return 			: false
*/
function addFavorites(article_id){
	$.ajax({	type: "POST",
		url: URL_CMS + "/?sub=ajax&act=add_favorite",
		dataType: 'json',
		async : false,
		data: {'article_id' : article_id},
		success: function( data ) {
			if (data.error==1){
				alert(data.msg);
			}else{
				
			}
		}
	});	
	return false;
}

function submitForm1(e, targetobj){
	if (e.keyCode == 13) {
		$(targetobj).trigger('click');
	}
}
/** 		
* On Document Ready
*  
*/
$(document).ready(function() {
	
});