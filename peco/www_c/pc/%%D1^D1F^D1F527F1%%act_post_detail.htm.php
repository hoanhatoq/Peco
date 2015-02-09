<?php /* Smarty version 2.6.19, created on 2015-02-02 08:51:47
         compiled from home/act_post_detail.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'home/act_post_detail.htm', 26, false),array('modifier', 'default', 'home/act_post_detail.htm', 41, false),)), $this); ?>
<section id="topBar">
  <div class="inner1000 clearfix">
    <ul class="breadcrumb">
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a itemprop="url" href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
"><span itemprop="title">トップページ</span></a></li>      
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class='truncate'><strong itemprop="title"><?php echo $this->_tpl_vars['article']['title']; ?>
</strong></li>
    </ul>
  </div>
</section>
<?php if ($this->_tpl_vars['mode'] == 'preview'): ?>
<div class="preview">
  <p style="text-align:center">プレビュー画面です。この画面はこのまとめのキュレーターだけが見ることができます。 「<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_addId($this->_tpl_vars['article']['id']); ?>
" class="color-red">編集を続行</a>」</p>
</div>
<?php endif; ?>
<div id="wrap_post_header" class="clearfix">
<div class="inner1000 magT20 clearfix">
	<div id="post_header">
		<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ""): ?>
		<div class="post_thumb">
			<img src="<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" alt=""/>
		</div>
		<?php endif; ?>
		<div class="post_title_lead">
			<h1 itemprop="name" class="magT0"><?php echo $this->_tpl_vars['article']['title']; ?>
</h1>
			<p class="pLead"><?php echo $this->_tpl_vars['article']['detail']; ?>
</p>
			<a href="#" class="author"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/thumb1.jpg" class="small_avatar"> <?php echo $this->_tpl_vars['article']['username']; ?>
</a>
			<span class="post_date">更新日： <?php echo ((is_array($_tmp=$this->_tpl_vars['article']['published_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y.%m.%d") : smarty_modifier_date_format($_tmp, "%Y.%m.%d")); ?>
</span>	
			<ul class="share">
	          <li style="width:106px">
	            <a href="https://twitter.com/share" class="twitter-share-button" data-url="" data-text="" data-lang="ja" data-related="peco"></a>
	          </li>
	          <li>
	            <div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
	          </li>
	          <li>
				<div class="g-plusone"></div>
	          </li>
	        </ul>
		</div>
		<div class="post_stats">
			<ul>
				<li><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/icon-star-red.png" width="16"> <b id='favorite_num_<?php echo $this->_tpl_vars['article_id']; ?>
'><?php echo ((is_array($_tmp=@$this->_tpl_vars['article']['favorite_num'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</b><br>お気に入り</li>
				<li><b><?php echo ((is_array($_tmp=@$this->_tpl_vars['article']['page_view'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</b><br>VIEW</li>
			</ul>
			<a class="btn-primary-like btn-large magB10" onclick="return addFavorites(<?php echo $this->_tpl_vars['article']['id']; ?>
);"><i class='icon icon-star'></i>お気に入りに追加</a>
		</div>
	</div>
</div>
</div>
<div id="wrap" class="clearfix">
<div class="inner1000 clearfix" id="article">
	<div id="main" class="magT20">
		<?php echo $this->_tpl_vars['contentItems']; ?>

		
		<div id="relatedArticles">
	        <h2>関連まとめ</h2>
			<!--Begin Post Listing-->
			<div class="post_list magT10" id="related_list">
					<?php $_from = $this->_tpl_vars['arrListRelatedArticles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['related_article']):
?>
					<!--Begin One Post-->
					<div class="one_post clearfix">
						<div class="thumb"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['related_article']['id']); ?>
"><img src="<?php if ($this->_tpl_vars['related_article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['related_article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" alt="" class="img"/></a></div>
						<div class="text">
							<p class="post_title clearfix"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['related_article']['id']); ?>
"><?php echo $this->_tpl_vars['related_article']['title']; ?>
</a></p>
							<span class="flLeft">by <?php echo $this->_tpl_vars['related_article']['username']; ?>
</span><span class="flRight clearfix"><b><?php echo ((is_array($_tmp=@$this->_tpl_vars['related_article']['page_view'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</b> view</span>
						</div>
					</div>
					<!--End One Post-->
					<?php endforeach; endif; unset($_from); ?>
			</div>
			<!--End Post Listing-->	        
	    </div>
	</div>
	<div id="sidebar">
		<?php if ($this->_tpl_vars['article']['created_by'] == $this->_tpl_vars['core']->_USER['id']): ?>
		<div class="magT20">
		 <a href="<?php echo $this->_tpl_vars['clsRewrite']->url_addId($this->_tpl_vars['article']['id']); ?>
" class="color-red"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/btn_edit_post.png"></a>
		</div>
		<?php endif; ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_sidebar.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
</div>
</div>


<?php echo '
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=1014962838531063&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: \'ja\'}
</script>
'; ?>