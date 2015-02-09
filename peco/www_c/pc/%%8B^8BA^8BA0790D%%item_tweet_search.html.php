<?php /* Smarty version 2.6.19, created on 2015-02-02 11:23:07
         compiled from components/item_tweet_search.html */ ?>
<li class="tweetSearchItem">
	<div class="tweetSearchItemAvatar">
		<img src="[avatar]" class="tweetSearchItemAvatarView">
	</div>
	<div class="tweetSearchItemInfo">
		<p class="tweetSearchItemTitle">
			<b class="articleTwitterUserName01FullName">[name]</b>
			<span class="articleTwitterUserName01ScreenName">[screenName]</span>
		</p>
		<p class="tweetSearchItemDesc">[text]</p>
		<p class="tweetSearchItemImg">
			<a id="tweetSearchItemImgTarget" href="[imgTarget]" target="_blank">
				<img id="tweetSearchItemImgView" src="[imgSrc]">
			</a>
		</p>
		<p class="tweetSearchItemURL"><a target="_blank" href="#">[time]</a></p>
	</div>
	<div>
		<p class="tweetSearchItemAdd">
			<input id="tweetSearchItemAddBtn" class="btn btn_default" type="button" value="まとめに追加" onclick="onBtnAddTweetClick(this)">
		</p>
	</div>
</li>