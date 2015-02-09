<?php /* Smarty version 2.6.19, created on 2015-02-02 08:06:31
         compiled from account/act_createpost.htm */ ?>
<script>
$.time 					= 	"<?php echo $this->_tpl_vars['google_api']['time']; ?>
";
$._urlGSearch    		= 	"<?php echo $this->_tpl_vars['google_api']['urlGSearch']; ?>
";
$._urlGVideo     		= 	"<?php echo $this->_tpl_vars['google_api']['urlGVideo']; ?>
";
$._urlGVideoSearch     	= 	"<?php echo $this->_tpl_vars['google_api']['urlGVideoSearch']; ?>
";
$._key    				= 	'<?php echo $this->_tpl_vars['google_api']['key']; ?>
';
$._cx     				= 	'<?php echo $this->_tpl_vars['google_api']['cx']; ?>
';
$._cx_video     		= 	'<?php echo $this->_tpl_vars['google_api']['cx_video']; ?>
';
$._num    				= 	10;
$._stype  				= 	'image'; 
$._part 				= 	'snippet';
var ARTICLE_ID			=	<?php echo $this->_tpl_vars['ARTICLE_ID']; ?>
;
var URL_IMAGES			=	"<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
";
var ERR_HEADING_NULL	=	"テキストが空です";
var ERR_TEXT_NULL		=	"テキストが空です";
var ERR_TITLE_NULL		=	"タイトルが空です";
var ERR_TITLE_TOO_LONG	=	"タイトルは50字以内で入力してください";
var ERR_DESC_NULL		=	"説明が空です";
var ERR_DESC_TOO_LONG	=	"説明は160字以内で入力してください";
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/createpost.css"> 
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/notify.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/fill.box.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/color-picker.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/peco-tab.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/peco-slider.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/peco-createpost.js"></script>

<section id="wrap" class="clearfix">
	<!--Begin Section-->
	<form action="" id="edit_<?php echo $this->_tpl_vars['ARTICLE_ID']; ?>
" method="post" accept-charset="UTF-8" novalidate="novalidate">
	
	<!--Begin Nav-->
	<div id="edit_nav" class="clearfix">
		<div class="inner1000 clearfix">
				<div class="edit_title"><span class="btn btn_grey">まとめ記事作成</span></div>
				<div class="edit_group_btn clearfix">
					<?php if ($this->_tpl_vars['arrOneArticle']['status'] == $this->_tpl_vars['ST_DRAFT'] || $this->_tpl_vars['arrOneArticle']['status'] == $this->_tpl_vars['ST_PRIVATE']): ?>
					<input class="btn btn_red" type="submit" value="公開する" id="btnPublish"  data-disable-with="保存中..." title="公開する">
					<input class="btn btn_black" type="submit" value="下書き保存" id="btnDraft" data-disable-with="保存中..." title="下書き保存">
					<input class="btn btn_black" type="submit" value="プレビュー" id="btnPreview" data-disable-with="保存中..." title="プレビュー">
					<?php elseif ($this->_tpl_vars['arrOneArticle']['status'] == $this->_tpl_vars['ST_PUBLIC']): ?>
					<input class="btn btn_red" type="submit" value="保存する" id="btnSave"  data-disable-with="保存中..." title="保存する">
					<input class="btn btn_black" type="submit" value="非公開にする" id="btnPrivate" data-disable-with="保存中..." title="非公開にする">
					<?php endif; ?>
				</div>
		</div>			
	</div>
	<!--End Nav-->
	<!--Begin ArticleInfo-->
	<div id="edit_article_info" class="clearfix">
		<div class="inner1000 clearfix" style="position:relative">
				<div class="edit_thumb">
					<div>
					<img width="100%" height="auto" src="<?php if ($this->_tpl_vars['arrOneArticle']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['arrOneArticle']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" id="edit_list_thumbnail" class="crop_image" alt="タイトルを入力してください">
					</div>
				</div>
				<div class="edit_text">						
					<div><input id="list_title" name="list[title]" placeholder="まとめのタイトル（50文字以内）" size="30" value="<?php echo $this->_tpl_vars['arrOneArticle']['title']; ?>
" type="text"></div>
					<div><textarea cols="40" id="list_description" name="list[description]" placeholder="まとめの説明文（160文字以内、改行は反映されません）" rows="20"><?php echo $this->_tpl_vars['arrOneArticle']['detail']; ?>
