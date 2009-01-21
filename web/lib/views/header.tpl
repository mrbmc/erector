<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
	<title>Erector: {if $title!=""}{$title}{else}{$DATA.title|upper}{/if}</title>
    <style type="text/css" media="all">@import "./css/style.css";</style>
	<script type="text/javascript" language="Javascript" src="./js/swfobject.js"></script>
</head>
<body><a name="top" id="top"></a>

<div id="header">
<ul id="globalnav">
	<li id="nav_home"><a href="{$DOCROOT}/">HOME</a></li>
{if $smarty.session.user_id > 0}
	<li id="nav_logout"><a href="{$DOCROOT}/login/logout">Log out</a></li>
{else}
	<li id="nav_login"><a href="{$DOCROOT}/login">Log in</a></li>
	<li id="nav_register"><a href="{$DOCROOT}/register">Register</a></li>
{/if}
</ul>
</div>

<div id="body">
