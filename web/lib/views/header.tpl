<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
	<title>{if $title!=""}{$title}{else}{$DATA.title|upper}{/if}</title>
    <style type="text/css" media="all">@import "/css/style.css";</style>
	<script type="text/javascript" language="Javascript" src="/js/swfobject.js"></script>
	<script type="text/javascript" language="Javascript" src="/js/jquery.js"></script>
</head>
<body><a name="top" id="top"></a>

<div id="header">
<ul id="globalnav">
	<li id="nav_home"><a href="{$DOCROOT}/">HOME</a></li>
	<li id="nav_home"><a href="{$DOCROOT}/logbook">Log Book</a></li>
	<li id="nav_home"><a href="{$DOCROOT}/reports">Reports</a></li>

{if $smarty.session.userid > 0}
	<li id="nav_logout"><a href="{$DOCROOT}/login/logout">Log out</a></li>
{else}
	<li id="nav_login"><a href="{$DOCROOT}/login">Log in</a></li>
	<li id="nav_signup"><a href="{$DOCROOT}/signup">Sign Up</a></li>
{/if}
</ul>

{if $smarty.session.feedback}
<p id="feedback">{$smarty.session.feedback}</p>

{/if}
</div>


<div id="body">
