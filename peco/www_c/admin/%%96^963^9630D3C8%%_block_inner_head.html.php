<?php /* Smarty version 2.6.19, created on 2015-02-03 07:44:59
         compiled from _block_inner_head.html */ ?>
<div class="inner_head_title">
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
	<?php if ($this->_tpl_vars['clsCP']->getImgSrc() != ""): ?>
	<td width="55px" style="padding:5px;">
		<a href="?mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['clsCP']->getImgSrc(); ?>
" border="0"/></a>
	</td>
	<?php else: ?>
	<td width="10px"></td>
	<?php endif; ?>
	<td><span class="title1"><?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
</span><br /><span class="title2"><?php echo $this->_tpl_vars['clsDataGrid']->getTitle2(); ?>
</span></td>
	<td style="padding:5px;" align="right">
		<?php echo $this->_tpl_vars['clsButtonNav']->render(); ?>
		
	</td>
</tr>
</table>
</div>