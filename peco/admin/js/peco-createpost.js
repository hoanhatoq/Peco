/*
 * =====================================================================
 * INITIATION SECTION  
 * =====================================================================
*/ 
var articleItemId = 0;
var old_thumbnail_src = "";
$(document).ready(function() {
	getArticle();
	initSortable();
	initTab();
	initDialog();
	handleDialogSearchClick();
	handleDialogSearchPaging();
	
	$("input[name=rdTweetType]").change(function(){
		var val = $(this).val().trim();
		
		if(val == "user") {
			$("#excludeRT").hide();
			$("#lblExcludeRT").hide();
			$("#tweetWordExclude").hide();
		} else {
			$("#excludeRT").show();
			$("#lblExcludeRT").show();
			$("#tweetWordExclude").show();
		}
	});
	
	$("#list_title").bind("keydown keyup keypress change",function(){
		var t = $(this).val().length;
		if (t==0){
			show_validate_message(this, ERR_TITLE_NULL);
		}else
		if (t>50){
			show_validate_message(this, ERR_TITLE_TOO_LONG);
		}else{
			remove_validate_message(this);
		}
	});
	$("#list_description").bind("keydown keyup keypress change",function(){
		var t = $(this).val().length;
		$(".edit_text .count").html(t);
		if (t==0){
			show_validate_message(this, ERR_DESC_NULL);
		}else
		if (t>160){
			show_validate_message(this, ERR_DESC_TOO_LONG);
		}else{
			remove_validate_message(this);
		}
	});
	
	$("#imgTabTabelog").on('click', function(e) { 
		$(this).parent().addClass('selected');
		$("#imgTabGoogle").parent().removeClass('selected');
		$("#imgTabTabelogContent").show();
		$("#imgTabGoogleContent").hide();
		$(".imgSearchHeader").show();
	});
	
	$("#imgTabGoogle").on('click', function(e) { 
		$(this).parent().addClass('selected');
		$("#imgTabTabelog").parent().removeClass('selected');
		$("#imgTabTabelogContent").hide();
		$("#imgTabGoogleContent").show();
		$(".imgSearchHeader").show();
	});
	
	$('#edit_list_thumbnail').load(function(){			 
		resizeCropThumb(this);
	});
	/*$("#btnDraft").click(function(){		
		return doSaveArticle(this, 'draft');
	});
	$("#btnPrivate").click(function(){		
		return doSaveArticle(this, 'private');
	});
	$("#btnSave").click(function(){		
		return doSaveArticle(this, '');
	});
	$("#btnPublish").click(function(){		
		return doSaveArticle(this, 'publish');
	});
	$("#btnPreview").click(function(){		
		return doSaveArticle(this, 'preview');
	});*/
	$("#btnSave1").click(function(){
		var new_status = $("#new_status");
		return doSaveArticle(this, new_status);
	});
	old_thumbnail_src = $("#edit_list_thumbnail").attr('src');
});

function getArticle() {
	$.ajax({	
		type: "POST",
		url: URL_CMS + "/?sub=ajax&act=getarticle",
		async : false,
		data: {
			id: ARTICLE_ID
		},
		success: function( data ) {
			$("#wrap").html(data);
		}
	});
}

/**
 * Do Save Draft
 * 
 */
function doSaveArticle(obj, status){
	var list_title = $("#list_title").val();
	var list_description = $("#list_description").val();
	if (list_title.length==0){
		show_validate_message("#list_title", ERR_TITLE_NULL);
		valid = 0;
	}else
	if (list_title.length>50){
		show_validate_message("#list_title", ERR_TITLE_TOO_LONG);
		valid = 0;
	}
	if (list_description.length==0){
		show_validate_message("#list_description", ERR_DESC_NULL);
		valid = 0;
	}else
	if (list_description.length>160){
		show_validate_message("#list_description", ERR_DESC_TOO_LONG);
		valid = 0;
	}
	if (!valid) return false;
	$(obj).parent().find('.btn').val( $(obj).attr('data-disable-with') );
	$(obj).parent().find('.btn').attr('disabled', true);
	
	var thumbnail_src = $("#edit_list_thumbnail").attr('src');
	if (thumbnail_src==old_thumbnail_src) thumbnail_src = "";
	var udata = "article_id=" + ARTICLE_ID + "&status=" + status;
	udata += "&title=" + list_title + "&detail=" + list_description + "&thumbnail_src=" + thumbnail_src;
	
	$.ajax({	type: "POST",
		url: URL_CMS + "/?sub=ajax&act=savearticle",
		dataType: 'json',
		async : false,
		data: udata,
		success: function( data ) {
			if (data.error==1){
				alert(data.msg);
			}else{
				$("#fCreatePost").submit();
				/*if (status=="preview" || status=="publish" || status==""){
					window.location.href = data.url_redirect;
					return false;
				}else
				if (status=="draft"){
					$.notify("下書き保存しました", { position:"bottom right"});
				}else
				if (status=="private"){
					$.notify("まとめを非公開にしました", { position:"bottom right"});
					setTimeout(function(){ window.location.reload(); }, 1000);
					return false;
				}else{
					window.location.reload();
					return false;
				}
				$(obj).parent().find('.btn').each(function (i) {
					$(this).val( $(this).attr('title') );
				});
				$(obj).parent().find('.btn').attr('disabled', false);*/
			}
		}
	});	
	return false;
}

/**
 * Init Sortable Item
 * 
 */
function initSortable() {
	$( ".sortable" ).sortable({
		items: ".articleContent",
    	handle:'.editItemMove',
    	cursor: "move",  	
		update: function (event, ui) {
    		sortUpdate();
    	}
    });		
}

function sortUpdate() {
	var itemsOrder = $( ".sortable" ).sortable('toArray').toString();
	itemsOrder = itemsOrder.replace(/lastId/g,'');
	itemsOrder = itemsOrder.replace(/itemPos/g,'');
	itemsOrder = itemsOrder.split(",");
	itemsOrder = itemsOrder.filter(Boolean);
	
	console.log(itemsOrder);
	
	$.ajax({	type: "POST",
		url: URL_CMS + "/?sub=ajax&act=updatepriority",
		dataType: 'json',
		async : false,
		data: {'itemsOrder':itemsOrder},
		success: function( data ) {
			if (data.error==1){
				alert(data.msg);
			}else{				
				
			}
		}
	});
};
/**
 * Init Tab
 * 
 */
function initTab() {
	$("#addArea").pecoTab();
	
	$("#videoSearchTab").tabs({
        activate: function(event ,ui){
            var inx = ui.newTab.index();
            
            if(inx == 0) {
            	$(".videoSearchPoweredByView ").attr("src", URL_IMAGES + "/img_poweredbygoogle.png");
            } else if (inx == 1) {
            	$(".videoSearchPoweredByView ").attr("src", URL_IMAGES + "/img_poweredbyyoutube.png");
			}
            	
        }
	});
	//$("#imageSearchTab").tabs();
	onCancel();
}

function onCancel(element) {
	$('#contentArea').find("#editItemId").val("");
	$('#contentArea').find(".newItem").empty();
	$('#contentArea').find(".articleAddHere").show();
}

/**
 * Init Search Dialog
 * 
 */
function initDialog() {
	//Init URL search dialog
	$urlSearchDialog = $( "#urlSearchPopUp" ).dialog({
	      autoOpen: false,
	      draggable: false,
	      minHeight: 0,
	      width: 912,
	      modal: true,
	      position: { my: "center", at: "top+50", of: window },
	      maxHeight: $(window).height(),
	      open: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	   
	    	  $('html').width($('body').width());
	    	  $('html').css('overflow-y','hidden');
	      },
	      beforeClose: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	    	
	    	  $('html').removeAttr('style')
	      }
	    });
	
	$('#btnDialogClose').click(function () {
		$urlSearchDialog.dialog('close');
		$('.urlSearchList').empty();
		$(".urlSearchBody").hide();
		$("#urlKeyword").val("")
		$("#urlKeywordQ").val("")
		$(".urlSearchCountInner").text(0);
	 });
	
	//Init twitter search dialog
	$twitterSearchDialog = $( "#twitterSearchPopUp" ).dialog({
	      autoOpen: false,
	      draggable: false,
	      minHeight: 0,
	      width: 912,
	      modal: true,
	      position: { my: "center", at: "top+100", of: window },
	      maxHeight: $(window).height(),
	      open: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	   
	    	  $('html').width($('body').width());
	    	  $('html').css('overflow-y','hidden');
	      },
	      beforeClose: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	    	
	    	  $('html').removeAttr('style')
	      }
	    });
	
	$('#btnTwitterClose').click(function () {
		$twitterSearchDialog.dialog('close');
		$('.tweetSearchList').empty();
		$(".tweetSearchBody").hide();
		$("#tweetKeyword").val("")
		$("#tweetKeywordQ").val("")
		$(".tweetSearchCountInner").text(0);
	 });
	
	//Init image search dialog
	$imageSearchDialog = $( "#thumbSearchPopUp" ).dialog({
	      autoOpen: false,
	      draggable: false,
	      minHeight: 0,
	      width: 912,
	      modal: true,
	      position: { my: "center", at: "top+50", of: window },
	      open: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	   
	    	  $('html').width($('body').width());
	    	  $('html').css('overflow-y','hidden');
	      },
	      beforeClose: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	    	
	    	  $('html').removeAttr('style')
	      }
	    });
	//$imageSearchDialog.dialog("open");
	$('#btnImageClose').click(function () {
		$imageSearchDialog.dialog('close');
		$('.imageSearchBody').hide();
		$('#thumbSearchList').empty();
		$("#thumbKeyword").val("")
		$("#thumbKeywordQ").val("")
		$(".imageSearchCountInner").text(0);
	 });
	
	//Init video search dialog
	$videoSearchDialog = $( "#videoSearchPopUp" ).dialog({
	      autoOpen: false,
	      draggable: false,
	      minHeight: 0,
	      width: 912,
	      modal: true,
	      position: { my: "center", at: "top+50", of: window },
	      maxHeight: $(window).height(),
	      open: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	   
	    	  $('html').width($('body').width());
	    	  $('html').css('overflow-y','hidden');
	      },
	      beforeClose: function(event, ui) {	    	  
    		  //$(event.target).parent().css("position","fixed");	    	
	    	  $('html').removeAttr('style')
	      }
	    });

	$('#btnVideoClose').click(function () {
		$videoSearchDialog.dialog('close');
		$('#googleList').empty();
		$('#youtubeList').empty();
		$("#videoSearchTab").hide();
		$("#videoKeyword").val("");
		$("#videoKeywordQ").val("")
		$(".videoSearchCountInner").text(0);
	 });
	
	var wHeight = $(window).height()-20;
	$imgSearchDialog = $( "#imgSearchPopUp" ).dialog({
	      autoOpen: false,
	      draggable: false,
	      resizable: false,
	      minHeight: 0,	    
	      height: wHeight,
	      width: 912,
	      modal: true,
	      
	      
	      open: function(event, ui) {	    	  
	    	  $('html').width($('body').width());
	    	  $('html').css('overflow-y','hidden');
	    	  $(this).parent().removeClass("ui-corner-all");
	      },
	      beforeClose: function(event, ui) {	    	  
	    	  $('html').removeAttr('style')
	      }
	    });
	//$imgSearchDialog.dialog("open");
	$('#btnImgClose').click(function () {
		$imgSearchDialog.dialog('close');
		$('.imageSearchList').empty();
		$(".imgSearchResult").hide();
		$(".imgSearchHeader").hide();
		$("#imageKeyword").val("")
		$("#imageKeywordQ").val("")
		$(".imageSearchCountInner").text(0);
		$("#imgTabGoogle").parent().removeClass('selected');
		$("#imgTabTabelog").parent().removeClass('selected');
	 });
	
	//hide dialog title bar
	$(".ui-dialog-content").css("padding", 0);
	$(".ui-dialog-titlebar").hide();
	$(".ui-dialog").css('padding','0px');
	
}

