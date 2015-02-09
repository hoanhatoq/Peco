<?php /* Smarty version 2.6.19, created on 2015-02-02 11:06:35
         compiled from components/tab_add_twitter.html */ ?>
<div id="addTwitterTab" class="newItem">				    	
	<input id="twitterLink" type="text" placeholder="追加するTweetのURLを入力" style="margin-top: 0px;" value="" />
	<p><a href="javascript:void(0)" onclick="onOpenSearchTwitterPopUp()" >探して追加</a></p>
	<div class="addItemBtn clearfix">
		<input class="btn btn_black" id="btnCheckURL" name="btnCheckURL" type="button" onclick="onCheckTwitterItem(this)" value="チェック"/>
		<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
	</div>
</div>