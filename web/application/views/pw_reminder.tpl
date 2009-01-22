{include file='header.tpl' title='Password Reminder'}

<h1>Password Reminder</h1>

<script type="text/javascript" src="/js/jquery.validation.js"></script> 

{literal}<script type="text/javascript">/*<![CDATA[*/
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#userForm").validate({
		rules: {
			username: {
				remote: "/profile/username_exists/"
			},
			email: {
				email: true,
				remote: "/profile/email_exists/"
			}
		},
		messages: {
			username: {
				remote: jQuery.format("{0} is not in our system")
			},
			email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address",
				remote: jQuery.format("{0} is not in our system")
			}
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
/*]]>*/</script>{/literal}
 


<form id="userForm" method="post" action="/profile/send_pw/"> 

<fieldset>
<legend>User Info</legend>
<div>
	<label>Username</label>
	<span><input type="text" id="username" name="username" class="txtInput" /></span>
	<span class="status"></span>
</div>
<p><label>&nbsp;</label>OR</p>
<div>
	<label>Email</label>
	<span><input type="text" name="email" class="txtInput" /></span>
	<span class="status"></span>
</div>
<div>
	<label></label>
	<span><input type="submit" class="button" id="user_create_submit" name="Send it" tabindex="7" value="Send me my password" /></span>
</div>
</fieldset>

</form>




{include file='footer.tpl'}