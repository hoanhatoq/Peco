<?php /* Smarty version 2.6.19, created on 2015-02-03 07:44:28
         compiled from _login/index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '_login/index.html', 13, false),)), $this); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login | PECO Control Panel</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['ADMIN_URL_CSS']; ?>
/login.css" />
</head>
<body>
<div class="container">
  <header>
    <h1>Admin Area <strong>PECO</strong> <sup>&copy;<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</sup></h1>
		<nav class="codrops-demos">
			<a href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
/admin">Login here</a>
		</nav>
  </header>
  <section class="main">		
		<?php if ($this->_tpl_vars['isValid'] == 0): ?>
		<div style="text-align:center; color:red">Login fail, please try again!</div>			
		<?php endif; ?>
    <form class="form-3" action="" method="post" name="frmLogin" id="frmLogin">						
      <p class="clearfix">
        <label for="txtUsername">ユーザー名</label>
        <input type="text" name="txtUsername" id="txtUsername" placeholder="英数字およびアンダーバーで入力" value="<?php echo $this->_tpl_vars['txtUsername']; ?>
" maxlength="32">
      </p>
      <p class="clearfix">
        <label for="txtPassword">パスワード</label>
        <input type="password" name="txtPassword" id="txtPassword" placeholder="半角6文字以上" value="<?php echo $this->_tpl_vars['txtPassword']; ?>
" autocomplete='off'>
      </p>
      <p class="clearfix">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">ログイン状態を保存</label>
      </p>
      <p class="clearfix">
        <input type="submit" name="btnLogin_x" value="ログインする">
      </p>
    </form>
  </section>
</div>
<script>document.frmLogin.txtUsername.focus();</script>
</body>
</html>