<?php /* Smarty version 2.6.19, created on 2015-02-03 07:44:59
         compiled from users/act_default.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_block_inner_head.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form name="theForm" action="" method="post">
<table width="100%" border="0">
<tr>
<td style="padding:10px">
	<h1 class="fleft"><?php echo $this->_tpl_vars['core']->getLang('Users_List'); ?>
</h1>
	<div class="fright">
	キーワード	<input type="text" name="s_keyword" value="<?php echo $_POST['s_keyword']; ?>
">
	ユーザーid <input type="text" name="s_user_id" value="<?php echo $_POST['s_user_id']; ?>
">
	<input type="submit" name="btnSearch" value="検索" class="button">
	</div>
</td>
</tr>
<tr>
	<td style="padding:0px 10px" width="100%" valign="top">
	<?php echo $this->_tpl_vars['clsDataGrid']->showDataGrid('theForm'); ?>

	</td>
</tr>
<tr>
	<td  style="padding:0px 10px">
	<?php echo $this->_tpl_vars['clsDataGrid']->showPaging('theForm'); ?>

	</td>
</tr>
</table>
</form>