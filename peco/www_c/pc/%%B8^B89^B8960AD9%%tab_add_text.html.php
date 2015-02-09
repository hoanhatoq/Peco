<?php /* Smarty version 2.6.19, created on 2015-02-02 08:28:59
         compiled from components/tab_add_text.html */ ?>
<div id="addTextTab" class="newItem">				    	
	<textarea id="textContent" rows="8" placeholder="テキストを入力" ></textarea>
  	<select id="textStyleType">
  		<option value="1">小さめ文字サイズ</option>
		<option value="2" selected="selected">標準文字サイズ</option>
		<option value="3">大きめ文字サイズ</option>
		<option value="4">太文字</option>
		<option value="5">太文字・大きめ文字サイズ</option>
	</select>
	<div class="addItemBtn clearfix">
		<input class="btn btn_black" data-disable-with="処理中..." id="btnAddText" type="button" onclick="onAddTextItem()" value="追加"/>
		<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
	</div>
</div>