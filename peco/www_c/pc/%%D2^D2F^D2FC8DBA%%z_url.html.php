<?php /* Smarty version 2.6.19, created on 2015-02-02 11:04:42
         compiled from components/z_url.html */ ?>
<div data-item-id="<?php echo $this->_tpl_vars['articleItemId']; ?>
" class="article_content clearfix" id="item<?php echo $this->_tpl_vars['articleItemId']; ?>
">

<p class="link">
	<a href="<?php echo $this->_tpl_vars['siteTitleTarget']; ?>
" target="_blank"><?php echo $this->_tpl_vars['siteTitle']; ?>
</a>
</p>
<p class="ref clearfix">
<?php if ($this->_tpl_vars['siteThumb'] != ""): ?>
<a target="_blank" href="<?php echo $this->_tpl_vars['siteThumbTarget']; ?>
">
	<img src="<?php echo $this->_tpl_vars['siteThumb']; ?>
" width="150" align="left" style="margin-right:10px">
</a>
<?php endif; ?>
<?php echo $this->_tpl_vars['siteDesc']; ?>

</p>
<p class="text"><?php echo $this->_tpl_vars['siteComment']; ?>
</p>

</div>