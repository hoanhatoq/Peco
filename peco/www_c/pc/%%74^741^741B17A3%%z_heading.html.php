<?php /* Smarty version 2.6.19, created on 2015-02-02 10:13:13
         compiled from components/z_heading.html */ ?>
<div data-item-id="<?php echo $this->_tpl_vars['articleItemId']; ?>
" class="article_content" id="item<?php echo $this->_tpl_vars['articleItemId']; ?>
">
<?php if ($this->_tpl_vars['headingText'] != ""): ?>
<h2 id="articleHeading" class="articleHeading" style="border-bottom-color:<?php echo $this->_tpl_vars['headingColor']; ?>
"><?php echo $this->_tpl_vars['headingText']; ?>
</h2>
<?php else: ?>
<h3 id="articleSubHeading" class="articleSubHeading">
	<span style="color:<?php echo $this->_tpl_vars['headingColor']; ?>
">■</span><?php echo $this->_tpl_vars['subHeadingText']; ?>

</h3>
<?php endif; ?>
</div>