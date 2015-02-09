<?php /* Smarty version 2.6.19, created on 2015-02-03 07:44:34
         compiled from _header.html */ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td style="padding:0px" bgcolor="#666666">
	<table cellpadding="0" cellspacing="3" border="0" >
	<tr>
		<td class="menubutton" id="m1" nowrap width="" onmouseover="this.className='menubuttonActive';" onmouseout="this.className='menubutton';" onclick="gotoUrl('?')" title="Dashboard"><img src="<?php echo $this->_tpl_vars['ADMIN_URL_IMAGES']; ?>
/adm2.png" border="0" align="left">&nbsp;</td>				

		<?php echo $this->_tpl_vars['clsCP']->showNaviHeader(); ?>

		
		<td class="menubutton" nowrap width="" onmouseover="this.className='menubuttonActive';" onmouseout="this.className='menubutton';" onclick="return logout()"><img src="<?php echo $this->_tpl_vars['ADMIN_URL_IMAGES']; ?>
/close.png" border="0" align="left" />&nbsp;<?php echo $this->_tpl_vars['core']->getLang('Log_Out'); ?>
</td>	
	</tr>
	</table>
	</td>
	<td bgcolor="#666666" align="right">
	<a href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
" target="_blank" title="PECO's Homepage"><img src="<?php echo $this->_tpl_vars['ADMIN_URL_IMAGES']; ?>
/logo.png"/>&nbsp;&nbsp;</a>
	</td>
</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-bottom:#999999 1px solid">
<tr>
	<td class="navi" style="text-transform:uppercase">
	<img src="<?php echo $this->_tpl_vars['ADMIN_URL_IMAGES']; ?>
/icon_cms.png" border="0" align="absmiddle"><b>PECO ADMIN CONTROL PANEL</b>	
	</td>
	<td class="navi" align="right"><?php echo $this->_tpl_vars['core']->getLang('Welcome_To'); ?>
 <b><?php echo $this->_tpl_vars['core']->_USER['username']; ?>
</b>!</font></td>
</tr>
</table>
<?php echo $this->_tpl_vars['clsCP']->showDivHeader('users'); ?>

<?php echo $this->_tpl_vars['clsCP']->showDivHeader('articles'); ?>

<?php echo $this->_tpl_vars['clsCP']->showDivHeader('pickup'); ?>

<?php echo $this->_tpl_vars['clsCP']->showDivHeader('topics'); ?>

<?php echo $this->_tpl_vars['clsCP']->showDivHeader('features'); ?>

<?php echo $this->_tpl_vars['clsCP']->showDivHeader('category'); ?>