/**
 * Handle Dialog Button Search Click 
 * 
 */
function handleDialogSearchClick() {
	$('#btnUrlSearch').click(function () {
		onBtnUrlSearchClick();
	 });
	
	$('#btnTweetSearch').click(function () {
		onBtnTweetSearchClick();
	 });
	
	$('#btnImgSearch').click(function () {
		onBtnGImageSearchClick();
	 });
	
	$('#btnThumbSearch').click(function () {
		onBtnThumbSearchClick();
	 });
	
	$('#btnVideoSearch').click(function () {
		onSearchVideoBtnClick()
	});
}

/**
 * Handle Dialog Button View More Click 
 * 
 */
function handleDialogSearchPaging() {
	$('#urlMore').click(function () {
		var start = $("#urlPage").val().trim();
		var q = $("#urlKeywordQ").val().trim();
		$("#urlMore").hide();
		$("#urlMoreLoading").show();
		start = parseInt(start) + 10;
		doSearchURL(start, q);
	});
	
	$('#tweetMore').click(function () {
		var param = $("#tweetPage").val().trim();
		var q = $("#tweetKeywordQ").val().trim();
		$("#tweetMore").hide();
		$("#tweetMoreLoading").show();

		var type = $('input[name=rdTweetType]:checked').val();
		if(type == "keyword") {
			doSearchTweet(param);
		} else if (type == "user") {
			var param = "?screen_name="+q+"&max_id="+param;
			param = encodeURIComponent(param);
			doSearchUserTimeline(param);
		}
	});
	
	$('#youtuMore').click(function () {
		var token = $("#youtuPageToken").val().trim();
		var q = $("#videoKeywordQ").val().trim();
		$("#youtuMore").hide();
		$("#youtuMoreLoading").show();
		doSearchYoutubeVideo(token, q);
	});
	
	$('#googMore').click(function () { 
		var start = $("#googPage").val().trim();
		var q = $("#videoKeywordQ").val().trim();
		$("#googMore").hide();
		$("#googMoreLoading").show();
		start = parseInt(start) + 10;
		doSearchGoogleVideo(start, q);
	});
	
	$('#imgGoogMore').click(function () {
		$("#imgGoogMore").hide();
		$("#imgGoogMoreLoading").show();
		
		var start = $("#imgPage").val().trim();
		var q = $("#imageKeywordQ").val().trim();
		
		start = parseInt(start) + 10;
		doSearchGoogleImages(q, start, "image");
		
	});
	
	$('#imgTabelogMore').click(function () {
		$("#imgTabelogMore").hide();
		$("#imgTabelogMoreLoading").show();
		
		var start = $("#imgTabelogPage").val().trim();
		var q = $("#imageKeywordQ").val().trim();
		
		start = parseInt(start) + 10;
		doSearchTabelogImages(q, start, "image");
	});
	
	$('#thumbMore').click(function () {
		$("#thumbMore").hide();
		$("#thumbMoreLoading").show();
		
		var start = $("#thumbPage").val().trim();
		var q = $("#thumbKeywordQ").val().trim();
		
		start = parseInt(start) + 10;
		doSearchGoogleImages(q, start, "thumb");
		
	});
}

/**
 * Handle Article Item Move Event
 * 
 */
function onItemMove(element, position) {

	var parent = getParent(element);
	var itemId = "#"+parent.attr("id");
	
	if(position == 'itemUp') {

		$(itemId).insertBefore($(itemId).prev());


	} else if (position == 'itemTop') {

		$(itemId).insertBefore($('#contentItems').children('.articleContent').first());


	} else if (position == 'itemDown') {

		$(itemId).insertAfter(jQuery(itemId).next());


	} else if (position == 'itemBottom') {

		$(itemId).insertAfter($('#contentItems').children('.articleContent').last());


	}
	sortUpdate();
}

function onOpenSearchPopUp() {
	$urlSearchDialog.dialog( "open" );
	$(".ui-dialog-titlebar").hide();
}

function onOpenSearchTwitterPopUp() {
	$twitterSearchDialog.dialog( "open" );
	$(".ui-dialog-titlebar").hide();
}

function onOpenImageSearchPopUp() {
	$("#imgPopType").val("image");
	$imgSearchDialog.dialog( "open" );
	$(".ui-dialog-titlebar").hide();
}

function onOpenThumbSearchPopUp() {
	$imageSearchDialog.dialog( "open" );
	$(".ui-dialog-titlebar").hide();
}

function onOpenVideoSearchPopUp() {
	$videoSearchDialog.dialog( "open" );
	$(".ui-dialog-titlebar").hide();
}

function saveItem(udata){
	$curItemId = $("#contentArea").find("#editItemId").val();

	if($curItemId==0 || !$curItemId.length) {
	}else
	if($curItemId!="" && $curItemId!=null){
		udata += "&curItemId=" + $curItemId.replace('item', '');
	}	
	$.ajax({	type: "POST",
		url: URL_CMS + "/?sub=ajax&act=saveitem",
		dataType: 'json',
		async : false,
		data: udata,
		success: function( data ) { 
			if (data.error==1){
				alert(data.msg);
			}else{				
				articleItemId =  "item"+data.itemId;				
			}
		}
	});
}
function deleteItem(id){
	var udata = "itemId=" + id.replace('item', '');
	$.ajax({	type: "POST",
		url: URL_CMS + "/?sub=ajax&act=deleteitem",
		dataType: 'json',
		async : false,
		data: udata,
		success: function( data ) {
			if (data.error==1){
				alert(data.msg);
			}else{				
				
			}
		}
	});
}
/*
 * =====================================================================
 * HEADING TAB EVENT  
 * =====================================================================
*/ 
/**
 * Process Add or Edit Article Heading Item
 * 
 */
function onAddHeadingItem() {
	$type = $( "#headingType" ).val();
	$headingText1  = $("#headingContent").val().trim(); 
	$headingText  = htmlspecialchars($headingText1);
	$headingColor = $("#headingColor").val().trim();
	if(!$headingText.length){
		show_validate_message("#headingContent", ERR_HEADING_NULL)
		return;
	}
	
	//$itemId = getItemId();	
	
	if($type==1) {
		//Begin Save Content
		var udata = "ctype=0&article_id=" + ARTICLE_ID;//Heading
		udata += "&headingText=" + $headingText1 + "&headingColor=" + $headingColor;
		saveItem(udata);
		//End Save Content

		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_heading", function (data) {	
			$heading = data.replace("[articleHeading]", $headingText);
			$heading = $heading.replace("[articleColor]", $headingColor);	
			
			addArticleHeading(articleItemId, $heading);
	    });
	} else if ($type==2) {
		//Begin Save Content
		var udata = "ctype=0&article_id=" + ARTICLE_ID;//Heading
		udata += "&subHeadingText=" + $headingText + "&headingColor=" + $headingColor;
		
		saveItem(udata);
		//End Save Content

		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_subheading", function (data) {		
			$heading = data.replace("[articleSubHeading]", $headingText);
			$heading = $heading.replace("[articleColor]", $headingColor);	
			
			addArticleHeading(articleItemId, $heading);
	    });
	}
}

/**
 * Add Heading Item to Article
 * 
 */
function addArticleHeading($itemId, $heading) {	
	$curItemId = $("#contentArea").find("#editItemId").val();

	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {		
		data = data.replace("[articleText]", $heading);		
		data = data.replace("[itemEditFunc]", "onEditHeading(this)");
		
		if($curItemId==0 || !$curItemId.length) {
			data = data.replace("[articleItemId]", $itemId);
			setHtml(data);
		} else {
			data = data.replace("[articleItemId]", $curItemId);
			$("#"+$curItemId).replaceWith(data);			
		}		
		$('#contentArea').find("#addItemTab").html("");
		sortUpdate();
    });	
}



/**
 * Show Tab and Fill Info To Edit Article Heading Item
 * 
 */
function onEditHeading(element) {
	$isSub = false;
	var parent = getParent(element);
	
	$element = parent.find("#articleHeading");
	$text = $element.text().trim();
	$color = $element.css("border-bottom-color");
	
	if($element.length==0) { 
		$element = parent.find("#articleSubHeading");	
		$text = $element.text().trim();
		$color = $element.find("span").css("color");
			
		$span = $element.find("span").text();
		$text = $text.replace($span, "");
		$isSub = true;
	} 	
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_heading", function (data) {				
		$( "#contentArea").find("#addItemTab").html(data);
		initHeadingMenu();		
		
		$('#addItemTab').find("#headingContent").val($text);	
		$('#addItemTab').find("#headingColor").val(rgb2hex($color));
		
		if($isSub) {			
			$('#addItemTab').find("#colorSquare").show();
			$('#addItemTab').find("#colorSquare").css("color", $color);
			$('#addItemTab').find("#headingContent").css('border-bottom', "1px solid #DDD");
			changeHeadingType(2);
		} else {
			$('#addItemTab').find("#headingContent").css('border-bottom', "2px solid "+$color);			
			$('#addItemTab').find("#colorSquare").hide();
			changeHeadingType(1);
		}
	});
	
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}

