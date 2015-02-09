<?php /* Smarty version 2.6.19, created on 2015-02-02 10:49:22
         compiled from components/tab_add_url.html */ ?>
<div id="addURLTab" class="newItem">				    	
	<input id="urlContent" type="text" placeholder="追加するリンクのURLを入力" style="margin-top: 0px;" value="" />
	<p><a href="javascript:void(0)" onclick="onOpenSearchPopUp()" >探して追加</a></p>
	<div class="addItemBtn clearfix">
		<input class="btn btn_black" id="btnCheckURL" name="btnCheckURL" type="button" onclick="onCheckURLItem(this)" value="チェック"/>
		<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
	</div>
</div>