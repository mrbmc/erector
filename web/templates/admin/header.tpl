<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Admin :: {$DATA.title|lower|capitalize}</title>
	<style type="text/css" media="all" >@import "{$DOCROOT}/code/css/admin.css";</style>
	<script type="text/javascript" src="{$DOCROOT}/code/js/jquery.js"></script>
</head>
<body>
<div id="wrapper">


		<!-- header -->
		<div id="header">
			<h1 class="logo"><a href="{$DOCROOT}/">Homepage</a></h1>
			<!-- navigation -->
			<ul id="globalnav">
				<li><a{if $DATA.title eq 'Studio Assignments'} class="active"{/if} href="{$DOCROOT}/admin">home</a></li>
				<li><a{if $DATA.title|lower eq 'news'} class="active"{/if} href="{$DOCROOT}/admin/users">users</a></li>
				<li><a{if $DATA.title|lower eq 'about'} class="active"{/if} href="{$DOCROOT}/admin/news">news</a></li>
				{if $smarty.session.userid > 0}<li><a href="{$DOCROOT}/logout" class="login">Log-out</a></li>{/if}
			</ul>
		</div>

		<div id="body">
		