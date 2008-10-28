<div class="login" style="width: 230px; float: right;">

{if $DATA.user.user_status eq "pending"}
	<div>
		<p>You must confirm your account before you can log in. Check your email for your confirmation code.
	</div>
{/if}

{if $smarty.session.user_id <= 0}
	<h3>Member Sign in</h3>
	<form method="post" action="{$DOCROOT}/login">
	{if $DATA.user.user_confirmation}<input type="hidden" name="confirm_code" value="{$DATA.user.user_confirmation}" />{/if}
	<input type="hidden" name="referer" value="{$smarty.server.HTTP_REFERER}" />
	<div class="form">
		<label for="username">Member Name:</label>
		<input type="text" id="username" name="username" class="text" />
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" class="text" />
		<input type="submit" class="submit button" name="btnSubmit" value="Log In" />
		<a href="{$DOCROOT}/pw_reminder" class="link">forgot your password?</a>
	</div>
	<h3>Not a Member?</h3>
	<div>
		<a href="{$DOCROOT}/register"><input type="button" class="button" name="btnRegister" value="Register" /></a>
	</div>
	</form>
{else}
	<h3>Welcome {$DATA.user.user_username}</h3>
	<div class="form">
		<a href="profile" class="link">Edit your profile</a>
	</div>
{/if}
</div>
<br clear="all" />