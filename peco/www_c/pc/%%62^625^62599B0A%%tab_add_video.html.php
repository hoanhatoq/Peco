<?php /* Smarty version 2.6.19, created on 2015-02-02 11:06:44
         compiled from components/tab_add_video.html */ ?>
<div id="addVideoTab" class="newItem clearfix">
	<div class="magB10">
		<img class="itemVideoThumbDef" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/default_video.png" style="float:none">
	</div>
	<div class="clearfix">
		<input type="text" id="videoUrl" placeholder="追加する動画のURLを入力" style="margin-top: 0px;">
		<p style="display: inline-block">
			<a class="itemVideoSearch" onclick="onOpenVideoSearchPopUp()">探して追加</a>
		</p>
		<div class="addItemBtn clearfix">
			<input class="btn btn_black" id="btnCheckImage" name="btnCheckImage" type="button" onclick="onCheckVideoItem(this)" value="チェック"/>
			<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
		</div>
	</div>
</div>