<?php /* Smarty version 2.6.19, created on 2015-02-02 08:06:31
         compiled from index.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'index.htm', 5, false),)), $this); ?>
<!DOCTYPE html>
<html lang="ja-JP">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<meta charset="UTF-8">
<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['site_title'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['core']->getLang('PECOPECO')) : smarty_modifier_default($_tmp, @$this->_tpl_vars['core']->getLang('PECOPECO'))); ?>
</title>
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="<?php echo $this->_tpl_vars['meta_description']; ?>
">
<meta name="keywords" content="<?php echo $this->_tpl_vars['meta_keywords']; ?>
" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/jquery-ui.css" media="all"> 	
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/style.css" media="all">
<link rel="author" href="<?php echo $this->_tpl_vars['URL_CMS']; ?>
">
<!-- Open Graph protocol -->
<meta property="og:title" content="<?php echo ((is_array($_tmp=@$this->_tpl_vars['og']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, 'PECO [ペコ]') : smarty_modifier_default($_tmp, 'PECO [ペコ]')); ?>
">
<meta property="og:description" content="<?php echo $this->_tpl_vars['og']['description']; ?>
">
<meta property="og:url" content="<?php echo $this->_tpl_vars['og']['url']; ?>
">
<meta property="og:image" content="<?php echo $this->_tpl_vars['og']['image']; ?>
">
<meta property="og:type" content="<?php echo ((is_array($_tmp=@$this->_tpl_vars['og']['type'])) ? $this->_run_mod_handler('default', true, $_tmp, 'website') : smarty_modifier_default($_tmp, 'website')); ?>
">
<meta property="og:site_name" content="<?php echo ((is_array($_tmp=@$this->_tpl_vars['og']['site_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'PECO [ペコ]') : smarty_modifier_default($_tmp, 'PECO [ペコ]')); ?>
">
<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<script>var URL_CMS = "<?php echo $this->_tpl_vars['URL_CMS']; ?>
";</script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/startup.js"></script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/index.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>