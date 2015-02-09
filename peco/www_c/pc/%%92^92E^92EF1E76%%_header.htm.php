<?php /* Smarty version 2.6.19, created on 2015-02-02 08:06:31
         compiled from _header.htm */ ?>
<header id="header">
	<div class="inner1000 clearfix">
			<h1 class="logo"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_home(); ?>
" title="PECO [メリー]"><img alt="PECO [メリー]" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/logo.png"></a></h1>
			<form method="get" id="fSearch" class="search_form" action="" accept-charset="UTF-8">
				<input type="text" placeholder="大好きなペットを探そう！" name="q" id="q" class="query"><input type="submit" value="" class="submit">
			</form>
			<?php if ($this->_tpl_vars['core']->isLoggedIn() == 1): ?>
			<ul class="top_nav clearfix">
				<li>
					<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_mypage(); ?>
">
						<img width="20" height="20" src="<?php if ($this->_tpl_vars['core']->_USER['icon'] != ""): ?><?php echo $this->_tpl_vars['URL_ICON']; ?>
/<?php echo $this->_tpl_vars['core']->_USER['icon']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage_person.png<?php endif; ?>" alt="Noimage_person" class="img">
						<?php echo $this->_tpl_vars['core']->_USER['name']; ?>

					</a>
				</li>
				<li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_createpost(); ?>
">まとめを作る</a></li>
				<li><a href="javascript:void(0);" onclick="return toggleSetting();">設定</a>
					<ul class="nav_sub" id="nav_sub_setting">
						<li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_setting(); ?>
">プロフィール編集</a></li>
						<li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_logout(); ?>
">ログアウト</a></li>
					</ul>
				</li>
			</ul>
			<?php else: ?>
			<ul id="non_login_user_header_menu" class="top_nav clearfix">
        <li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_createpost(); ?>
">まとめを作る</a></li>
        <li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_signup(); ?>
">無料会員登録</a></li>
        <li><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_signin(); ?>
">ログイン</a></li>
      </ul>
			<?php endif; ?>
	</div>
</header>