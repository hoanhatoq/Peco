<?php /* Smarty version 2.6.19, created on 2015-02-02 08:06:34
         compiled from home/act_default.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'home/act_default.htm', 9, false),array('modifier', 'date_format', 'home/act_default.htm', 39, false),array('modifier', 'mb_truncate', 'home/act_default.htm', 48, false),)), $this); ?>
<section id="pickUp">
	<div class="inner1000 clearfix">
		<ul>
			<?php $_from = $this->_tpl_vars['arrListTopPickup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['article']):
?>
			<li style="<?php if ($this->_tpl_vars['k'] == 2): ?>float:right; margin-right:0px<?php endif; ?>">
			<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
" class="clearfix" title="<?php echo $this->_tpl_vars['article']['title']; ?>
"><img src="<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" alt="<?php echo $this->_tpl_vars['article']['title']; ?>
" /></a>
					<div class="pad clearfix">
						<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
" class="title clearfix" title="<?php echo $this->_tpl_vars['article']['title']; ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a>
						<span class="flLeft">by <?php echo $this->_tpl_vars['article']['username']; ?>
</span><span class="flRight clearfix"><b><?php echo ((is_array($_tmp=@$this->_tpl_vars['article']['page_view'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</b> view</span>
					</div>
			</li>
			<?php endforeach; endif; unset($_from); ?>
			<!-- <li><a href="#" class="clearfix"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/ex_img2.jpg" alt="Image 1" /></a>
					<div class="pad clearfix">
						<a href="#" class="title clearfix">中国で飼われている犬がヤバイ・・・2行まで2行まで2行まで</a>
						<span class="flLeft">by PECO</span><span class="flRight clearfix"><b>2014</b> view</span>
					</div>
			</li> -->
		</ul>
	</div>
</section>
<div id="wrap" class="clearfix">
	<div class="inner1000 magT20 clearfix ">
		<div id="main">
			<!--Begin nav-->
			<nav id="left_nav">
				<ul>
					<li class="current"><a href="">注目</a></li>
					<?php $_from = $this->_tpl_vars['arrListTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['topic']):
?>
					<?php if ($this->_tpl_vars['k'] < 10): ?>
					<li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_topic($this->_tpl_vars['topic']); ?>
"><?php echo $this->_tpl_vars['topic']['name']; ?>
</a></li>
					<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</nav>
			<!--End nav-->
			<!--Begin content-->
			<div id="content">
				<div class="headline padT10 clearfix"><h2>注目まとめ</h2><p><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y.%m.%d %a") : smarty_modifier_date_format($_tmp, "%Y.%m.%d %a")); ?>
</p></div>
				<!--Begin Post Listing-->
				<div class="post_list" id="home_post_list">
						<?php $_from = $this->_tpl_vars['arrListArticles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['article']):
?>
						<!--Begin One Post-->
						<div class="one_post clearfix">
							<div class="thumb"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
"><img src="<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" alt="" class="img"/></a></div>
							<div class="text">
								<p class="post_title clearfix"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_postdetail($this->_tpl_vars['article']['id']); ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a></p>
								<p class="post_lead clearfix"><?php echo ((is_array($_tmp=$this->_tpl_vars['article']['detail'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 76, '..') : smarty_modifier_mb_truncate($_tmp, 76, '..')); ?>
</p>
								<span class="flLeft">by <?php echo $this->_tpl_vars['article']['username']; ?>
</span><span class="flRight clearfix"><b><?php echo ((is_array($_tmp=@$this->_tpl_vars['article']['page_view'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</b> view</span>
							</div>
						</div>
						<!--End One Post-->
						<?php endforeach; endif; unset($_from); ?>
				</div>
				<!--End Post Listing-->
				<div class="pagination">
					<ul>
					<?php echo $this->_tpl_vars['clsPaging']->showPagingNew2(); ?>

					</ul>
				</div>
			</div>
			<!--End content-->
		</div>
		<div id="sidebar">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_sidebar.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	</div>
</div>