</textarea></div>
					<p class="desc_count"><span class="count">0</span>/160文字</p>
				</div>
		</div>
	</div>
	<!--End ArticleInfo-->
	</form>
	<form>
	<!--Begin ThumbEdit-->
	<div id="edit_thumb_area" class="clearfix">
		<div class="inner1000 clearfix">
				<span class="change_thumb_up"><a href="#" onclick="onOpenThumbSearchPopUp()"><i class='icon-search'></i>探して追加</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="uploadThumb" onclick="return switchAddThumbType(1);">アップロード</a><a href="#" id="remoteThumb" onclick="return switchAddThumbType(2);" style="display: none;">URLから追加する</a></span>
		</div>
		<div id="imgFromURL" class="inner1000 clearfix">
				<div id="img_from_url">
					<input type="text" value="" placeholder="画像のURLを入力" name="image_remote_url" id="image_remote_url" class="image_remote_url">
				</div>
				<input type="button" value="設定" name="commit" data-disable-with="設定中..." class="btn btn_default btn_upload_thumb" onclick="onSetRemoteThumb()">
		</div>
		<div id="imgFromLocal" class="inner1000 clearfix" style="display: none;">
				<div id="img_from_url">
					<input id="thumbUploadFromLocal" type="file" style="display: ;" onchange="setPreviewThumb(this)">
				</div>
		</div>
	</div>
	<!--End ThumbEdit-->
	</form>
	<!--Begin Wrapper-->
	<div id="edit_wrapper">
		<div class="inner1000 clearfix">
			<div id="addArea" class="clearfix">
					<ul class="clearfix">
						<li><a id="addHeadingTab" href="javascript:void(0)">見出し</a></li>
						<li><a id="addTextTab" href="javascript:void(0)">テキスト</a></li>
						<li><a id="addImageTab" href="javascript:void(0)">画像</a></li>
						<li><a id="addQuoteTab" href="javascript:void(0)">引用</a></li>
						<li><a id="addURLTab" href="javascript:void(0)">リンク</a></li>
						<li><a id="addTwitterTab" href="javascript:void(0)">Twitter</a></li>
						<li><a id="addVideoTab" href="javascript:void(0)">動画</a></li>
					</ul>
			</div>
			<div id="itemLoader" class="loading" style="display: none;">
	            <img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/loading.gif" alt="ローディング...">
	         </div>
			<div id="contentArea" class="clearfix">
				<input id="editItemId" type="hidden" value="">
				<div id="addItemTab"></div>
			    
				<div id="contentItems" class="sortable">
					<?php echo $this->_tpl_vars['contentItems']; ?>

					<input id="lastId" type="hidden" value="0">		
					<input id="itemPos" type="hidden" value="">					
							
				</div>					
			</div>
		</div>
	</div>
	<!--End Wrapper-->
<!--End Section-->
</section>
<!--Begin UrlSearchPopup-->

<div id="urlSearchPopUp">
		<div class="urlSearchHeader">
			<span>リンクを探す</span>
  			<input id="urlKeyword" type="text" placeholder="リンクを検索するキーワードを入力" onkeydown="submitForm1(event, '#btnUrlSearch');">
  			<input class="btn btn_black" id="btnUrlSearch" type="button" value="検索"/>
  			<input id="btnDialogClose" class="btn btn_default" type="button" value="閉じる">
  			<input id="urlKeywordQ" type="hidden" value="">
		</div>  
		<div class="urlSearchBody" style="display: none;">
			<div class="urlSearchBodyHead">
				<p class="urlSearchBodyHeadTextL01">検索結果</p>
				<div class="urlSearchBodyHeadTextR01">
					<span class="urlSearchPoweredBy">
						<a href="http://www.google.com/" target="_blank">
						<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/img_poweredbygoogle.png" alt="Powered by Google" class="urlSearchPoweredByGoogle"></a>
						<span class="urlSearchSeparator">|</span>
					</span>
					<span>追加したリンク</span>
					<span class="urlSearchCount">
						<span class="urlSearchCountInner">0</span>
					</span> 
					<span>件</span>
				</div>
			</div>
			<div class="urlSearchBodyContent">
				<ul class="urlSearchList">
					
				</ul>
				<input id="urlPage" type="hidden" value="1">
				<p class="urlSearchMore">
					<span class="urlSearchMore01">
						<a id="urlMore" class="urlSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
						<span id="urlMoreLoading" class="urlSearchMoreLoading" style="display: none;">読み込み中</span>
					</span>						
				</p>
			</div>
		</div>
	</div>