/*
 * =====================================================================
 * TEXT TAB EVENT  
 * =====================================================================
*/ 

/**
 * Process Add or Edit Article Text Item
 * 
 */
function onAddTextItem() {	
	$type  = $( "#textStyleType" ).val();
	$text  = $("#textContent").val().trim();
	$text  = htmlspecialchars($text);
	if(!$text.length){
		show_validate_message("#textContent", ERR_TEXT_NULL);
		return;
	}
	
	//$itemId = getItemId();
	$curItemId = $("#contentArea").find("#editItemId").val();
	$style = getFontStyle($type);
	
	//Begin Save Content
	var udata = "ctype=1&article_id=" + ARTICLE_ID;//Heading
	udata += "&articleText=" + $text + "&fontStyle=" + $style;
	saveItem(udata);
	//End Save Content

	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_text", function (data) {		
		
		$textVal = data.replace("[articleText]", nl2br($text));
		$textVal = $textVal.replace("[fontStyle]", $style);
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {		
			data = data.replace("[articleText]", $textVal);		
			data = data.replace("[itemEditFunc]", "onEditText(this)");
			data = data.replace("[style]", $type);		
			
			if($curItemId==0 || !$curItemId.length) {
				data = data.replace("[articleItemId]", articleItemId);
				setHtml(data);
			} else {
				data = data.replace("[articleItemId]", $curItemId);
				$("#"+$curItemId).replaceWith(data);
			}
			$('#contentArea').find("#addItemTab").html("");
			sortUpdate();
	    });	
    });
}

/**
 * Get Font Size CSS of Text Item 
 * 
 */
function getFontStyle($type) {	
	$style = "";
	switch (parseInt($type)) {
		case 1:
			$style = "font-size:13px;";
			break;
		case 2:
			$style = "font-size:14px;";
			break;
				
		case 3:
			$style = "font-size:16px;";
			break;
			
		case 4:
			$style = "font-size:14px; font-weight:bold;";
			break;
			
		case 5:
			$style = "font-size:16px; font-weight:bold;";
			break;
		default:
			$style = "font-size:14px;";
			break;
	}
	
	return $style;
}

/**
 * Show Tab and Fill Info To Edit Article Text Item
 * 
 */
function onEditText(element) {
	var parent = getParent(element);
	
	$element = parent.find("#articleText");
	$text = $element.html().trim(); 
	$text = br2nl($text);
	$style = parent.find("#styleType").val();
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_text", function (data) {				
		$('#contentArea').find("#addItemTab").html(data);
		initTextMenu();
		
		$('#addItemTab').find("#textContent").val($text);		
		changeStyleType($style);
	});
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}

function changeHeadingType($val) {
	$( "#headingType" ).val(parseInt($val));
	$( "#headingType" ).selectmenu("refresh");
}

function changeStyleType($val) {
	$( "#textStyleType" ).val(parseInt($val));
	$( "#textStyleType" ).selectmenu("refresh");
}

/*
 * =====================================================================
 * URL TAB EVENT  
 * =====================================================================
*/ 

/**
 * Check URL Info Before Adding To Article
 * 
 */
function onCheckURLItem(element) {
	$url  = $("#urlContent").val().trim();	
	if(!$url.length) return;
	
    // if user has not entered http:// https:// or ftp:// assume they mean http://
    if(!/^(https?|ftp):\/\//i.test($url)) {
    	$url = 'http://'+$url; // set both the value
    	$("#urlContent").val($url); // also update the form element
    }
    
	$isValid = checkValidURL($url);
	if(!$isValid) {
		alert("URLの入力形式が異なっています。");
		return;
	}

	$('#itemLoader').show();
	$(element).attr("disabled", "disabled");
	$(element).val("処理中...");
	
	$.ajax({                         
	    type: "GET",
	    url: URL_CMS + "/?sub=ajax&act=parser",
	    data: {        	
	    	url: $url
	    },        
	    
	    beforeSend: function() {  			    	
	    	
	    },
	    complete: function(){        	                              
	        
	    },
	    success:function(result) { 
	    	var data = $.parseJSON(result);	
	    	if(data.error==1) {
	    		alert(data.msg);
	    	} else {
	    		fillURLInfo(data.msg);
	    	}
	    	$('#itemLoader').hide();
	    },
	    error: function(jqXHR, error, errorThrown) {  
	    	alert("Error");
	   }
	});
}

function checkValidURL(val) {
    // now check if valid url
    // http://docs.jquery.com/Plugins/Validation/Methods/url
    // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(val);
}

function fillURLInfo(info) {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_url", function (data) {				
		displayCheckTab(data);
		
		$title = info["title"];
    	$desc  = info["description"];
    	$url   = info["url"];
    	$totalImg   = info["totalImg"];
    	$images = info["images"];
    	
    	if(parseInt($totalImg)==0) {
    		$curImg = 0;
    	} else {
    		$curImg = 1;
    	}
    	
    	$listImg = "<ul>";
    	$.each( $images, function( key, value ) {
    		$listImg += "<li>" + "<img style='max-width: 150px;' src="+value+">" + "</li>";
    	});
    	$listImg += "</ul>";
    	
    	$("#imgList").val(JSON.stringify($images));
    	
    	$("#siteTitle").val($title);
    	$("#siteDesc").val($desc);
    	$("#siteURL").text($url);
    	$("#siteURL").attr("href", $url);
    	$("#curImg").text($curImg);
    	$("#totalImg").text($totalImg);
    	$("#slider").html($listImg);
    	
    	$("#slider").pecoSlider();
	});
}

function onAddRetURLClick(element) {
	$(element).hide();
	$("#divThumbURL").show();
}

/**
 * Add URL Item To Article
 * 
 */
function onAddURLClick(element) {
	var siteTitle   = $( "#siteTitle" ).val().trim();
	var siteLink    = $( "#siteURL" ).text().trim();
	var siteDesc    = $( "#siteDesc" ).val().trim();
	//var itemId      = getItemId();
	if(!siteTitle.length || !siteDesc.length) return;
	
	var siteComment = $( "#siteComment" ).val().trim();
	var curItemId   = $("#contentArea").find("#editItemId").val();
	var imgList     = $("#imgList").val().trim(); 
	var imgPos      = $("#curImg").text().trim(); 
	
	if ($("input#noImg").is(":checked")) { 
		var thumb = "";
	} else {
		var thumb = $('#slider ul li:first-child').next().find("img").attr("src");
	}
	//Begin Save Content
	var udata = "ctype=4&article_id=" + ARTICLE_ID;//URL
	udata += "&siteTitleTarget=" + siteLink + "&siteTitle=" + siteTitle + "&siteLinkTarget=" + siteLink + "&siteLink=" + siteLink;
	udata += "&siteDesc=" + siteDesc + "&siteThumb=" + thumb + "&siteThumbTarget=" + siteLink + "&siteComment=" + siteComment + "&imgPos=" + imgPos + "&siteImgs=" + encodeURIComponent(imgList);
	saveItem(udata);
	//End Save Content
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_url", function (data) {	
		var articleURL = data.replace("[siteTitleTarget]", siteLink);	
		articleURL = articleURL.replace("[siteTitle]", siteTitle);
		articleURL = articleURL.replace("[siteLinkTarget]", siteLink);
		articleURL = articleURL.replace("[siteLink]", siteLink);
		articleURL = articleURL.replace("[siteDesc]", siteDesc);
		articleURL = articleURL.replace("[siteThumb]", thumb);
		articleURL = articleURL.replace("[siteThumbTarget]", siteLink);
		articleURL = articleURL.replace("[siteComment]", nl2br(siteComment));

		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			var article = data.replace("[articleText]", articleURL);	
			article = article.replace("[itemEditFunc]", "onEditURLInfo(this)");
			
			if(curItemId==0 || !curItemId.length) {
				article = article.replace("[articleItemId]", articleItemId);
				setHtml(article);
				$("#contentItems").find("#"+articleItemId).find("#siteImgs").val(imgList);
				$("#contentItems").find("#"+articleItemId).find("#imgPos").val(imgPos);
				
				if(thumb == "")
					$("#contentItems").find("#"+articleItemId).find(".articleURLItemThumbView").hide();
			} else {
				article = article.replace("[articleItemId]", curItemId);
				$("#"+curItemId).replaceWith(article);
				$("#"+curItemId).find("#siteImgs").val(imgList);
				$("#"+curItemId).find("#imgPos").val(imgPos);
				
				if(thumb == "")
					$("#"+curItemId).find(".articleURLItemThumbView").hide();
			}	
			sortUpdate();
		});
		
	});
	
	$('#contentArea').find("#addItemTab").html("");
}

/**
 * Handle Search URL by Keyword Event
 * 
 */
function onBtnUrlSearchClick() {
	var _q = $("#urlKeyword").val().trim();
	
	if(!_q.length) {
    	alert("検索するキーワードを入力してください。");
    	return;
    }
	
	$("#urlKeywordQ").val(_q);
	$('.urlSearchList').empty();
	
	doSearchURL(1, _q);
}

function doSearchURL(start, q) {
    $.ajax({
        url     : $._urlGSearch,
        type    : 'GET',
        dataType : 'jsonp',
        data :{
            key : $._key,
            cx  : $._cx,
            q   : q,
            start: start,
            num: $._num
        },
        success     : function(data, textStatus, jqXHR){ 	
        	responseHandler(data); 
        	$("#urlPage").val(start);
        	$("#urlMore").show();
    		$("#urlMoreLoading").hide();
        },
        error       : function(jqXHR, textStatus, errorThrown){ console.log('error: %s'), errorThrown},
        beforeSend  : function(){ 
        	console.log('sending request');
        	$(".urlSearchBody").show();
        },
        crossDomain : true
    });
}

function responseHandler( response) {
    
    var len = response.items.length;
    var content = $('.urlSearchList');
    
    $.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=item_url_search", function (data) {	
    
    	for (var i = 0; i < len; i++) {
            var item = response.items[i]; 
            
            var html = data.replace("[siteURL]", item.link);		
            html = html.replace("[siteURL]", item.link);		
            html = html.replace("[siteURL]", item.link);		
            html = html.replace("[siteTitle]", item.htmlTitle);		
            html = html.replace("[siteDesc]", item.htmlSnippet);		
        	
        	content.append(html);
        }
	});
}

