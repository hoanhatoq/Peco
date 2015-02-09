jQuery.fn.pecoTab = function() {  
	return this.each(function(){
		var $links   = $(this).find('a');
		var $active  = $($links[0]);
		var $content = $($active[0].hash);
		
		$(this).on('click', 'a', function(e) { 
			$('#itemLoader').show();
			//reset current edit
			$('#contentArea').find("#editItemId").val("");
			//empty add here tab
			$('#contentArea').find(".articleAddHereTab").html("");
			$('#contentArea').find(".articleAddHere").show();
			
			//set first position
			$("#itemPos").val("");
			
			// Make the old tab inactive.
			$active.removeClass('current');
			// Update the variables with the new tab link
			$active = $(this);
			// Make the tab active.
			$active.addClass('current');
			//Get active tab id
			$activeId = $($active).attr("id");
			//Set target position to display tab
			$target = "#addItemTab";
			$parent = "#contentArea";
			// Process to show tab
			setTimeout(function(){
				getTabContent($activeId);
				$('#itemLoader').hide();
		    }, 300);
			
			
			e.preventDefault();
		});
	});
};

function getTabContent($tab) { 
	switch ($tab) {
	case "addHeadingTab":
		showHeadingTab();
		break;
		
	case "addTextTab":
		showTextTab();
		break;
		
	case "addURLTab":
		showURLTab();
		break;
		
	case "addTwitterTab":
		showTwitterTab();
		break;
		
	case "addImageTab":
		showImageTab();
		break;
		
	case "addVideoTab":
		showVideoTab();
		break;
		
	case "addQuoteTab":
		showQuoteTab();
		break;
	default:
		break;
	}
}

function initHeadingMenu() {
	$( "#headingType" ).selectmenu({
		change: function() {
			onHeadingTypeChange();
        }
	});
	
	$( "#headingColor" ).val("#fc7c79");
	$( "#headingColor" ).simpleColorPicker({ 
		onChangeColor: function(color) { 
			$val = $( "#headingType" ).val();
			
			if($val==1) {
				$('#headingContent').css("border-bottom-color", color); 
			} else if ($val==2) {
				$('#headingContent').css("border-bottom", "1px solid #DDD"); 							
			}
			$('#colorSquare').css("color", color); 
		} 
	});
}

function onHeadingTypeChange() {
	$val = $( "#headingType" ).val();
	$headingColor = $("#headingColor").val().trim();
	
	if($val==1) {
		$('#headingContent').css("border-bottom", "2px solid "+$headingColor); 
		$('#colorSquare').hide();
	} else if ($val==2) {
		$('#headingContent').css("border-bottom", "1px solid #DDD"); 
		$('#colorSquare').show(); 
	}
}

function initTextMenu() {
	$( "#textStyleType" ).selectmenu();
}
function showHeadingTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_heading", function (data) {				
		$($parent).find($target).html(data);

		initHeadingMenu();
		$( "#headingContent" ).keyup(function( event ) {
			if($(this).val().length==0){
				show_validate_message(this, ERR_HEADING_NULL);
				return;
			}else{
				remove_validate_message(this);
				return;
			}
		});
	});
}

function showTextTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_text", function (data) {				
		$($parent).find($target).html(data);
		initTextMenu();
		$( "#textContent" ).keyup(function( event ) {
			if($(this).val().length==0){
				show_validate_message(this, ERR_HEADING_NULL);
				return;
			}else{
				remove_validate_message(this);
				return;
			}
		});
	});
}

function showURLTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_url", function (data) {				
		$($parent).find($target).html(data);
	});
}

function showTwitterTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_twitter", function (data) {				
		$($parent).find($target).html(data);
	});
}

function showImageTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_image", function (data) {				
		$($parent).find($target).html(data);
	});
}

function showVideoTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_video", function (data) {				
		$($parent).find($target).html(data);
	});
}

function showQuoteTab() {
	$.get(URL_CMS+"/?sub=ajax&act=getcomponent&c=tab_add_quote", function (data) {				
		$($parent).find($target).html(data);
	});
}

function addTab(parent, tab) {
	$target = "#articleAddHereTab";
	$parent = "#"+parent;
	getTabContent(tab);
}