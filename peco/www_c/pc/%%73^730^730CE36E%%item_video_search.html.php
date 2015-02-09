<?php /* Smarty version 2.6.19, created on 2015-02-02 12:00:01
         compiled from components/item_video_search.html */ ?>
<li class="videoSearchItem">
	<div class="videoSearchThumb">
		<p>
			<img src="[videoThumb]" style="width: 145px; height:92px">
		</p>
		<p class="videoSearchBtn">
			<a id="videoSearchAddBtn" onclick="onBtnVideoSearchAdd(this)"></a>
		</p>
	</div>
	<div>
		<p class="videoSearchItemTitle"><a id="videoSearchItemTitle" target="_blank" title="[videoTitle]" href="[videoUrl]">[videoTitleView]</a></p>
		<p class="videoSearchItemSource"><a id="videoSearchItemSource" target="_blank" href="[videoSourceTarget]">[videoSource]</a></p>
	</div>
	<input id="videoEmbedUrl" type="hidden" value="[videoEmbedUrl]">
	<input id="videoId" type="hidden" value="[videoId]">
</li>