/**
 * Add URL Item from Search Result to Article
 * 
 */
function onBtnAddUrlClick(element) {
	var total = $(".urlSearchCountInner").text();
	total = parseInt(total);
	
	$(".urlSearchCountInner").text(total+1);
	$('#contentArea').find("#addItemTab").empty();
	$(element).attr("disabled", "disabled");
	var parent = $(element).closest("li");
	
	var siteTitle = parent.find(".urlSearchItemTitle").text().trim();
	var siteLink   = parent.find(".urlSearchLink").attr("href").trim();
	var siteDesc  = parent.find(".urlSearchItemDesc").text().trim();
	var siteComment = "";
	var thumb = "";
	//var itemId = getItemId();

	//Begin Save Content
	var udata = "ctype=4&article_id=" + ARTICLE_ID;//URL
	udata += "&siteTitleTarget=" + siteLink + "&siteTitle=" + siteTitle + "&siteLinkTarget=" + siteLink + "&siteLink=" + siteLink;
	udata += "&siteDesc=" + siteDesc + "&siteThumb=" + thumb + "&siteThumbTarget=" + siteLink + "&siteComment=" + siteComment;
	saveItem(udata);
	//End Save Content

	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_url", function (data) {	
		var articleURL = data.replace("[siteTitleTarget]", siteLink);	
		articleURL = articleURL.replace("[siteTitle]", siteTitle);
		articleURL = articleURL.replace("[siteLinkTarget]", siteLink);
		articleURL = articleURL.replace("[siteLink]", siteLink);
		articleURL = articleURL.replace("[siteDesc]", siteDesc);
		articleURL = articleURL.replace("[siteThumb]", thumb);
		articleURL = articleURL.replace("[siteThumbTarget]", siteLink);
		articleURL = articleURL.replace("[siteComment]", siteComment);
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			var article = data.replace("[articleText]", articleURL);	
			article = article.replace("[articleItemId]", articleItemId);	
			article = article.replace("[itemEditFunc]", "onEditURLInfo(this)");
			
			setHtml(article);
			$("#contentItems").find("#"+articleItemId).find(".articleURLItemThumbView").hide();
			$("#contentItems").find("#"+articleItemId).find(".articleURLItemCommentView").hide();
			
			sortUpdate();
		});
	});
}

/**
 * Open URL Tab to Edit Info
 * 
 */
function onEditURLInfo(element) {
	var parent = getParent(element);

	var siteTitle   = parent.find(".articleURLItemTitleLink").text().trim();
	var siteLink    = parent.find(".articleURLItemUrlLink").attr("href").trim();
	var siteDesc    = parent.find(".articleURLItemDescView").text().trim();
	var siteComment = parent.find(".articleURLItemCommentView").html().trim();
	var thumb       = parent.find(".articleURLItemCommentView").text().trim();
	var siteImgs    = parent.find("#siteImgs").val(); 
	var imgPos      = parent.find("#imgPos").val().trim(); 
	if(!imgPos.length) imgPos = 0;
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_url", function (data) {				
		$('#contentArea').find("#addItemTab").html(data);
		
		var total = 0;
		
		if(siteImgs.length > 0) {
			var images      = $.parseJSON(siteImgs);
			var listImg = "<ul>";
	    	$.each( images, function( key, value ) {
	    		listImg += "<li>" + "<img width='150' height='90' src="+value+">" + "</li>";
	    		total ++;
	    	});
	    	listImg += "</ul>";
			
			$("#slider").html(listImg);
	    	$("#slider").pecoSlider();
	    	moveToPos(parseInt(imgPos)-1);

			
		} else {
			getImagesFromUrl(siteLink);
		}
    	
    	$("#siteTitle").val(siteTitle);
    	$("#siteDesc").val(siteDesc);
    	$("#siteURL").text(siteLink);
    	$("#siteURL").attr("href", siteLink);
    	$("#siteComment").val(br2nl(siteComment));
    	$("#curImg").text(imgPos);
    	$("#totalImg").text(total);
    	$("#imgList").val(siteImgs);
    	
    	if($(".articleURLItemThumbView").css('display') == 'none') {
    		$( "#noImg" ).prop( "checked", true );
    		$("#slider").hide();
        	$("#divNoImg").show();
    	}
	});
	
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}
function getImagesFromUrl(url) {
	$.ajax({                         
	    type: "GET",
	    url: URL_CMS + "/?sub=ajax&act=parser",
	    data: {        	
	    	url: url
	    },        
	    
	    beforeSend: function() {  			    	
	    	
	    },
	    complete: function(){        	                              
	        
	    },
	    success:function(result) { 
	    	var data = $.parseJSON(result);
	    	if(data.error==1) {
	    		alert(data.msg);
	    	} else {
	    		setImgList(data.msg);
	    	}
	    },
	    error: function(jqXHR, error, errorThrown) {  
	    	alert("Error");
	   }
	});
}

function setImgList(info) {
	$totalImg   = info["totalImg"];
	$images = info["images"];
	
	$listImg = "<ul>";
	$.each( $images, function( key, value ) {
		$listImg += "<li>" + "<img width='150' height='90' src="+value+">" + "</li>";
	});
	$listImg += "</ul>";
	
	$("#imgList").val(JSON.stringify($images));
	
	$("#curImg").text(1);
	$("#totalImg").text($totalImg);
	$("#slider").html($listImg);
	$("#slider").pecoSlider();
}

/*
 * =====================================================================
 * TWITTER TAB EVENT  
 * =====================================================================
*/ 

/**
 * Check Twitter Status Before Adding To Article
 * 
 */
function onCheckTwitterItem(element) {
	var url  = $("#twitterLink").val().trim();	
	if(!url.length) return;
	
	// if user has not entered http:// https:// or ftp:// assume they mean http://
    if(!/^(https?|ftp):\/\//i.test(url)) {
    	url = 'http://'+url; // set both the value
    	$("#urlContent").val(url); // also update the form element
    }
    
	$isValid = checkValidURL(url);
	if(!$isValid) {
		alert("URLの入力形式が異なっています。");
		return;
	}

	if(url.indexOf('/status/') == -1) {
		alert("エラーが発生しました。しばらく経ってからもう一度お試しください。");
		return;
	} 
	
	$('#itemLoader').show();
	$(element).attr("disabled", "disabled");
	$(element).val("処理中...");
	
	$.ajax({                         
	    type: "GET",
	    url: URL_CMS + "/?sub=ajax&act=twitter",
	    data: {        	
	    	statusUrl: url,
	    	action: "search_tweet"
	    },        
	    
	    beforeSend: function() {  			    	
	    	
	    },
	    complete: function(){        	                              
	        
	    },
	    success:function(result) { 
	    	var data = $.parseJSON(result);	

	    	openTwitterCheckTab(data);
	    	$('#itemLoader').hide();
	    },
	    error: function(jqXHR, error, errorThrown) {  
	    	alert("Error");
	   }
	});
}

/**
 * Open Twitter Tab to Check Info
 * 
 */
function openTwitterCheckTab(info) {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_twitter", function (data) {				
		displayCheckTab(data);
    	var name  = info["name"];
    	var screenName   = info["screen_name"];
    	var avatar = info["avatar"];
    	var mediaUrl   = info["media_url"];
		var mediaTarget   = info["media_target"];
    	var text   = info["text"];
    	var time   = info["time"];
    	
    	$(".itemTwitterUserThumb01Img").attr("src", avatar);
    	$(".itemTwitterUserName01FullName").text(screenName);
    	$(".itemTwitterUserName01ScreenName").text(name);
    	$(".itemTweetTimeView").text(time);
    	$(".itemTweet01View").html(text);
    	$("#itemTweet01ImageView").attr("src", mediaUrl);
    	$("#itemTweet01ImageTarget").attr("href", mediaTarget);
    	
    	if(mediaUrl=="undefined" || !mediaUrl.length || mediaUrl=="") {
    		$(".itemTweet01Image").hide();
    	}
			
	});
}

/**
 * Add Twitter Item to Article
 * 
 */
function onAddTwitterClick(element) { 
	var avatar    = $( ".itemTwitterUserThumb01Img" ).attr("src");
	var fullname  = $( ".itemTwitterUserName01FullName" ).text().trim();
	var username  = $( ".itemTwitterUserName01ScreenName" ).text().trim();
	var content   = $( ".itemTweet01View" ).html().trim();
	var media     = $( "#itemTweet01ImageView" ).attr("src");
	var mediaTarget   = $( "#itemTweet01ImageTarget" ).attr("href");
	var comment   = $( ".itemComment01Inputbox" ).val().trim();
	var time      = $( ".itemTweetTimeView" ).text().trim();
	//var itemId    = getItemId();

	var curItemId   = $("#contentArea").find("#editItemId").val();

	//Begin Save Content
	var udata = "ctype=5&article_id=" + ARTICLE_ID;//Twitter
	udata += "&avatar=" + avatar + "&fullname=" + fullname + "&username=" + username + "&content=" + content;
	udata += "&comment=" + comment + "&time=" + time + "&imgTarget=" + mediaTarget + "&imgSrc=" + media;
	saveItem(udata);
	//End Save Content
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_twitter", function (data) {	
		var articleTwitter = data.replace("[avatar]", avatar);	
		articleTwitter = articleTwitter.replace("[fullname]", fullname);
		articleTwitter = articleTwitter.replace("[username]", username);
		articleTwitter = articleTwitter.replace("[content]", content);
		articleTwitter = articleTwitter.replace("[comment]", comment);
		articleTwitter = articleTwitter.replace("[imgSrc]", media);
		articleTwitter = articleTwitter.replace("[imgTarget]", mediaTarget);
		articleTwitter = articleTwitter.replace("[time]", time);

		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			var article = data.replace("[articleText]", articleTwitter);	
			article = article.replace("[itemEditFunc]", "onEditTwitter(this)");

			
			if(curItemId==0 || !curItemId.length) {
				article = article.replace("[articleItemId]", articleItemId);

				

				if(typeof media==="undefined" || !media.length) {
					//$("#contentItems").find("#"+itemId).find(".itemTweet01Image").hide();
					article = article.replace("itemTweet01Image", 'itemTweet01Image" style="display:none"');
				}
				
				if(typeof comment=="undefined"  || !comment.length){
					//$("#contentItems").find("#"+itemId).find(".articleTwitterCommentView").hide();
					article = article.replace("articleTwitterCommentView", 'articleTwitterCommentView" style="display:none"');
				}
				
				setHtml(article);
			} else {
				article = article.replace("[articleItemId]", curItemId);

				
				if(typeof media=="undefined" || !media.length) {
					$(article).find(".itemTweet01Image").remove();
					//article = article.replace("itemTweet01Image", 'itemTweet01Image" style="display:none"');
				}
				if(typeof comment=="undefined"  || !comment.length){

					article = article.replace("articleTwitterCommentView", 'articleTwitterCommentView" style="display:none"');
				}
				$("#"+curItemId).replaceWith(article);
			}		
			sortUpdate();
		});
		
	});

	$('#contentArea').find("#addItemTab").html("");
}