<!--End UrlSearchPopup-->
<!--Begin TwitterSearchPopup-->
	<div id="twitterSearchPopUp">
		<div class="tweetSearchHeader">
			<span>Twitterで検索してまとめる</span>
  			<input id="tweetKeyword" type="text" placeholder="検索するワードを入力" onkeydown="submitForm1(event, '#btnTweetSearch');">
  			<input class="btn btn_black" id="btnTweetSearch" type="button" value="検索"/>
  			<input id="btnTwitterClose" class="btn btn_default" type="button" value="閉じる">
  			<input id="tweetKeywordQ" type="hidden" value="">
  			<input id="tweetExcludeKeywordQ" type="hidden" value="">
  			
  			<div class="tweetSearchCheck">
		      <input type="radio" id="typeKeyword" name="rdTweetType" value="keyword" checked="checked" ><label for="typeKeyword">キーワード</label>
		      <input type="radio" id="typeUser" name="rdTweetType" value="user"><label for="typeUser">ユーザー</label>

		      <input type="checkbox" name="excludeRT" id="excludeRT" value="1" checked="checked" ><label id="lblExcludeRT" for="excludeRT">公式RT除く</label>
		    </div>
		    <div id="tweetWordExclude" class="tweetSearchCheck" style="margin-top: 0px;">
		      	<label>除外ワード</label>
  				<input id="tweetExcludeKeyword" type="text" placeholder="複数の場合は、スペースで区切ってください">
		    </div>
		</div>  
		<div class="tweetSearchBody" style="display: none;">
			<div class="tweetSearchBodyHead">
				<div style="display: inline-block;">
					<p class="tweetSearchBodyHeadTextL01">検索結果</p>
				</div>
				<div class="tweetSearchBodyHeadTextR01">
					<span>追加したツイート</span>
					<span class="tweetSearchCount">
						<span class="tweetSearchCountInner">0</span>
					</span> 
					<span>件</span>
				</div>
			</div>
			<div class="tweetSearchBodyContent">
				<ul class="tweetSearchList">
												
				</ul>
				<input id="tweetPage" type="hidden" value="">
				<input id="tweetType" type="hidden" value="">
				<p class="tweetSearchMore">
					<span class="tweetSearchMore01">
						<a id="tweetMore" class="tweetSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
						<span id="tweetMoreLoading" class="tweetSearchMoreLoading" style="display: none;">読み込み中</span>
					</span>						
				</p>
			</div>
		</div>
	</div>
	
	
	<div id="thumbSearchPopUp">
		<div class="imageSearchHeader">
	  		<span>画像を探す</span>
  			<input id="thumbKeyword" type="text" placeholder="キーワードを入力" onkeydown="submitForm1(event, '#btnThumbSearch');">
  			<input class="btn btn_black" id="btnThumbSearch" type="button" value="検索"/>
  			<input id="btnImageClose" class="btn btn_default" type="button" value="閉じる">
  			<input id="thumbKeywordQ" type="hidden">
		</div>  
		<div class="imageSearchBody" style="display: none;">
			<div class="imageSearchBodyHead">
				<div>
					<p class="imageSearchBodyHeadTextL01">検索結果</p>
				</div>
			</div>

			<div class="imageSearchBodyContent" >
				<ul id="thumbSearchList" class="imageSearchList">
										
				</ul>
				<input id="thumbPage" type="hidden" value="">
				<p class="thumbSearchMore">
					<span class="imageSearchMore01">
						<a id="thumbMore" class="imageSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
						<span id="thumbMoreLoading" class="imageSearchMoreLoading" style="display: none;">読み込み中</span>
					</span>						
				</p>
			</div>
		</div>
	</div>
	
	<div id="videoSearchPopUp">
		<div class="videoSearchHeader">
	  		<span>動画を探す</span>
  			<input id="videoKeyword" type="text" placeholder="動画を検索するキーワードを入力" onkeydown="submitForm1(event, '#btnVideoSearch');">
  			<input class="btn btn_black" id="btnVideoSearch" type="button" value="検索"/>
  			<input id="btnVideoClose" class="btn btn_default" type="button" value="閉じる">
  			<input id="videoKeywordQ" type="hidden" value="">
		</div>  
		<div id="videoSearchTab" style="margin-top: 10px; padding-top: 25px; display: none">
			<div class="videoSearchBody">
				<div class="videoSearchBodyHead">
					<div>
						<p class="videoSearchBodyHeadTextL01">検索結果</p>
					</div>
					<div class="videoSearchBodyHeadTextR01">
						<span class="videoSearchPoweredBy">
							<a href="http://www.google.com/" target="_blank">
							<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/img_poweredbygoogle.png" alt="Powered by Google" class="videoSearchPoweredByView"></a>
							<span class="videoSearchSeparator">|</span>
						</span>
						<span>追加した画像</span>
						<span class="videoSearchCount">
							<span class="videoSearchCountInner">0</span>
						</span> 
						<span>件</span>
					</div>
				</div>
				<ul>
					<li><a href="#tab-google">Google</a></li>
				    <li><a href="#tab-youtube">Youtube</a></li>
				</ul>
				<div id="tab-google" class="videoSearchBodyContent">
					<ul id="googleList" class="videoSearchList">
											
					</ul>
					<input id="googPage" type="hidden" value="">
					<p class="videoSearchMore">
						<span class="videoSearchMore01">
							<a id="googMore" class="videoSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
							<span id="googMoreLoading" class="videoSearchMoreLoading" style="display: none;">読み込み中</span>
						</span>						
					</p>
				</div>
				
				<div id="tab-youtube" class="videoSearchBodyContent">
					<ul id="youtubeList" class="videoSearchList">
										
					</ul>
					<input id="youtuPageToken" type="hidden" value="">				
					<p class="videoSearchMore">
						<span class="videoSearchMore01">
							<a id="youtuMore" class="videoSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
							<span id="youtuMoreLoading" class="videoSearchMoreLoading" style="display: none;">読み込み中</span>
						</span>				
					</p>
				</div>
			</div>
		</div>
	</div>
	
	
