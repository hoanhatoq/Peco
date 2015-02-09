<?php /* Smarty version 2.6.19, created on 2015-02-02 08:06:34
         compiled from home/index.htm */ ?>
<?php if ($this->_tpl_vars['sub'] != 'default'): ?>
	<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/".($this->_tpl_vars['sub']).".default.htm")): ?>		
		<?php if ($this->_tpl_vars['act'] != 'default'): ?>
			<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/".($this->_tpl_vars['sub']).".".($this->_tpl_vars['act']).".htm")): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/".($this->_tpl_vars['sub']).".".($this->_tpl_vars['act']).".htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
			<?php else: ?>
				<?php $this->assign('content', "Action File not Found!"); ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notfound.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
			<?php endif; ?>
		<?php else: ?>	
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/".($this->_tpl_vars['sub']).".default.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
		<?php endif; ?>				
	<?php else: ?>
		<?php $this->assign('content', "Sub Module File not Found!"); ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notfound.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
	<?php endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['act'] != 'default'): ?>
		<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/act_".($this->_tpl_vars['act']).".htm")): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/act_".($this->_tpl_vars['act']).".htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
		<?php else: ?>
			<?php $this->assign('content', "Action File not Found!"); ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notfound.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
		<?php endif; ?>
	<?php else: ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/act_default.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php endif; ?>