/**
 * Open Twitter Tab and Fill Data to Edit
 * 
 */
function onEditTwitter(element) {
	var parent = getParent(element);
	
	var avatar    = parent.find(".articleTwitterUserThumb01Img").attr("src").trim();
	var fullname  = parent.find(".articleTwitterUserName01FullName").text().trim();
	var username  = parent.find(".articleTwitterUserName01ScreenName").text().trim();
	var content   = parent.find(".articleTweet01View").html().trim();
	var time      = parent.find(".articleTweetTimeView").text().trim();
	var comment   = parent.find(".articleTwitterCommentView").text().trim();
	var media     = parent.find( "#itemTweet01ImageView" ).attr("src");
	var mediaTarget  = parent.find( "#itemTweet01ImageTarget" ).attr("href");
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_twitter", function (data) {				
		$('#contentArea').find("#addItemTab").html(data);
		
		$(".itemTwitterUserThumb01Img").attr("src", avatar);
    	$(".itemTwitterUserName01FullName").text(fullname);
    	$(".itemTwitterUserName01ScreenName").text(username);
    	$(".itemTweet01View").html(content);
    	$(".itemComment01Inputbox").val(comment);
		$("#itemTweet01ImageView").attr("src", media);
    	$("#itemTweet01ImageTarget").attr("href", mediaTarget);
    	$(".itemTweetTimeView").text(time);
    	
    	if(!media.length || media == "undefined") {
    		$(".itemTweet01Image").hide();
    	}
    	
	});
	
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}

/**
 * Handle Search Twitter Status by Keyword Event
 * 
 */
function onBtnTweetSearchClick() {
	var _q  = $("#tweetKeyword").val().trim();
	
	if(!_q.length) {
    	alert("検索するキーワードを入力してください。");
    	return;
    }
	
	$('.tweetSearchList').empty();
	$("#tweetKeywordQ").val(_q);
	
	var type = $('input[name=rdTweetType]:checked').val();
	$("#tweetType").val(type);
	if(type == "keyword") {
		var excludeRT = $('#excludeRT').is(':checked');
		if(excludeRT) {
			_q = _q + "-filter:retweets";
		}
		
		var excludeKeyword = $('#tweetExcludeKeyword').val().trim();
		if(excludeKeyword.length > 0) {
			$('#tweetExcludeKeywordQ').val(excludeKeyword);
			
			$.each(excludeKeyword.split(' '), function(index, value) { 
				_q += " -"+value;
			});
		}
		
		var param = "?q="+_q;

		doSearchTweet(param);
	} else if (type == "user") {
		var param = "?screen_name="+_q;
		doSearchUserTimeline(param);
	}
}

function doSearchTweet(param) {
	
	$.ajax({                         
	    type: "GET",
	    url: URL_CMS + "/?sub=ajax&act=twitter",
	    data: {        	
	    	keyword: param,
	    	action: "search_tweet_list"
	    },        
	    
	    beforeSend: function() {  			    	
	    	$(".tweetSearchBody").show();
	    },
	    complete: function(){        	                              
	    	$("#tweetMore").show();
			$("#tweetMoreLoading").hide();
	    },
	    success:function(result) { 
	    	var data = $.parseJSON(result);	

	    	tweetHandler(data);
	    },
	    error: function(jqXHR, error, errorThrown) {  
	    	console.log('error: %s', errorThrown)
	    },
	    crossDomain : true
	});
}


function tweetHandler(response) {
    var len = response.results.length;
    var content = $('.tweetSearchList');
    $("#tweetPage").val(response.metadata.next_results);
    
    $.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=item_tweet_search", function (data) {	
    
    	for (var i = 0; i < len; i++) {
            var item = response.results[i]; 

            var html = data.replace("[name]", item.name);		
            html = html.replace("[screenName]", item.screen_name);		
            html = html.replace("[text]", item.text);		
            html = html.replace("[time]", item.created_at);		
            html = html.replace("[avatar]", item.avatar);		
		
			if(item.media_url) {
            	html = html.replace("[imgTarget]", item.media_target);		
                html = html.replace("[imgSrc]", item.media_url);	
            } else {
            	html = html.replace("[imgTarget]", "");		
                html = html.replace("[imgSrc]", "");
                html = html.replace("tweetSearchItemImg", '" style="display:none"');
            }
        	
        	content.append(html);
        }
	});
}

function doSearchUserTimeline(param) {
	
	$.ajax({                         
	    type: "GET",
	    url: URL_CMS + "/" + "?sub=ajax&act=twitter",
	    data: {        	
	    	keyword: param,
	    	action: "search_user_timeline"
	    },        
	    
	    beforeSend: function() {  			    	
	    	$(".tweetSearchBody").show();
	    },
	    complete: function(){        	                              
	    	$("#tweetMore").show();
			$("#tweetMoreLoading").hide();
	    },
	    success:function(result) { 
	    	var data = $.parseJSON(result);	

	    	tweetHandler(data);
	    },
	    error: function(jqXHR, error, errorThrown) {  
	    	console.log('error: %s', errorThrown)
	    },
	    crossDomain : true
	});
}

/**
 * Add Twitter Item from Search Results to Article
 * 
 */
function onBtnAddTweetClick(element) {
	var total = $(".tweetSearchCountInner").text();
	total = parseInt(total);
	
	$(".tweetSearchCountInner").text(total+1);
	$('#contentArea').find("#addItemTab").empty();
	$(element).attr("disabled", "disabled");
	var parent = $(element).closest("li");
	
	var avatar = parent.find(".tweetSearchItemAvatarView").attr("src").trim();
	var name   = parent.find(".articleTwitterUserName01FullName").text().trim();
	var screenName  = parent.find(".articleTwitterUserName01ScreenName").text().trim();
	var text = parent.find(".tweetSearchItemDesc").html();
	var time = parent.find(".tweetSearchItemURL").text().trim();
	var media     = parent.find( "#tweetSearchItemImgView" ).attr("src");
	var mediaTarget  = parent.find( "#tweetSearchItemImgTarget" ).attr("href");
	
	//var itemId = getItemId();
	var comment = "";

	//Begin Save Content
	var udata = "ctype=5&article_id=" + ARTICLE_ID;//Twitter
	udata += "&avatar=" + avatar + "&fullname=" + name + "&username=" + screenName + "&content=" + text;
	udata += "&comment=" + comment + "&time=" + time + "&imgTarget=" + mediaTarget + "&imgSrc=" + media;;
	saveItem(udata);
	//End Save Content
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_twitter", function (data) {	
		var articleTwitter = data.replace("[avatar]", avatar);	
		articleTwitter = articleTwitter.replace("[fullname]", name);
		articleTwitter = articleTwitter.replace("[username]", screenName);
		articleTwitter = articleTwitter.replace("[content]", text);
		articleTwitter = articleTwitter.replace("[imgSrc]", media);
		articleTwitter = articleTwitter.replace("[imgTarget]", mediaTarget);
		articleTwitter = articleTwitter.replace("[comment]", "");
		articleTwitter = articleTwitter.replace("[time]", time);
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			var article = data.replace("[articleText]", articleTwitter);	
			article = article.replace("[articleItemId]", articleItemId);	
			article = article.replace("[itemEditFunc]", "onEditTwitter(this)");
			
			setHtml(article);
			$("#contentItems").find("#"+articleItemId).find(".articleTwitterCommentView").hide();
			
			if(!media)
				$("#contentItems").find("#"+articleItemId).find(".itemTweet01Image").hide();
			
			sortUpdate();
		});
	});
}

/*
 * =====================================================================
 * IMAGE TAB EVENT  
 * =====================================================================
*/ 

/**
 * Check Image Info Before Adding To Article
 * 
 */
function onCheckImage(element) {
	var url  = $("#imageUrl").val().trim();	
	if(!url.length) return;
	
	var isUpload = $( "#isUpload" ).val().trim(); 
	
	if(isUpload === 'false') {
		// if user has not entered http:// https:// or ftp:// assume they mean http://
	    if(!/^(https?|ftp):\/\//i.test(url)) {
	    	url = 'http://'+url; // set both the value
	    }
	    
		$isValid = checkValidURL(url);
		if(!$isValid) {
			alert("URLの入力形式が異なっています。");
			return;
		}
		
		if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(url)) {
			alert('エラーが発生したため、画像の追加に失敗しました。');
			element.value = "";
			return false;
		}
		
	} else {
		var formData = new FormData($("#frmNewImg")[0]);
		formData.append('article_id', ARTICLE_ID);
		formData.append('fname', "upload");
		formData.append('prefix', "img");
		
		$.ajax({	
			type: "POST",
			url: URL_CMS + "/?sub=ajax&act=uploadimg",
			dataType: 'json',
			async : false,
			data: formData,
		    processData: false,
		    contentType: false,
			success: function( data ) {
				
				if (data.error==1){
					alert(data.msg);
				}else{				
					url = data.msg;
				}
			}
		});
	}
	
	$('#itemLoader').show();
	$(element).attr("disabled", "disabled");
	$(element).val("処理中...");
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_image", function (data) {				
		displayCheckTab(data);
		$(".itemImagePreview").attr("src", url);
		$("#imageUrl").val(url);
		$('#itemLoader').hide();
		
		if(isUpload === 'true') {
			$('#itemImageSource').hide();
			$( "#isUpload" ).val('true');
		}
	});
}

function switchAddImageType(type) {
	if (type==1) { // upload
		$("#imageUrl").hide();
		$("#imageUpload").show();
		
		$(".itemImageUpload").hide();
		$(".itemImageLink").show();
		
		$("#isUpload").val("true");
	} else if (type==2) { // URL
		$("#imageUrl").show();
		$("#imageUpload").hide();
		
		$(".itemImageUpload").show();
		$(".itemImageLink").hide();
		
		$("#isUpload").val("false");
	} 
}

