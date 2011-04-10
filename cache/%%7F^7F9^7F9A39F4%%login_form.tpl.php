<?php /* Smarty version 2.6.17, created on 2011-04-09 23:19:04
         compiled from login_form.tpl */ ?>
<div id="signin_form">

<?php if ($_SESSION['userstatus'] == 'pending'): ?>
	<div>
		<p>You must confirm your account before you can log in. Check your email for your confirmation code.
	</div>
<?php endif; ?>

<?php if ($_SESSION['userid'] <= 0): ?>
<form method="post" action="<?php echo $this->_tpl_vars['DOCROOT']; ?>
/login">
	<h3>Member Sign in</h3>
	<?php if ($this->_tpl_vars['DATA']['user']['confirmation']): ?><input type="hidden" name="confirm_code" value="<?php echo $this->_tpl_vars['DATA']['user']['confirmation']; ?>
" /><?php endif; ?>
	<input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>
" />
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
		<a href="<?php echo $this->_tpl_vars['DOCROOT']; ?>
/signup"><input type="button" class="button" name="btnSignup" value="Sign Up" /></a>
	</div>
</form>
<?php else: ?>
	<h3>Welcome <?php echo $this->_tpl_vars['DATA']['user']['username']; ?>
</h3>
	<div class="form">
		<a href="profile" class="link">Edit your profile</a>
	</div>
<?php endif; ?>
</div>
<br clear="all" />