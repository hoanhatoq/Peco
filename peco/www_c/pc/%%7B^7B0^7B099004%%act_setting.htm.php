<?php /* Smarty version 2.6.19, created on 2015-02-02 08:18:53
         compiled from account/act_setting.htm */ ?>
<section id="topBar">
  <div class="inner1000 clearfix">
    <ul class="breadcrumb">
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a itemprop="url" href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
"><span itemprop="title">トップページ</span></a></li>
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a itemprop="url" href="<?php echo $this->_tpl_vars['clsRewrite']->url_mypage(); ?>
"><span itemprop="title"><?php echo $this->_tpl_vars['core']->_USER['name']; ?>
さんのマイページ</span></a></li>
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><strong itemprop="title">アカウント情報の編集</strong></li>
    </ul>
  </div>
	<?php $this->assign('current_user_name', $this->_tpl_vars['core']->_USER['name']); ?>
</section>
<div id="wrap" class="clearfix">
	<div class="inner1000 magT20 clearfix">
		<div id="main">
			<!--Begin main-->
			<h2 class="h2 clearfix">プロフィールを編集する</h2>
			<div class="edit_user">
				<form action="" method="post" id="fSetting" accept-charset="UTF-8" enctype="multipart/form-data">
				<div class="field">
					<label for="email">メールアドレス</label>
					<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['core']->_USER['id']; ?>
" />
					<input type="hidden" name="old_email" value="<?php echo $this->_tpl_vars['core']->_USER['email']; ?>
" />
					<input type="text" value="<?php echo $_POST['email']; ?>
" size="30" placeholder="メールアドレス" name="email" id="email">
					<?php if ($this->_tpl_vars['errors']['email'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['email']; ?>
</span><?php endif; ?>
				</div>
				<div class="field">
					<label>プロフィール画像</label>
					<img width="120" height="120" src="<?php if ($_POST['icon1']): ?><?php echo $this->_tpl_vars['URL_ICON']; ?>
/<?php echo $_POST['icon1']; ?>
<?php else: ?><?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/noimage_person.png<?php endif; ?>" alt="Avatar" id="pre_avatar">
					<input type="file" name="icon" id="icon" onChange="setPreviewAvatar(this, 'pre_avatar');" >
					<?php if ($this->_tpl_vars['errors']['icon'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['icon']; ?>
</span><?php endif; ?>
				</div>
				<div class="field">
					<label for="account_name">アカウント名</label>
					<input type="text" value="<?php echo $_POST['account_name']; ?>
" size="30" placeholder="日本語も使えます" name="account_name" id="account_name">
					<?php if ($this->_tpl_vars['errors']['account_name'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['account_name']; ?>
</span><?php endif; ?>
				</div>
				<div class="field">
					<label for="introduction">自己紹介</label>
					<textarea rows="10" placeholder="自己紹介を入力してください（500字以内）" name="introduction" id="introduction" cols="40"><?php echo $_POST['introduction']; ?>
</textarea>
					<?php if ($this->_tpl_vars['errors']['introduction'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['introduction']; ?>
</span><?php endif; ?>
				</div>
				<div class="field">
					<label for="introduction_url">外部サイトURL</label>
					<input type="text" value="<?php echo $_POST['introduction_url']; ?>
" size="30" placeholder="facebook、twitter、アメブロ、ご自分のホームページなどのURL" name="introduction_url" id="introduction_url">
					<?php if ($this->_tpl_vars['errors']['introduction_url'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['introduction_url']; ?>
</span><?php endif; ?>
				</div>
				<button type="submit" name="btnSubmit" value="Setting" class="btn-primary-red btn-large magB10">ログインする</button>
				<!-- <hr class="magB20" />	
				<button type="submit" name="btnSubmit" value="Withdraw" class="btn-primary-grey btn-large magB10">アカウントの削除</button> -->
				</form>
			</div>
			<!--End main-->
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