function setPreviewImage(input) {
	if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(input.files[0].name)) {
		alert('URL、または形式（jpg,png,gif）が正しくないか、使用できないサイトの画像である、もしくは商品の価格が記載されておりません。');
		input.value = "";
		return false;
	}
	
	if (input.files[0].size > 10*1024*1024){
		alert("画像のサイズ（10MB以下）");
		input.value = "";
		return false;
	}
	
	 if (input.files && input.files[0]) {
		 var reader = new FileReader();   
		 reader.onload = function (e) {
			 $('.itemImagePreview').attr('src', e.target.result);
			 $("#imageUrl").val(e.target.result);
		 }   
		 reader.readAsDataURL(input.files[0]);
	 }
	return false;
}

function setPreviewThumb(input) {
	if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(input.files[0].name)) {
		alert('URL、または形式（jpg,png,gif）が正しくないか、使用できないサイトの画像である、もしくは商品の価格が記載されておりません。');
		input.value = "";
		return false;
	}
	
	if (input.files[0].size > 10*1024*1024){
		alert("画像のサイズ（10MB以下）");
		input.value = "";
		return false;
	}
	
	 if (input.files && input.files[0]) {		 
		 var reader = new FileReader();   
		 reader.onload = function (e) {			 
			 $('#edit_list_thumbnail').attr('src', e.target.result);
			 $('#edit_list_thumbnail').load(function(){				 
				 resizeCropThumb(this);
			 });
			 $("#imageUrl").val(e.target.result);
		 }   
		 reader.readAsDataURL(input.files[0]);		 
		
	 }
	return false;
}

function setPreviewRemoteImg(element) {
	if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(element.value.trim())) {
		alert('URL、または形式（jpg,png,gif）が正しくないか、使用できないサイトの画像である、もしくは商品の価格が記載されておりません。');
		element.value = "";
		return false;
	}
	
	$(".itemImagePreview").attr("src", element.value.trim());
}

function resizeCropThumb(obj){
	var w = obj.width;
	var h = obj.height;	 
	console.log(w + " "+h);
	if (w<h){		
		$(obj).attr('width', '100%');
		$(obj).attr('height', 'auto');
		var mgtop = (h-160)/2;
		$(obj).attr('style', 'margin-top:-'+mgtop+'px; margin-left:0px');					
	}else{
		var newh = 160, neww = 160*w / h;
		$(obj).attr('width', 'auto');
		$(obj).attr('height', '100%');
		var mgleft = (neww-160)/2;
		$(obj).attr('style', 'margin-top:0px; margin-left:-'+mgleft+'px');					 
	}
}
/**
 * Add Image Item to Article
 * 
 */
function onAddImageItem(element) {
	var title   = $( "#itemImageTitle" ).val().trim();
	var image   = $( "#imageUrl" ).val().trim();
	var source  = $( "#itemImageSource" ).val().trim();
	var desc    = $( "#itemImageComment" ).val().trim();
	
	var isUpload = $( "#isUpload" ).val().trim();
	
	if(isUpload !== 'true' && !source.length) {
		alert("参照元が空です");
		return;
	}
	
	//var itemId      = getItemId();
	var curItemId   = $("#contentArea").find("#editItemId").val();
	
	$('#contentArea').find("#addItemTab").html("");

	//Begin Save Content
	var udata = "ctype=2&article_id=" + ARTICLE_ID;//Image
	udata += "&imageTitle=" + title + "&imageLink=" + image + "&imageSourceTarget=" + source + "&imageSource=" + source;
	udata += "&imageDesc=" + desc + "&articleIsUpload=" + isUpload;
	saveItem(udata);
	//End Save Content
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_image", function (data) {	
		var articleImage = data.replace("[imageTitle]", title);	
		articleImage = articleImage.replace("[imageLink]", image);
		articleImage = articleImage.replace("[imageSourceTarget]", source);
		articleImage = articleImage.replace("[imageSource]", source);
		articleImage = articleImage.replace("[imageDesc]", nl2br(desc));
		articleImage = articleImage.replace("[articleIsUpload]", isUpload);
	
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			var article = data.replace("[articleText]", articleImage);	
			article = article.replace("[itemEditFunc]", "onEditImageItem(this)");
			
			if(curItemId==0 || !curItemId.length) {
				article = article.replace("[articleItemId]", articleItemId);
				setHtml(article);
				if(!source.length)
					$("#contentItems").find("#"+articleItemId).find(".articleImageSource").hide();
			} else {
				article = article.replace("[articleItemId]", curItemId);
				$("#"+curItemId).replaceWith(article);
				if(!source.length)
					$("#"+curItemId).find(".articleImageSource").hide();
				
				if(isUpload === 'false') 
					$( "#itemImageSource" ).hide();
			}
			
			sortUpdate();
		});
	});
}

/**
 * Open Image Tab and Fill Data to Edit
 * 
 */
function onEditImageItem(element) {
	var parent = getParent(element);
	
	var title  = parent.find(".articleImageTitle").text().trim();
	var image  = parent.find(".articleImageView").attr("src").trim();
	var source = parent.find(".articleImageSourceView").text().trim();
	var desc   = parent.find(".articleImageDesc").html().trim();
	desc = br2nl(desc);
	var isUpload = parent.find( "#articleIsUpload" ).val().trim();
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_image", function (data) {				
		$('#contentArea').find("#addItemTab").html(data);
		
		$(".itemImagePreview").attr("src", image);
		$("#imageUrl").val(image);
    	$("#itemImageTitle").val(title);
    	$("#itemImageComment").text(desc);
    	$("#itemImageSource").val(source);
    	$("#isUpload").val(isUpload);
    	$("#imageUpload").hide();
    	$("#btnCheckImage").val("保存");
    	if(isUpload === 'true') 
    		$("#itemImageSource").hide();
	});
	
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}

/**
 * Handle Image Search by Keyword Event
 * 
 */
function onBtnGImageSearchClick() {
	var _q      = $("#imageKeyword").val().trim();
    
    if(!_q.length) {
    	alert("検索するキーワードを入力してください。");
    	return;
    }
    var type = "image";
    
    $('.imageSearchList').empty();
	$("#imageKeywordQ").val(_q);
	
	for (var i = 0; i < 5; i++) {
		var start = i * 10 + 1;
		setTimeout(doSearchGoogleImages(_q, start, type), 200);	
		setTimeout(doSearchTabelogImages(_q, start, type), 200);
	}
}

/**
 * Handle Image Thumb Search by Keyword Event
 * 
 */
function onBtnThumbSearchClick() {
	var _q      = $("#thumbKeyword").val().trim();
    
    if(!_q.length) {
    	alert("検索するキーワードを入力してください。");
    	return;
    }
    var type = "thumb";
    
    $('#thumbSearchList').empty();
	$("#thumbKeywordQ").val(_q);
	
	for (var i = 0; i < 5; i++) {
		var start = i * 10 + 1;
		setTimeout(doSearchGoogleImages(_q, start, type), 200);	
	}
}

function doSearchGoogleImages(q, start, flag) {
    
    $.ajax({
        url     : $._urlGSearch,
        type    : 'GET',
        dataType : 'jsonp',
        data :{
            key : $._key,
            searchType: $._stype,
            cx  : $._cx,
            q   : q,
            start: start,
            num: $._num
        },
        success     : function(data, textStatus, jqXHR){  
        	
        	if(flag=='image') {
        		$("#imgPage").val(start);
        		$(".imageSearchMore").show();
            	$("#imgGoogMore").show();
        		$("#imgGoogMoreLoading").hide();
        		$(".imgSearchResult").show();
        		responseImagesHandler(data, "imgSearchList"); 
        	}        		
        	else if (flag=='thumb') {
        		$("#thumbPage").val(start);
        		$(".thumbSearchMore").show();
            	$("#thumbMore").show();
        		$("#thumbMoreLoading").hide();
        		$(".imageSearchBody").show();
        		responseThumbHandler(data, "thumbSearchList");         		
			}
        },
        error       : function(jqXHR, textStatus, errorThrown){ console.log('error: %s'), errorThrown},
        beforeSend  : function(){ 
        	console.log('sending request');
        	
        },
        crossDomain : true
    });
}

function responseImagesHandler(response, item) {

    var len = response.items.length;
    var content = $('#'+item);
    
    $.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=item_image_search", function (data) {

    	for (var i = 0; i < len; i++) {
            var item = response.items[i]; 
            var html = data.replace("[imageURL]", item.image.thumbnailLink);	
            html = html.replace("[imageLink]", item.link);		
            html = html.replace("[imageSource]", item.displayLink);		
            
        	content.append(html);
        }
	});
}

function responseThumbHandler(response, item) {
    var len = response.items.length;
    var content = $('#'+item);
    
    $.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=item_thumb_search", function (data) {

    	for (var i = 0; i < len; i++) {
            var item = response.items[i]; 
            var html = data.replace("[imageURL]", item.image.thumbnailLink);	
            html = html.replace("[imageLink]", item.link);		
            html = html.replace("[imageSource]", item.displayLink);		
            
        	content.append(html);
        }
	});
}

function doSearchTabelogImages(q, start, flag) {
    q = "site:tabelog.com " + q;
    
    $.ajax({
        url     : $._urlGSearch,
        type    : 'GET',
        dataType : 'jsonp',
        data :{
            key : $._key,
            searchType: $._stype,
            cx  : $._cx,
            q   : q,
            start: start,
            num: $._num
        },
        success     : function(data, textStatus, jqXHR){  
        	$("#imgTabelogPage").val(start);

        	$(".imageSearchMore").show();
        	$("#imgTabelogMore").show();
    		$("#imgTabelogMoreLoading").hide();
    		
    		responseImagesHandler(data, "imageTabelogList"); 
        },
        error       : function(jqXHR, textStatus, errorThrown){ console.log('error: %s'), errorThrown},
        beforeSend  : function(){ 
        	console.log('sending request');
        	$(".imgSearchResult").show();
        },
        crossDomain : true
    });
}

/**
 * Add Image Item from Search Results to Article
 * 
 */
