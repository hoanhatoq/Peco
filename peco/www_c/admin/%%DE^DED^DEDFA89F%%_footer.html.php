<?php /* Smarty version 2.6.19, created on 2015-02-03 07:44:34
         compiled from _footer.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '_footer.html', 5, false),)), $this); ?>
<div id="footer">
<table width="100%" cellpadding="5" cellspacing="0" border="0">
<tr>
	<td class="footer" align="left">
	&copy; 2014-<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y') : smarty_modifier_date_format($_tmp, '%Y')); ?>
 Copyright by PECO.,
	</td>
	<td class="footer" align="right">[Your IP:<?php echo $this->_tpl_vars['core']->_REMOTE_ADDR; ?>
]&nbsp;</td>
</tr>
</table>
</div>