<div id="imgSearchPopUp" >
	<div class="imgSearchContent clearfix">
		<div class="imgSearchNavLeft">
			<h1 class="imgSearchNavLeftTtl">画像を探す</h1>
			<div>
				<ul class=imgSearchNavLeftView>
					<li class="imgSearchNavItem" style="display: list-item;">
						<span id="imgTabTabelog" title="食べログ">食べログ</span>
					</li>
					<li class="imgSearchNavItem" style="display: list-item;">
						<span id="imgTabGoogle" title="Google">Google</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="imgSearchRight">						
			<div class="imgSearchHeader" style="display: none;">
				<div class="imgSearchBox">
					<input id="imageKeyword" type="text" placeholder="キーワードを入力" onkeydown="submitForm1(event, '#btnImgSearch');">
		  			<input class="btn btn_black" id="btnImgSearch" type="button" value="検索"/>
		  			<input id="imageKeywordQ" type="hidden">
				</div>
	  			
	  			<p class="imgSearchStatus">
					<span>追加した画像</span>
					<span class="imageSearchCount">
						<span class="imageSearchCountInner">0</span>
					</span> 
					<span>件</span>
				</p>
			</div>  
			<div id="imgSearchTab" class="imgSearchResult" style="display: none;">
				<div id="imgTabGoogleContent" class="imgSearchResultBody" style="display: none;">
					<ul id="imgSearchList" class="imageSearchList">
											
					</ul>
					
					<input id="imgPage" type="hidden" value="">					
					<p class="imageSearchMore" style="display: none;">
						<span class="imageSearchMore01">
							<a id="imgGoogMore" class="imageSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
							<span id="imgGoogMoreLoading" class="imageSearchMoreLoading" style="display: none;">読み込み中</span>
						</span>						
					</p>
				</div>
				
				<div id="imgTabTabelogContent" class="imgSearchResultBody" style="display: none;">
					<ul id="imageTabelogList" class="imageSearchList">
									
					</ul>
					<input id="imgTabelogPage" type="hidden" value="">
					<p class="imageSearchMore" style="display: none;">
						<span class="imageSearchMore01">
							<a id="imgTabelogMore" class="imageSearchMore01Btn" href="javascript:void(0)">もっと見る</a>
							<span id="imgTabelogMoreLoading" class="imageSearchMoreLoading" style="display: none;">読み込み中</span>
						</span>						
					</p>
				</div>
			</div>
		</div>
	</div>
	<p class="imgSearchHeaderClose">
		<span id="btnImgClose" title="閉じる" class="imgSearchHeaderClsBtn">x</span>
	</p>
</div>	