function onBtnImgSearchAdd(element) {
	var total = $(".imageSearchCountInner").text();
	total = parseInt(total);
	
	$(".imageSearchCountInner").text(total+1);
	$('#contentArea').find("#addItemTab").empty();
	$(element).attr("disabled", "disabled");
	
	var parent = $(element).closest("li");
	var title = "";
	var imgSource = parent.find("#imageSearchSource").val().trim();
	var imgLink   = parent.find("#imageSearchLink").val().trim();
	//var itemId = getItemId();
	var desc = "";
	var isUpload = "true";	
	
	//Begin Save Content
	var udata = "ctype=2&article_id=" + ARTICLE_ID;//Image
	udata += "&imageTitle=" + title + "&imageLink=" + imgLink + "&imageSourceTarget=" + imgSource + "&imageSource=" + imgSource;
	udata += "&imageDesc=" + desc + "&articleIsUpload=" + isUpload;
	saveItem(udata);
	//End Save Content
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_image", function (data) {	
		var articleImage = data.replace("[imageTitle]", "");	
		articleImage = articleImage.replace("[imageLink]", imgLink);
		articleImage = articleImage.replace("[imageSourceTarget]", imgSource);
		articleImage = articleImage.replace("[imageSource]", imgSource);
		articleImage = articleImage.replace("[imageDesc]", "");
		articleImage = articleImage.replace("[articleIsUpload]", "true");
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			var article = data.replace("[articleText]", articleImage);	
			article = article.replace("[articleItemId]", articleItemId);	
			article = article.replace("[itemEditFunc]", "onEditImageItem(this)");
			
			setHtml(article);

			$("#contentItems").find(".articleURLItemThumbView").hide();
			$("#contentItems").find(".articleURLItemCommentView").hide();
			
			sortUpdate();
		});
	});
}

/**
 * Set Article Thumb from Search Results
 * 
 */
function onBtnThumbSearchAdd(element) {
	$(element).attr("disabled", "disabled");
	
	var parent 	  = $(element).closest("li");
	var imgLink   = parent.find("#imageSearchLink").val().trim();
	
	$("#edit_list_thumbnail").attr("src", imgLink);
	
	$imageSearchDialog.dialog('close');
	$('.imageSearchList').empty();
	$(".imageSearchTab").hide();
	$("#imageKeyword").val("")
	$(".imageSearchCountInner").text(0);
}

function onSetRemoteThumb() {
	$imgUrl = $("#image_remote_url").val().trim();
	$('#edit_list_thumbnail').load(function(){				 
		resizeCropThumb(this);
	});
	$("#edit_list_thumbnail").attr("src", $imgUrl);
	$("#image_remote_url").val("");
		
}

function switchAddThumbType(type) {
	if (type==1) { // upload
		$("#imgFromURL").hide();
		$("#imgFromLocal").show();
		$("#uploadThumb").hide();
		$("#remoteThumb").show();
	} else if (type==2) { // URL
		$("#imgFromURL").show();
		$("#imgFromLocal").hide();
		$("#uploadThumb").show();
		$("#remoteThumb").hide();
	} 
	return false;
}

/*
 * =====================================================================
 * VIDEO TAB EVENT  
 * =====================================================================
*/ 

/**
 * Check Video Item Before Add to Article
 * 
 */
function onCheckVideoItem(element) {
	var url  = $("#videoUrl").val().trim();	
	if(!url.length) return;
	
	if(!/^(https?|ftp):\/\//i.test(url)) {
    	url = 'http://'+url; // set both the value
    }
    
	$isValid = checkValidURL(url);
	if(!$isValid) {
		alert("URLの入力形式が異なっています。");
		return;
	}
	
	var videoId = getYoutubeIdFromURL(url);
	if(videoId==null) return;
	
	$('#itemLoader').show();
	$(element).attr("disabled", "disabled");
	$(element).val("処理中...");
	
	$.ajax({
        url     : $._urlGVideo,
        type    : 'GET',
        dataType : 'jsonp',
        data :{
            key  : $._key,
            id   : videoId,
            part : $._part
        },
        success     : function(result, textStatus, jqXHR){  
        	var resCount = parseInt(result.pageInfo.totalResults);
        	
        	if(resCount==0) {
        		var resultId = "";
                var resultTitle = "Youtube";
        	} else {
        		var resultId = result.items[0].id;
                var resultTitle = result.items[0].snippet.title;
        	}

	    	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_video", function (data) {				
	    		displayCheckTab(data);		
	    		$("#videoTitle").val(resultTitle);
	    		$("#videoEmmbed").attr("src", "http://www.youtube.com/embed/"+resultId);
	    		$("#videoURL").attr("href", "http://www.youtube.com/watch?v="+videoId);
	    		$("#resId").val(resultId);
	    		
	    		$('#itemLoader').hide();
	    	});
        },
        error       : function(jqXHR, textStatus, errorThrown){ 
        	console.log('error: %s', errorThrown);
        },
        beforeSend  : function(){ 

        },
        crossDomain : true
    });
}

function getYoutubeIdFromURL(url) {
	var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
	if(videoid != null)
	   return videoid[1];
	else
		return null;
}

/**
 * Add Video Item to Article
 * 
 */
function onAddVideoItem(element) {
	var resId 		= $("#resId").val().trim();
	if(!resId.length) {
		alert("一時的な問題により、アクセスできません。しばらくしてからもう一度お試しください。");
		return;
	}
	
	var videoTitle   = $( "#videoTitle" ).val().trim();
	var videoComm    = $( "#videoComment" ).val().trim();
	var videoEmbed         = "http://www.youtube.com/embed/"+resId;
	var videoSourceTarget  = "http://www.youtube.com/watch?v="+resId;
	
	//var itemId      = getItemId();
	var curItemId   = $("#contentArea").find("#editItemId").val();
	
	$('#contentArea').find("#addItemTab").html("");

	//Begin Save Content
	var udata = "ctype=6&article_id=" + ARTICLE_ID;//Video
	udata += "&videoEmbed=" + videoEmbed + "&videoSourceTarget=" + videoSourceTarget + "&videoTitle=" + videoTitle + "&videoComm=" + videoComm;
	udata += "&videoId=" + resId;
	saveItem(udata);
	//End Save Content

	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_video", function (data) {	
		
		var articleVideo = data.replace("[videoEmbed]", videoEmbed);	
		articleVideo = articleVideo.replace("[videoSourceTarget]", videoSourceTarget);
		articleVideo = articleVideo.replace("[videoTitle]", videoTitle);
		articleVideo = articleVideo.replace("[videoComm]", videoComm);
		articleVideo = articleVideo.replace("[videoId]", resId);
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			
			var article = data.replace("[articleText]", articleVideo);	
			article = article.replace("[itemEditFunc]", "onEditVideoItem(this)");
			
			if(curItemId==0 || !curItemId.length) {
				article = article.replace("[articleItemId]", articleItemId);
				setHtml(article);
				if(!videoComm.length)
					$("#contentItems").find("#"+articleItemId).find(".articleVideoText").hide();
			} else {
				article = article.replace("[articleItemId]", curItemId);
				$("#"+curItemId).replaceWith(article);
				if(!videoComm.length)
					$("#"+curItemId).find(".articleVideoText").hide();
			}
			sortUpdate();
		});
	});
}

/**
 * Open Video Item and Fill Data to Edit
 * 
 */
function onEditVideoItem(element) {
	var parent = getParent(element);
	
	var videoId     = parent.find("#articleVideoId").val().trim();
	var videoTitle  = parent.find(".articleVideoTitle").text().trim();
	var videoEmbed  = parent.find("#articleVideoEmmbed").attr("src").trim();
	var videoURL    = parent.find(".articleVideoSourceView").attr("href").trim();
	var videoComm   = parent.find(".articleVideoDesc").text().trim();
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_check_video", function (data) {				
		$("#contentArea").find("#addItemTab").html(data);		
		
		$("#videoTitle").val(videoTitle);
		$("#videoEmmbed").attr("src", videoEmbed);
		$("#videoURL").attr("href", "http://www.youtube.com/watch?v="+videoId);
		$("#videoComment").val(videoComm);
		$("#resId").val(videoId);
		
    	$("#btnCheckVideo").val("保存");
	});
	
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}

function onSearchVideoBtnClick() {
	var _q      = $("#videoKeyword").val().trim();
    
    if(!_q.length) {
    	alert("検索するキーワードを入力してください。");
    	return;
    }
    
    $("#videoKeywordQ").val(_q);
    $('#googleList').empty();
    $('#youtubeList').empty();
    
    for (var i = 0; i < 2; i++) {
		var start = i * 10 + 1;
		setTimeout(doSearchGoogleVideo(start, _q), 200);	
	}
	doSearchYoutubeVideo("", _q);
}

function doSearchGoogleVideo(start, _q) {
    $.ajax({
        url     : $._urlGSearch,
        type    : 'GET',
        dataType : 'jsonp',
        data :{
            key : $._key,
            cx  : $._cx_video,
            q   :_q,
            start: start,
            num: $._num
        },
        success     : function(data, textStatus, jqXHR){  
        	responseGoogleVideoHandler(data); 
        	$("#googPage").val(start);
        	$("#googMore").show();
    		$("#googMoreLoading").hide();
        },
        error       : function(jqXHR, textStatus, errorThrown){ console.log('error: %s'), errorThrown},
        beforeSend  : function(){ 
        	console.log('sending request');
        	$("#videoSearchTab").show();
        },
        crossDomain : true
    });
}

function responseGoogleVideoHandler(response) {

    var len = response.items.length;
    var content = $('#googleList');

    $.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=item_video_search", function (data) {

    	for (var i = 0; i < len; i++) {
            var item = response.items[i]; 
            
            var source = item.displayLink;
            
            if(!/^(https?|ftp):\/\//i.test(source)) {
            	source = 'http://'+source; 
            }
            
            var html = data.replace("[videoThumb]", item.pagemap.videoobject[0].thumbnailurl);	
            html = html.replace("[videoTitle]", item.title);		
            html = html.replace("[videoTitleView]", item.title);		
            html = html.replace("[videoUrl]", item.link);
            html = html.replace("[videoSourceTarget]", source);		
            html = html.replace("[videoSource]", item.displayLink);
            html = html.replace("[videoEmbedUrl]", item.pagemap.videoobject[0].embedurl);
            html = html.replace("[videoId]", item.pagemap.videoobject[0].videoid);
            
        	content.append(html);
        }
	});
}

/**
 * Add Video Item from Search Results to Article
 * 
 */
