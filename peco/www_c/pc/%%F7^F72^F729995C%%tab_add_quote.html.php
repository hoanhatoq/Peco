<?php /* Smarty version 2.6.19, created on 2015-02-02 10:43:05
         compiled from components/tab_add_quote.html */ ?>
<div id="addQuoteTab" class="newItem">				    	
	<textarea id="quoteContent" rows="4" placeholder="引用を入力"  style="margin-bottom: 5px;"></textarea>
	<input id="quoteSourceTarget" placeholder="引用の出典元URLを入力(ウェブページの場合)" size="30" type="text" style="margin-top: 5px; width:690px" class="editableInput">
	<input id="quoteSource" placeholder="引用の出典を入力" size="30" type="text" style="margin-top: 5px; width:690px" class="editableInput">
	<textarea id="quoteComment" rows="2" placeholder="引用の紹介コメントを入力" style="margin-top: 5px;"></textarea>
	<div class="addItemBtn clearfix">
		<input class="btn btn_black" data-disable-with="処理中..." id="btnAddText" type="button" onclick="onAddQuoteItem()" value="追加"/>
		<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
	</div>
</div>