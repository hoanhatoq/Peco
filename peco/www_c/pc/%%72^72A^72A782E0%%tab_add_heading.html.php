<?php /* Smarty version 2.6.19, created on 2015-02-02 08:10:39
         compiled from components/tab_add_heading.html */ ?>
<div id="addHeadingTab" class="newItem">
	<select id="headingType" onchange="onHeadingTypeChange()">
		<option value="1" selected="selected">通常の見出し</option>
		<option value="2">小見出し</option>
	</select>
	<div style="margin-top:20px">
		<span id="colorSquare" style="color:#fc7c79; display: none; float: left; margin: 9px 5px 0 0; font-size: 10px;">■</span>
		<input id="headingContent" placeholder="見出しの文章を入力" size="30" style="border-bottom:2px solid #fc7c79;" type="text">
	</div>						
	<input id="headingColor" size="30" type="text">
	<div class="addItemBtn clearfix">
		<input class="btn btn_black" data-disable-with="処理中..." id="btnAddHeading" type="button" onclick="onAddHeadingItem()" value="追加"/>
		<input id="btnCancel" class="btn btn_default" type="button" onclick="onCancel(this)" value="キャンセル">
	</div>
</div>