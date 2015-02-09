<?php /* Smarty version 2.6.19, created on 2015-02-02 09:53:30
         compiled from components/tab_check_image.html */ ?>
<div id="addCheckImageTab" class="newItem">
	<div>
		<img class="itemImagePreview" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/default_image.png" >
	</div>
	<div class="itemImageCheckArea">
		<input type="text" id="itemImageTitle" placeholder="画像のタイトルを入力" style="margin-top: 0px;">	
		<input type="text" id="imageUrl" placeholder="追加する画像のURLを入力" onchange="setPreviewRemoteImg(this)">
		<input id="imageUpload" name="upload[image]" type="file" style="display: none; padding-top: 10px;" onchange="setPreviewImage(this)">
		<input id="isUpload" type="hidden" value="false">
		<!-- <div>	
			<span><a class="itemImageUpload" onclick="switchAddImageType(1)">アップロード</a></span>
			<span><a class="itemImageLink" style="display: none;" onclick="switchAddImageType(2)">URLから追加する</a></span>
			<p style="display: inline-block; margin-left: 20px;"><a class="itemImageSearch">探して追加</a></p>
		</div> -->
		<textarea id="itemImageComment" placeholder="画像の紹介コメントを入力" style="width: 380px; margin-top: 10px;"></textarea>
		<input type="text" id="itemImageSource" placeholder="画像の出典元URLを入力" style="width: 380px;">
		<div class="addItemBtn clearfix" style="padding-left: 315px;">
			<input class="btn btn_black" id="btnCheckImage" name="btnCheckImage" type="button" onclick="onAddImageItem()" value="追加"/>
			<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
		</div>
	</div>
</div>