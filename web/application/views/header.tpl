<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<title>{if $title!=""}{$title}{else}{$DATA.title|upper}{/if}</title>
    <style type="text/css" media="all">@import "/css/style.css";</style>
	<script type="text/javascript" src="/js/swfobject.js"></script>
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>

<div id="header">
<ul id="globalnav">
	<li id="nav_home"><a href="{$DOCROOT}/">HOME</a></li>
	<li id="nav_log"><a href="{$DOCROOT}/logbook">Log Book</a></li>
	<li id="nav_report"><a href="{$DOCROOT}/reports">Reports</a></li>

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
