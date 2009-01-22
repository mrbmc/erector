{include file='header.tpl' title='Sign Up'}

<h1>Sign Up</h1>



<script type="text/javascript" src="/js/jquery.validation.js"></script> 
{literal}<script type="text/javascript">/*<![CDATA[*/
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#userForm").validate({
		rules: {
			username: {
				required: true,
				minlength: 5,
				remote: "/profile/unique_username/"
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
				remote: "/profile/unique_email/"
			},
			captcha: {
				required: true,
				remote: "/profile/captcha/"
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
			terms: "You must agree to the terms",
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

	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var first_name = $("#first_name").val();
		var last_name = $("#last_name").val();
		if(first_name && last_name && !this.value) {
			this.value = first_name + "." + last_name;
		}
	});
});
/*]]>*/</script>{/literal}
 
<form method="POST" action="/profile/create/" name="userForm" id="userForm">
<fieldset>
<legend>User Info</legend>
<div>
	<label>Username</label>
	<span><input type="text" name="username" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Email</label>
	<span><input type="text" name="email" /></span>
	<span class="status"></span>
</div>

<div>
	<label>Password</label>
	<span><input type="password" id="password" name="password_new" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Confirm Password</label>
	<span><input type="password" id="password_confirm" name="password_confirm" /></span>
	<span class="status"></span>
</div>
</fieldset>


<fieldset>
<div>
	<label>Are you human</label>
	<span><img src="/captcha/?width=150&height=50" /></span>
	<div class="clear"></div>
	<label>&nbsp;</label>
	<span><input type="text" name="captcha" /></span>
	<span class="status"></span> 

</div>
<div>
	<label>Email updates</label> 
	<span><input type="checkbox" id="newsletter" name="newsletter" value="true" checked="true" /></span> 
	<span class="status"></span> 
</div>
</fieldset>

<fieldset>
<div>
	<label></label>
	<span><input alt="I accept. Create my account." class="green-continue-button" id="user_create_submit" name="commit" onclick="this.disabled=true,this.form.submit();" tabindex="7" type="submit" value="Create my account" /></span>
</div>
</fieldset>

</form>




{include file='footer.tpl'}