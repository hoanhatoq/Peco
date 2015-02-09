<?php /* Smarty version 2.6.19, created on 2015-02-02 08:19:26
         compiled from account/act_signin.htm */ ?>
<section id="topBar">
  <div class="inner1000 clearfix">
    <ul class="breadcrumb">
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a itemprop="url" href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
"><span itemprop="title">トップページ</span></a></li>
      <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><strong itemprop="title">ログイン</strong></li>
    </ul>
  </div>
</section>
<div id="wrap" class="clearfix">
	<div class="inner1000 clearfix">
		<div class="loginbox">
			<h2 class="magB10">ログイン</h2>
			<div class="magB20">
			<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_signin_facebook(); ?>
" class="btn-signin-facebook">Facebookでログインする</a>
			</div>
			<hr class="magB20" />
			<div class="magB20 clearfix">
				<!--Begin SigninForm-->
				<form action="" method="post" id="fLogin" accept-charset="UTF-8">
					<div class="form-input">
						<label>メールアドレス</label>
						<input type="text" placeholder="登録時に入力したメールアドレス" name="email" id="email" value="<?php echo $_POST['email']; ?>
" class="input-large input-sign" autofocus="autofocus">
						<?php if ($this->_tpl_vars['errors']['email'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['email']; ?>
</span><?php endif; ?>
					</div>
					<div class="form-input">
						<label>パスワード</label>
						<input type="password" placeholder="半角6文字以上" name="password" id="password" value="<?php echo $_POST['password']; ?>
" class="input-large input-sign" autofocus="autofocus">
						<?php if ($this->_tpl_vars['errors']['password'] != ""): ?><span class="validate_message"><?php echo $this->_tpl_vars['errors']['password']; ?>
</span><?php endif; ?>
					</div>
					<div class="form-input">
						<input type="checkbox" value="1" name="remember" id="remember" class="module-form-checkbox" checked="<?php if ($_POST['remember'] == 1): ?>checked<?php endif; ?>">
						<label for="remember" class="for-check">ログイン状態を保存</label>
					</div>
					<div class="text-right">
						<button type="submit" name="btnSubmit" value="Login" class="btn-primary-red btn-large magB10">ログインする</button>
						<br>
						<a href="<?php echo $this->_tpl_vars['clsRewrite']->url_forgot(); ?>
" rel="bookmark" title="パスワードをお忘れですか？">パスワードをお忘れですか？</a>
						<br>
					</div>
					<hr class="magB20" />
					<h2 class="magB10">アカウントをお持ちでない方</h2>
					<div class="clearfix">
						<div class="flLeft"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_signin_facebook(); ?>
" rel="nofollow" class="btn-signin-facebook">Facebookで新規登録する</a></div>
						<div class="flRight"><a href="<?php echo $this->_tpl_vars['clsRewrite']->url_signup(); ?>
" rel="nofollow" class="btn-primary-red btn-large magB10">新規登録する</a></div>
					</div>
				</form>
				<!--End SigninForm-->
			</div>
		</div>
	</div>
</div>