					<div class="box">

{if $DATA.user.status eq "pending"}
					<div>
						<p>You must confirm your account before you can log in. Check your email for your confirmation code.
					</div>
{/if}

{if $smarty.session.userid <= 0}
						<h3>Member Sign in</h3>
						<form method="post" action="{$DOCROOT}/login">
							{if $DATA.confirm_code}<input type="hidden" name="confirm_code" value="{$DATA.confirm_code}" />{/if}
							{if $referer}<input type="hidden" name="referer" value="{$smarty.server.HTTP_REFERER}" />{/if}
							<div class="form">
								<label for="username">Member Name:</label>
								<input type="text" id="username" name="username" class="text" />
								<label for="password">Password:</label>
								<input type="password" id="password" name="password" class="text" />
								<input type="image" src="{$DOCROOT}/images/psd2html/btn-login.gif" class="btn" />
								<a href="{$DOCROOT}/pw_reminder" class="link">forgot your password?</a>
							</div>
							<h3>Not a Member?</h3>
							<div>
								<a href="{$DOCROOT}/register"><img src="{$DOCROOT}/images/psd2html/btn-register-now.gif" class="reg-btn" alt="Register" /></a>
							</div>
						</form>
{else}
						<h3>Welcome {$DATA.user.username}</h3>
						<div class="form">
							<a href="profile" class="link">Edit your profile</a>
						</div>
{/if}
					</div>
