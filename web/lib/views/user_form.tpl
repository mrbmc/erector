<script type="text/javascript" src="/js/jquery.validation.js"></script> 
{literal}<script type="text/javascript">/*<![CDATA[*/
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#userForm").validate({
		rules: {
			password_old: {
				required: "#password_new:filled",
				remote: "/profile/validate_pw/"
			},
			password_new: {
				minlength: 5
			},
			password_confirm: {
				minlength: 5,
				equalTo: "#password_new"
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			password_new: {
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
 
<form method="POST" action="/profile/update/" name="userForm" id="userForm">
<input type="hidden" name="userid" value="{$DATA.user.id}" />

<fieldset>
<legend>User Info</legend>
<div>
	<label for="first_name">First Name</label>
	<span><input type="text" name="first_name" value="{$DATA.user.first_name}" /></span>
	<span class="status"></span>
</div>
<div>
	<label for="last_name">Last Name</label>
	<span><input type="text" name="last_name" value="{$DATA.user.last_name}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Email</label>
	<span><input type="text" name="email" value="{$DATA.user.email}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Phone</label>
	<span><input type="text" name="phone" value="{$DATA.user.phone}" /></span>
	<span class="status"></span>
</div>
</fieldset>


<fieldset>
	<legend>Account Info</legend>
<div>
	<label>Username</label>
	<span><input type="text" name="username" value="{$DATA.user.username}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Current Password</label>
	<span><input type="password" id="password_old" name="password_old" value="" /></span>
	<span class="status"></span>
</div>
<div>
	<label>New Password</label>
	<span><input type="password" id="password_new" name="password_new" value="" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Confirm Password</label>
	<span><input type="password" id="password_confirm" name="password_confirm" value="" /></span>
	<span class="status"></span>
</div>
</fieldset>


<fieldset>
<legend ACCESSKEY="b">Contact Info</legend>
<div>
	<label>Phone</label>
	<span><input type="text" name="phone" value="{$DATA.user.phone}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Address</label>
	<span><input type="text" name="address" value="{$DATA.user.address}" /></span>
	<label>&nbsp;</label><span><input type="text" name="address_2" value="{$DATA.user.address_2}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>City</label>
	<span><input type="text" name="city" value="{$DATA.user.city}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>State</label>
	<span><input type="text" name="state" value="{$DATA.user.state}" /></span>
	<span class="status"></span>
</div>
<div>
	<label>Zipcode</label>
	<span><input type="text" name="zipcode" value="{$DATA.user.zipcode}" /></span>
	<span class="status"></span>
</div>
</fieldset>

<fieldset>
	<legend>Action</legend>
<div align="center">
	<input type="submit" value="save" />
	<input type="button" value="revert" onclick="document.location.href='';"/>
</div>
</fieldset>

</form>
