<?php /* Smarty version 2.6.19, created on 2015-02-02 08:06:34
         compiled from _sidebar.htm */ ?>
<!--Begin sidebar-->
<!--<div class="ads300">
<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/ads300x250.jpg" />
</div>-->
<div class="widget">
	<div class="widget_title clearfix"><h2>デイリーランキング</h2></div>
	<!--Begin Post Listing-->
	<div class="post_list">
		<?php $_from = $this->_tpl_vars['arrListTopDaily']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['article']):
?>
		<!--Begin One Post-->
		<div class="one_post clearfix">
			<div class="thumb"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
"><img src="<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" alt="" class="img"/>
			<img alt="1位" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/icon_rank<?php echo $this->_tpl_vars['k']+1; ?>
.png" class="icon_rank">
			</a></div>
			<div class="text">
				<p class="post_title clearfix"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a></p>
				<span>by <?php echo $this->_tpl_vars['article']['username']; ?>
</span>
			</div>
		</div>
		<!--End One Post-->
		<?php endforeach; endif; unset($_from); ?>
	</div>
	<!--End Post Listing-->
</div>
<div class="widget">
	<div class="widget_title clearfix"><h2>おすすめのまとめ</h2><p>一覧をみる！</p></div>
	<!--Begin Post Listing-->
	<div class="post_list">
		<?php $_from = $this->_tpl_vars['arrListRecommendList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['article']):
?>
		<!--Begin One Post-->
		<div class="one_post clearfix">
			<div class="thumb"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
"><img src="<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" alt="" class="img"/>
			</a></div>
			<div class="text">
				<p class="post_title clearfix"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a></p>
				<span>by <?php echo $this->_tpl_vars['article']['username']; ?>
</span>
			</div>
		</div>
		<!--End One Post-->
		<?php endforeach; endif; unset($_from); ?>
	</div>
	<!--End Post Listing-->
</div>
<div class="widget widget_topic">
	<div class="widget_title clearfix"><h2>人気のトピックス</h2><p>一覧をみる！</p></div>
	<ul>
		<?php $_from = $this->_tpl_vars['arrListTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['topic']):
?>
		<li class="tag"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_topic($this->_tpl_vars['topic']); ?>
"><?php echo $this->_tpl_vars['topic']['name']; ?>
 (<?php echo $this->_tpl_vars['topic']['total_article']; ?>
)</a></li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
</div>
<!--End sidebar-->