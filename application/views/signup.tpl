{include file='header.tpl' title='Sign Up'}

<h1>Sign Up</h1>


	<script type="text/javascript" src="/js/jquery.validation.js"></script> 
	<script type="text/javascript" src="/js/passwordStrengthMeter.js"></script> 

{literal}<script type="text/javascript">/*<![CDATA[*/
$(document).ready(function() {
	$("#password").keyup(function(){
		$("#pw_status").html(passwordStrength($("#password").val(),""));
	});

	// validate signup form on keyup and submit
	var validator = $("#userForm").validate({
		rules: {
			username: {
				required: true,
				minlength: 5,
				remote: "/profile/username_unique/"
			},
			password: {
				required: true,
				minlength: 5
			},
			password_confirm: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true,
				remote: "/profile/email_unique/"
			},
			captcha: {
				required: true,
				remote: "/captcha/validate"
			}
		},
		messages: {
			username: {
				required: "Required",
				minlength: jQuery.format("Enter at least {0} characters"),
				remote: jQuery.format("{0} is already in use")
			},
			password: {
				required: "Provide a password",
				rangelength: jQuery.format("Enter at least {0} characters")
			},
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			},
			email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address",
				remote: jQuery.format("{0} is already in use")
			},
			captcha: "Please enter the code correctly"
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next().next() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.parent().next() );
			else
				error.appendTo( element.parent().next() );
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});
});

var newCaptchaImageURL = '<img src="/captcha/renew" width="150" height="50" />';

/*]]>*/</script>{/literal}
 


<form id="userForm" method="post" action="/profile/create/"> 

<fieldset>
<legend>User Info</legend>
<div>
	<label>Username</label>
	<span><input type="text" name="username" class="txtInput" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Email</label>
	<span><input type="text" name="email" class="txtInput" /></span>
	<span class="status"></span>
</div>

<div>
	<label>Password</label>
	<span><input type="password" id="password" name="password" class="txtInput" /></span>
	<span class="status" id="pw_status"></span>
</div>
<div>
	<label>Confirm Password</label>
	<span><input type="password" id="password_confirm" name="password_confirm" class="txtInput" /></span>
	<span class="status"></span>
</div>
</fieldset>


<fieldset>
<div>
	<label>Are you human</label>

	<span>
	<span id="captchaImage"><img src="/captcha" alt="captcha" width="150" height="50" /></span>
	<small><a href="javascript:void(0);" onClick="$('#captchaImage').html(newCaptchaImageURL);" /><img src="/images/captcha_renew.gif" alt="Get a new code" /></a></small>
	</span>

	<div class="clear"></div>

	<label>&nbsp;</label>
	<span><input type="text" name="captcha" class="txtInput" /></span>
	<span class="status"></span> 

</div>
<div>
	<label>Can we email you updates?</label> 
	<span><input type="checkbox" id="newsletter" name="newsletter" value="true" checked="checked" /></span> 
	<span class="status"></span> 
</div>
</fieldset>

<fieldset>
<div>
	<label></label>
	<span><input type="submit" class="button" id="user_create_submit" name="Submit" tabindex="7" value="Create my account" /></span>
</div>
</fieldset>

</form>




{include file='footer.tpl'}