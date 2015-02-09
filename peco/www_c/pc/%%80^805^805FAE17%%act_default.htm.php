<?php /* Smarty version 2.6.19, created on 2015-02-02 08:23:27
         compiled from account/act_default.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'account/act_default.htm', 42, false),array('modifier', 'date_format', 'account/act_default.htm', 44, false),)), $this); ?>
<section id="topBar">
  <div class="inner1000 clearfix">
    <ul class="breadcrumb">
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a itemprop="url" href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
"><span itemprop="title">トップページ</span></a></li>
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a itemprop="url" href="<?php echo $this->_tpl_vars['clsRewrite']->url_mypage(); ?>
"><span itemprop="title"><?php echo $this->_tpl_vars['core']->_USER['name']; ?>
</span></a></li>
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><strong itemprop="title">マイページ</strong></li>
    </ul>
  </div>
	<?php $this->assign('current_user_name', $this->_tpl_vars['core']->_USER['name']); ?>
</section>
<div id="wrap" class="clearfix">
	<div class="inner1000 magT20 clearfix">
		<div id="main">
			<!--Begin main-->
			<div class="userdata clearfix">
				<img class="avatar" src="<?php if ($this->_tpl_vars['core']->_USER['icon'] != ""): ?><?php echo $this->_tpl_vars['URL_ICON']; ?>
/<?php echo $this->_tpl_vars['core']->_USER['icon']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage_person.png<?php endif; ?>" alt="Avatar">
				<h1 class="account_name"><?php echo $this->_tpl_vars['core']->_USER['name']; ?>
</h1>
				<ul class="stats_data clearfix">
          <li class="view">閲覧数：<span>0</span></li>
          <li class="like">お気に入られ数：<span>0</span></li>
        </ul>
				<p class="link_setting">
				<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_setting(); ?>
">&raquo; プロフィールを編集する</a>
				</p>
			</div>
			<ul class="tab-common">
				<li class="active"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_mypage(); ?>
"><span>まとめ</span><span class="badge-num"><?php echo $this->_tpl_vars['totalItem']; ?>
</span></a></li>
				<li class=""><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_favorites($this->_tpl_vars['current_user_name']); ?>
"><span>お気に入り</span><span class="badge-num">0</span></a></li>
			</ul>
			<h2 class="h2 clearfix">作ったまとめ <p>お気に入られ数</p><p>閲覧数</p></h2>
			<table id="createList">
			<tbody>
				<?php $_from = $this->_tpl_vars['arrListArticles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['article']):
?>
					<tr>
						<td class="listThumb">
								<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_addID($this->_tpl_vars['article']['id']); ?>
">
									<img width="60" height="60" src="<?php if ($this->_tpl_vars['article']['thumbnail_path'] != ''): ?><?php echo $this->_tpl_vars['URL_ARTICLES']; ?>
/<?php echo $this->_tpl_vars['article']['thumbnail_path']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" class="crop_image" alt="<?php echo $this->_tpl_vars['article']['title']; ?>
">
								</a>
						</td>
						<td class="listMain">
							<p class="listTitle" style="margin:0px">
									<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_addID($this->_tpl_vars['article']['id']); ?>
"><?php echo ((is_array($_tmp=@$this->_tpl_vars['article']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, "タイトルを入力してください (下書き)") : smarty_modifier_default($_tmp, "タイトルを入力してください (下書き)")); ?>
</a>
							</p>
							<p class="listEditInline">更新：<?php echo ((is_array($_tmp=$this->_tpl_vars['article']['published_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y年%m月%d日") : smarty_modifier_date_format($_tmp, "%Y年%m月%d日")); ?>
</p>
								<a rel="nofollow" data-method="delete" data-confirm="本当に削除してよろしいですか？" class="listEdit" href="">削除する</a>
						</td>
						<td class="listView">1</td>
						<td class="listLike"><span>0</span></td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>		
			</tbody>
			</table>
			<!--End main-->
			<div class="pagination">
				<ul>
				<?php echo $this->_tpl_vars['clsPaging']->showPagingNew2(); ?>

				</ul>
			</div>
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