function onBtnVideoSearchAdd(element) {
	var total = $(".videoSearchCountInner").text();
	total = parseInt(total);
	
	$(".videoSearchCountInner").text(total+1);
	$('#contentArea').find("#addItemTab").empty();
	$(element).attr("disabled", "disabled");
	
	var parent = $(element).closest("li");
	
	var videoTitle     = parent.find( "#videoSearchItemTitle" ).text().trim();
	var videoEmbed     = parent.find( "#videoEmbedUrl" ).val().trim();
	var videoUrl       = parent.find( "#videoSearchItemTitle" ).attr("href");
	var videoId        = parent.find( "#videoId" ).val().trim();
	var videoComm	   = "";
	//var itemId 		   = getItemId();

	//Begin Save Content
	var udata = "ctype=6&article_id=" + ARTICLE_ID;//Video
	udata += "&videoEmbed=" + videoEmbed + "&videoSourceTarget=" + videoUrl + "&videoTitle=" + videoTitle + "&videoComm=" + videoComm;
	udata += "&videoId=" + videoId;
	saveItem(udata);
	//End Save Content

	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_video", function (data) {	
		
		var articleVideo = data.replace("[videoEmbed]", videoEmbed);	
		articleVideo = articleVideo.replace("[videoSourceTarget]", videoUrl);
		articleVideo = articleVideo.replace("[videoTitle]", videoTitle);
		articleVideo = articleVideo.replace("[videoComm]", "");
		articleVideo = articleVideo.replace("[videoId]", videoId);
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {	
			
			var article = data.replace("[articleText]", articleVideo);	
			article = article.replace("[itemEditFunc]", "onEditVideoItem(this)");
			article = article.replace("[articleItemId]", articleItemId);
			
			setHtml(article);
			$("#contentItems").find("#"+articleItemId).find(".articleVideoText").hide();
			
			sortUpdate();
		});
	});
}

function doSearchYoutubeVideo(pageToken, _q) {       
    $.ajax({
        url     : $._urlGVideoSearch,
        type    : 'GET',
        dataType : 'jsonp',
        data :{
            key : $._key,
            q   : _q,
            part: $._part,
            maxResults: 30,
            type: 'video',
            videoEmbeddable : true,
            pageToken: pageToken
        },
        success     : function(data, textStatus, jqXHR){  
        	responseYoutubeVideoHandler(data); 
        	$("#youtuMore").show();
    		$("#youtuMoreLoading").hide();
        },
        error       : function(jqXHR, textStatus, errorThrown){ console.log('error: %s'), errorThrown},
        beforeSend  : function(){ 
        	console.log('sending request');
        	$("#videoSearchTab").show();        	
        },
        crossDomain : true
    });
}

function responseYoutubeVideoHandler(response) {

    var len = response.items.length;
    var content = $('#youtubeList');
    var source = "http://www.youtube.com";
    var sourceDisplay = "www.youtube.com";
    
    $('#youtuPageToken').val(response.nextPageToken);
    
    $.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=item_video_search", function (data) {

    	for (var i = 0; i < len; i++) {
            var item = response.items[i]; 
            var itemId = item.id.videoId;
            var videoEmbed   = "http://www.youtube.com/embed/"+itemId;
        	var videoUrl     = "http://www.youtube.com/watch?v="+itemId;
        	
            var html = data.replace("[videoThumb]", item.snippet.thumbnails.medium.url);	
            html = html.replace("[videoTitle]", item.snippet.title);		
            html = html.replace("[videoTitleView]", item.snippet.title);		
            html = html.replace("[videoUrl]", videoUrl);
            html = html.replace("[videoSourceTarget]", source);		
            html = html.replace("[videoSource]", sourceDisplay);
            html = html.replace("[videoEmbedUrl]", videoEmbed);
            html = html.replace("[videoId]", itemId);
            
        	content.append(html);
        }
	});
}

/*
 * =====================================================================
 * QUOTE TAB EVENT  
 * =====================================================================
*/ 

/**
 * Add Quote Item to Article
 * 
 */
function onAddQuoteItem() {
	var quoteContent  = $("#quoteContent").val().trim();
	if(!quoteContent.length) {
		alert("引用が入力されていません。");
		return;
	}
	
	quoteContent = stripTags(quoteContent);
	var quoteSourceTarget  = $("#quoteSourceTarget").val().trim();
	var quoteSource   = $("#quoteSource").val().trim();
	var quoteComment  = $("#quoteComment").val().trim();
	
	if(quoteSourceTarget.length > 0) {
		if(!/^(https?|ftp):\/\//i.test(quoteSourceTarget)) {
			quoteSourceTarget = 'http://'+quoteSourceTarget; 
	    }
	    
		$isValid = checkValidURL(quoteSourceTarget);
		if(!$isValid) {
			alert("URLの入力形式が異なっています。");
			return;
		}
	}
	
	if(!quoteSource.length)
		quoteSource = quoteSourceTarget;
	
	//var itemId      = getItemId();
	var curItemId   = $("#contentArea").find("#editItemId").val();
	
	$('#contentArea').find("#addItemTab").html("");
	//Begin Save Content
	var udata = "ctype=3&article_id=" + ARTICLE_ID;//Video
	udata += "&articleQuote=" + quoteContent + "&articleQuoteSourceTarget=" + quoteSourceTarget + "&articleQuoteSource=" + quoteSource + "&articleQuoteComment=" + quoteComment;
	saveItem(udata);
	//End Save Content
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_quote", function (data) {		
		var articleQuote = data.replace("[articleQuote]", nl2br(quoteContent));
		articleQuote = articleQuote.replace("[articleQuoteSourceTarget]", quoteSourceTarget);
		articleQuote = articleQuote.replace("[articleQuoteSource]", quoteSource);
		articleQuote = articleQuote.replace("[articleQuoteComment]", nl2br(quoteComment));
		
		$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_element", function (data) {		
			var article = data.replace("[articleText]", articleQuote);		
			article = article.replace("[itemEditFunc]", "onEditQuote(this)");
			
			if(curItemId==0 || !curItemId.length) {
				article = article.replace("[articleItemId]", articleItemId);
				setHtml(article);
				if(!quoteSource)
					$("#contentItems").find("#"+articleItemId).find(".articleVideoSource").hide();
			} else {
				article = article.replace("[articleItemId]", curItemId);
				$("#"+curItemId).replaceWith(article);
				if(!quoteSource)
					$("#contentItems").find("#"+curItemId).find(".articleVideoSource").hide();
			}
			sortUpdate();
	    });	
    });
}

/**
 * Open Quote Tab and Fill Data to Edit
 * 
 */
function onEditQuote(element) {
	var parent = getParent(element);
	
	var quoteContent = parent.find("#articleQuote").html().trim();
	var quoteSourceTarget  = parent.find("#articleQuoteSourceTarget").attr("href");
	var quoteSource   = parent.find("#articleQuoteSourceTarget").text().trim();
	var quoteComment  = parent.find("#articleQuoteComment").html().trim();
	
	quoteContent = br2nl(quoteContent);
	quoteComment = br2nl(quoteComment);
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_quote", function (data) {	
		$("#contentArea").find("#addItemTab").html(data);		
		
		$("#quoteContent").val(quoteContent);
		$("#quoteSourceTarget").val(quoteSourceTarget);
		$("#quoteSource").val(quoteSource);
		$("#quoteComment").val(quoteComment);

	});
	
	$('#contentArea').find("#editItemId").val(parent.attr("id"));
}


/*
 * =====================================================================
 * UTILS SECTION  
 * =====================================================================
*/ 

/**
 * Generate Unique ID For Each Article Item
 * 
 */
function getItemId() {
	$lastId = $("#lastId").val().trim();
	$lastId = parseInt($lastId);
	if(!$.isNumeric($lastId)) {
		$lastId = 0;
	}
	$newId = $lastId + 1;
	$("#lastId").val($newId);
	$itemId = "item"+$newId;
	
	return $itemId;
}

/**
 * Get Root Parent Div of An Article Item
 * 
 */
function getParent(element) {
	return $(element).closest("div").parent().parent();
}

/**
 * Remove HTML Tags
 * 
 */
function stripTags(str) {
	str = "<div>" + str + "</div>";
	return $(str).text();
}

/**
 * Convert HTML Tags To String
 * 
 */
function htmlspecialchars(string, quote_style, charset, double_encode) {
  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined' || quote_style === null) {
    quote_style = 2;
  }
  string = string.toString();
  if (double_encode !== false) {
    // Put this first to avoid double-encoding
    string = string.replace(/&/g, '&amp;');
  }
  string = string.replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');

  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') {
    // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/'/g, '&#039;');
  }
  if (!noquotes) {
    string = string.replace(/"/g, '&quot;');
  }

  return string;
}

/**
 * Convert RGB to HEX
 * 
 */
function rgb2hex(rgb){
	 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
	 return "#" +
	  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
	  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
	  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
}
/**
 * Confirm before remove element
 * 
 */
function onItemRemove(element) {
	if (confirm('本当に削除してよろしいですか？')) { 
		parent = getParent(element);
		parent.remove();
		
		var id = parent.attr("id");
		deleteItem(id);
    }
}
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

function displayAddHereTab(element) {
	var parent = $(element).parents(".articleContent");
	var parentId = parent.attr("id");
	
	//reset current edit
	$('#contentArea').find("#editItemId").val("");
	$("#contentArea").find(".articleAddHere").hide();
	$("#contentArea").find(".newItem").empty();
	
	$("#itemPos").val(parentId);
	
	
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=article_add_here", function (data) {
		data = data.replace(/itemId/g, parentId);
		parent.find(".articleAddHereTab").html(data);
    });
}

function hideAddHereTab(element) {
	var parent = $(element).parents(".articleContent");
	$('#contentArea').find(".articleAddHere").show();
	parent.find(".articleAddHereTab").empty();
}

function setHtml(data) {
	var itemPos = $("#itemPos").val();
	if(itemPos.length>0) {
		var item = $("#contentItems").find("#"+itemPos);
		$(data).insertAfter(item);
		$(item).find("#articleAddHereTab").empty();
		$('#contentArea').find(".articleAddHere").show();
	} else {
		$("#contentItems").prepend(data);
		$('#contentArea').find("#addItemTab").html("");
	}
}

function displayCheckTab(data) {
	var itemPos = $("#itemPos").val();
	if(itemPos.length>0) {
		var item = $("#contentItems").find("#"+itemPos);
		$(item).find("#articleAddHereTab").html(data);
	} else {
		$('#contentArea').find("#addItemTab").html(data);
	}
}

function br2nl(str) {
	return str.replace(/<br>/g, "\n");
}

function nl2br(str) {
	return str.replace(/\n/g, '<br/>');
}