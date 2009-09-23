<div id="signin_form">

{if $smarty.session.userstatus eq "pending"}
	<div>
		<p>You must confirm your account before you can log in. Check your email for your confirmation code.
	</div>
{/if}

{if $smarty.session.userid <= 0}
<form method="post" action="{$DOCROOT}/login">
	<h3>Member Sign in</h3>
	{if $DATA.user.confirmation}<input type="hidden" name="confirm_code" value="{$DATA.user.confirmation}" />{/if}
	<input type="hidden" name="referrer" value="{$smarty.server.HTTP_REFERER}" />
	<div>
		<label for="username">Username or email</label>
		<br /><input type="text" id="username" name="username" class="text" tabindex="1" />
	</div>
	<div>
		<label for="password">Password</label>
		<br /><input type="password" id="password" name="password" class="text" tabindex="1" />
		<br /><small><a href="/profile/pw_reminder">forgot your password?</a></small>
	</div>
	
	<input type="submit" class="submit button" name="btnSubmit" value="Sign In" tabindex="1" />
	
	<h3>Not a Member?</h3>
	<div>
		<a href="{$DOCROOT}/signup"><input type="button" class="button" name="btnSignup" value="Sign Up" /></a>
	</div>
</form>
{else}
	<h3>Welcome {$DATA.user.username}</h3>
	<div class="form">
		<a href="profile" class="link">Edit your profile</a>
	</div>
{/if}
</div>
<br clear="all" />