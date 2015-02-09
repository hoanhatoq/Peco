<?php /* Smarty version 2.6.19, created on 2015-02-03 09:25:50
         compiled from components/article_content.html */ ?>
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
<!--Begin Section-->
	<form action="" id="edit_<?php echo $this->_tpl_vars['ARTICLE_ID']; ?>
" method="post" accept-charset="UTF-8" novalidate="novalidate">
		<!--Begin Nav-->
		<div id="edit_nav" class="clearfix">
			<div class="inner1000 clearfix">
					<div class="edit_group_btn clearfix">
						<?php if ($this->_tpl_vars['arrOneArticle']['status'] == $this->_tpl_vars['ST_DRAFT'] || $this->_tpl_vars['arrOneArticle']['status'] == $this->_tpl_vars['ST_PRIVATE']): ?>
						<!-- <input class="btn" type="submit" value="公開する" id="btnPublish"  data-disable-with="保存中..." title="公開する">
						<input class="btn" type="submit" value="下書き保存" id="btnDraft" data-disable-with="保存中..." title="下書き保存">
						<input class="btn" type="submit" value="プレビュー" id="btnPreview" data-disable-with="保存中..." title="プレビュー"> -->
						<?php elseif ($this->_tpl_vars['arrOneArticle']['status'] == $this->_tpl_vars['ST_PUBLIC']): ?>
						<!-- <input class="btn" type="submit" value="保存する" id="btnSave"  data-disable-with="保存中..." title="保存する">
						<input class="btn" type="submit" value="非公開にする" id="btnPrivate" data-disable-with="保存中..." title="非公開にする"> -->
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
						<img width="100%" height="auto" src="<?php if ($this->_tpl_vars['arrOneArticle']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['ARTICLES']; ?>
/<?php echo $this->_tpl_vars['arrOneArticle']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" id="edit_list_thumbnail" class="crop_image" alt="タイトルを入力してください">
						</div>
					</div>
					<div class="edit_text">						
						<div><input id="list_title" name="list[title]" placeholder="まとめのタイトル（50文字以内）" size="30" value="<?php echo $this->_tpl_vars['arrOneArticle']['title']; ?>
" type="text"></div>
						<div><textarea cols="40" id="list_description" name="list[description]" placeholder="まとめの説明（160文字以内）" rows="20"><?php echo $this->_tpl_vars['arrOneArticle']['detail']; ?>
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