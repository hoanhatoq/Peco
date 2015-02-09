<?php /* Smarty version 2.6.19, created on 2015-02-02 11:33:38
         compiled from components/z_video.html */ ?>
<div data-item-id="<?php echo $this->_tpl_vars['articleItemId']; ?>
" class="article_content" id="item<?php echo $this->_tpl_vars['articleItemId']; ?>
">
	
	<iframe id="articleVideoEmmbed" type="text/html" src="<?php echo $this->_tpl_vars['videoEmbed']; ?>
" width="480" height="360" frameborder="0" allowfullscreen="true"></iframe>
	<p class="ref">
		出典： <a class="articleVideoSourceView" href="<?php echo $this->_tpl_vars['videoSourceTarget']; ?>
" target="_blank">Youtube</a>
	</p>
	<h2 class="magT10"><?php echo $this->_tpl_vars['videoTitle']; ?>
</h2>
	<p class="article_text"><?php echo $this->_tpl_vars['videoComm']; ?>
</p>

</div>