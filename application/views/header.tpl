<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<title>{if $title!=""}{$title}{else}{$DATA.title|upper}{/if}</title>
	<style type="text/css" media="all">@import "/css/screen.css";</style>
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>

<div id="master">

<div id="header">
<ul class="navigation" id="globalnav">
	<li id="nav_home"><a href="{$DOCROOT}/">Home</a></li>
{if $smarty.session.userid > 0}
	<li id="nav_logout"><a href="{$DOCROOT}/login/logout">Log out</a></li>
{else}
	<li id="nav_login"><a href="{$DOCROOT}/login">Log in</a></li>
	<li id="nav_signup"><a href="{$DOCROOT}/signup">Sign Up</a></li>
{/if}
</ul>

</div>


<div id="body">
