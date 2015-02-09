<?php /* Smarty version 2.6.19, created on 2015-02-02 11:33:05
         compiled from components/tab_check_video.html */ ?>
<div id="addVideoTab" class="newItem clearfix">
	<div>
		<iframe id="videoEmmbed" type="text/html" src="" width="480" height="360" frameborder="0" allowfullscreen="true"></iframe>
	</div>
	<input type="text" id="videoTitle" value="" style="width: 480px;">	
	<div id="videoSource">
		<span>出典</span><a id="videoURL" href="" target="_blank">YouTube</a>
	</div>
	<textarea id="videoComment" placeholder="動画の紹介コメントを入力" style="width: 480px; margin-top: 10px;"></textarea>
	<div>
		<div class="addItemBtn clearfix">
			<input class="btn btn_black" id="btnCheckVideo" name="btnCheckVideo" type="button" onclick="onAddVideoItem(this)" value="追加"/>
			<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
		</div>
	</div>
	<input id="resId" type="hidden" value="">
</div>