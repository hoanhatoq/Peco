<?php /* Smarty version 2.6.19, created on 2015-02-03 07:45:21
         compiled from users/act_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'users/act_add.html', 40, false),array('modifier', 'date_format', 'users/act_add.html', 50, false),)), $this); ?>
<?php $this->assign('span_title1', $this->_tpl_vars['core']->getLang('Users')); ?>
<?php $this->assign('span_title2', $this->_tpl_vars['core']->getLang('Users_Management')); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_block_inner_head_add.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form action="" method="post" style="padding:10px" name="theForm" id="theForm" accept-charset="UTF-8" enctype="multipart/form-data">
<h1><?php echo $this->_tpl_vars['core']->getLang('Users_Add_Edit'); ?>
</h1>
<div class="jpform fleft mgR20">
	<div class="row">
		<label>ライター名 (*)</label>
		<div class="input"><input type="text" name="name" value="<?php echo $_POST['name']; ?>
" required >
		<?php if ($this->_tpl_vars['errors']['name'] != ""): ?><div class="validate_message"><?php echo $this->_tpl_vars['errors']['name']; ?>
</div><?php endif; ?>
		</div>
	</div>
	<div class="row">
		<label>アカウント名 (*)</label>
		<div class="input"><input type="text" name="account_name" value="<?php echo $_POST['account_name']; ?>
" required >
		<?php if ($this->_tpl_vars['errors']['account_name'] != ""): ?><div class="validate_message"><?php echo $this->_tpl_vars['errors']['account_name']; ?>
</div><?php endif; ?>
		</div>
	</div>	
	<div class="row">
		<label>パスワード</label>
		<div class="input"><input type="password" name="password" value="" placeholder="<?php if ($_POST['id'] > 0): ?>Leave blank if not change<?php endif; ?>">		
		</div>
	</div>
	<div class="row">
		<label>メールアドレス (*)</label>
		<div class="input"><input type="email" name="email" value="<?php echo $_POST['email']; ?>
" required >
		<?php if ($this->_tpl_vars['errors']['email'] != ""): ?><div class="validate_message"><?php echo $this->_tpl_vars['errors']['email']; ?>
</div><?php endif; ?>
		</div>
	</div>
	<div class="row">
		<label>自己紹介文</label>
		<div class="input"><textarea name="introduction" rows="5"><?php echo $_POST['introduction']; ?>
</textarea></div>
	</div>
	<div class="row">
		<label>登録URL</label>
		<div class="input"><input type="url" name="introduction_url" value="<?php echo $_POST['introduction_url']; ?>
"></div>
	</div>	
	<div class="row">
		<label>メルマガ有無 </label>
		<div class="input"><input type="number" name="receive_email" value="<?php echo ((is_array($_tmp=@$_POST['receive_email'])) ? $this->_run_mod_handler('default', true, $_tmp, '1') : smarty_modifier_default($_tmp, '1')); ?>
"></div>
	</div>
	<div class="row">
		<label>ステータス (*)</label>
		<div class="input"><input type="number" name="is_verified" value="<?php echo $_POST['is_verified']; ?>
" required >
		<?php if ($this->_tpl_vars['errors']['is_verified'] != ""): ?><div class="validate_message"><?php echo $this->_tpl_vars['errors']['is_verified']; ?>
</div><?php endif; ?>
		</div>
	</div>
	<div class="row">
		<label>登録日日 (*)</label>
		<div class="input"><input type="date" name="created_at" value="<?php echo ((is_array($_tmp=$_POST['created_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" required ></div>
	</div>
	<div class="row">
		<label>最終更新日  (*)</label>
		<div class="input"><input type="date" name="updated_at" value="<?php echo ((is_array($_tmp=$_POST['updated_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" required ></div>
	</div>
	<div class="row">
		<label>&nbsp;</label>
		<div class="input">
		<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>
">
		<input type="hidden" name="old_name" value="<?php echo $_POST['old_name']; ?>
">
		<input type="hidden" name="old_email" value="<?php echo $_POST['old_email']; ?>
">
		<input type="hidden" name="old_account_name" value="<?php echo $_POST['account_name']; ?>
">
		<input type="hidden" name="old_icon" value="<?php echo $_POST['old_icon']; ?>
">
		<input type="hidden" name="old_password" value="<?php echo $_POST['password']; ?>
">
		<input type="submit" name="btnSave" value="&nbsp;&nbsp;&nbsp; 保存  &nbsp;&nbsp;">
		<a href="?mod=<?php echo $this->_tpl_vars['mod']; ?>
" class="button">&nbsp;&nbsp;&nbsp;キャンセル&nbsp;&nbsp;&nbsp;</a>
		</div>
	</div>
</div>
<div class="jpform fleft mgL20">
	<div class="row">		
		<div class="input">
		Avatar<br><br>
		<div style="position: relative; height:120px;">
		<div class="resizeAndCrop" style="width:120px; height:120px;"><img src="<?php if ($_POST['old_icon'] != ''): ?><?php echo $this->_tpl_vars['URL_ICON']; ?>
/<?php echo $_POST['old_icon']; ?>
<?php else: ?><?php echo $this->_tpl_vars['ADMIN_URL_IMAGES']; ?>
/noimage.png<?php endif; ?>" width="100%" height="auto" id="img_thumbnail"></div>
		</div>
		<br><br>
		<input type="file" name="icon" value="" onchange="setPreviewAvatar(this, '#img_thumbnail');">
		</div>
	</div>
</div>
<div class="clearfix"></div>
</form>
<?php echo '
<script>
$("#theForm").validate({
	submitHandler: function(form) {
		form.submit();
	}
});
</script>
'; ?>