jQuery.fn.pecoSlider = function() { 
	var slideCount;
	var slideWidth;
	var slideHeight;
	var sliderUlWidth;
	
	initSlider();
    
    function initSlider() {
    	slideCount = $('#slider ul li').length;
    	slideWidth = $('#slider ul li').width();
    	slideHeight = $('#slider ul li').height();
    	sliderUlWidth = slideCount * slideWidth;
    	
    	$('#slider').css({ width: slideWidth, height: "auto" });
    	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
        $('#slider ul li:last-child').prependTo('#slider ul');
    }
    
    function moveLeft() {
        $('#slider ul').animate({ 
            left: + slideWidth
        }, 200, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
            
        });
    };
    
    function checkValidURL(val) {
        return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(val);
    }
    
    $('a.controlPrev').click(function () {
    	$curImg = parseInt($("#curImg").text());  
    	if($curImg<=1) {
    		return;
    	}
    	else {
    		$("#curImg").text($curImg - 1);
    	}
        moveLeft();
    });

    $('a.controlNext').click(function () {
    	$curImg = parseInt($("#curImg").text()); 
    	$totalImg = parseInt($("#totalImg").text());
    	
    	if($curImg>=$totalImg) {
    		return;
    	}
    	else {
    		$("#curImg").text($curImg + 1);
    	}
        moveRight();
    });
    
    $('input#noImg').click(function () {

    	if($(this).prop('checked') == true) {
    		$("#slider").hide();
        	$("#divNoImg").show();
    	} else {
    		$("#slider").show();
        	$("#divNoImg").hide();
    	}
    });

    $('a.imgURLCheck').click(function () {
    	$retUmg = $("#itemThumbURL").val();
    	
    	if(!/^(https?|ftp):\/\//i.test($retUmg)) {
    		$retUmg = 'http://'+$retUmg;
        }
    	
    	$isValid = checkValidURL($retUmg);
    	if(!$isValid) {
    		alert("URLの入力形式が異なっています。");
    		return;
    	}
    	
    	if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test($retUmg)) {
			alert('エラーが発生したため、画像の追加に失敗しました。');
			return;
		}
    	
    	var total = parseInt($("#totalImg").text());
    	var siteImgs    = $("#imgList").val(); 
    	var inx = -1;
    	var pos = 0;
    	var cur = 0;
    	
    	var images      = new Array();
    	
    	if(siteImgs.length > 0) {
			images      = $.parseJSON(siteImgs);
			inx = images.indexOf($retUmg);
		}
    	
    	if(inx == -1) {
			images.unshift($retUmg);
			total += 1;
			pos    = 0;

			var imgTag = "<li>" + "<img style='max-width: 150px;' src="+$retUmg+">" + "</li>";
	    	$("#slider ul").prepend(imgTag);
		} else {
			var listImg = "<ul>";
			$.each( images, function( key, value ) {
				listImg += "<li>" + "<img style='max-width: 150px;' src="+value+">" + "</li>";
			});
			listImg += "</ul>";
			$("#slider").html(listImg);
			pos = inx;
		}
    	
    	$("#curImg").text(pos+1);
    	$("#totalImg").text(total);
    	$("#imgList").val(JSON.stringify(images));
    	
    	initSlider();
    	moveToPos(pos);
    	
    	$("#divThumbURL").hide();
    	$("#addRemoteURL").show();
    	$("#itemThumbURL").val("");
    });
}

function moveToPos(pos) {
	var slideWidth = $('#slider ul li').width();
	
	for (var i = 0; i < pos; i++) {
		$('#slider ul').animate({
            left: - slideWidth
        }, 1, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
            
        });
	}
}