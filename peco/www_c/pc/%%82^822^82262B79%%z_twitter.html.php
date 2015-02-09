<?php /* Smarty version 2.6.19, created on 2015-02-02 11:25:40
         compiled from components/z_twitter.html */ ?>
<div data-item-id="<?php echo $this->_tpl_vars['articleItemId']; ?>
" class="article_content" id="item<?php echo $this->_tpl_vars['articleItemId']; ?>
">
	<div class="tweet clearfix">
	  	<a target="_blank" href="javascript:void(0)">
	  		<img src="<?php echo $this->_tpl_vars['avatar']; ?>
" class="icon tweet_icon" alt="">
	  	</a>
	  	<div class="tweetInfo">
		    <a target="_blank" href="javascript:void(0)">
		      <p class="user"><?php echo $this->_tpl_vars['fullname']; ?>
<span>@<?php echo $this->_tpl_vars['username']; ?>
</span></p>
		    </a>
		    <p>
			<?php echo $this->_tpl_vars['content']; ?>

			</p>
			<p class="comment"><?php echo $this->_tpl_vars['comment']; ?>
</p>
			<?php if ($this->_tpl_vars['imgSrc'] != ""): ?>
			<a href="<?php echo $this->_tpl_vars['imgTarget']; ?>
">
			  <p class="image"><img src="<?php echo $this->_tpl_vars['imgSrc']; ?>
" class="tweet_image" alt=""></p>
			</a>
			<?php endif; ?>
			<p class="time"><?php echo $this->_tpl_vars['time']; ?>
</p>
		</div>
	</div>
</div>