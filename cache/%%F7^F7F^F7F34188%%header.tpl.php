<?php /* Smarty version 2.6.17, created on 2011-04-09 23:19:04
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'header.tpl', 4, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<title><?php if ($this->_tpl_vars['title'] != ""): ?><?php echo $this->_tpl_vars['title']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['DATA']['title'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php endif; ?></title>
	<style type="text/css" media="all">@import "/css/screen.css";</style>
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>

<div id="master">

<div id="header">
<ul class="navigation" id="globalnav">
	<li id="nav_home"><a href="<?php echo $this->_tpl_vars['DOCROOT']; ?>
/">Home</a></li>
<?php if ($_SESSION['userid'] > 0): ?>
	<li id="nav_logout"><a href="<?php echo $this->_tpl_vars['DOCROOT']; ?>
/login/logout">Log out</a></li>
<?php else: ?>
	<li id="nav_login"><a href="<?php echo $this->_tpl_vars['DOCROOT']; ?>
/login">Log in</a></li>
	<li id="nav_signup"><a href="<?php echo $this->_tpl_vars['DOCROOT']; ?>
/signup">Sign Up</a></li>
<?php endif; ?>
</ul>

</div>


<div id="body">