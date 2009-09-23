{assign var='user' value=$DATA.users.0}
<form id="userForm" method="POST">
<input type="hidden" name="userid" value="{$user->userid}" />
<input type="hidden" name="do" id="do" value="asdf" />
<div id="user_form">

<p>
	<label></label>
	<span class="input">
		<input type="button" value="Save" onClick="document.getElementById('do').value='save';document.forms[0].submit();" />  
		<input type="button" value="Revert" onClick="document.location.href=document.location.href;" />  
		<input type="button" value="Delete" onClick="document.getElementById('do').value='delete';document.forms[0].submit();" />
	</span>
</p>

<p style="padding-bottom: 0px;"><strong>General Information</strong></p>
<fieldset> 
<p>
	<label>First Name:</label>
	<span class="input"><input type="text" id="first_name" name="first_name" value="{$user->first_name}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Last Name:</label>
	<span class="input"><input type="text" id="last_name" name="last_name" value="{$user->last_name}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Email:</label>
	<span class="input"><input type="text" id="email" name="email" value="{$user->email}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Confirmed Email:</label>
	<span class="input"><input type="button" value="Send Confirmation Code" onclick="document.location.href='/profile/{$user->userid}/?do=send_confirmation&referer=/admin/users/{$user->userid}';" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Phone Number:</label>
	<span class="input"><input type="text" id="phone" name="phone" value="{$user->phone}" class="txtInput" /></span>
	<span class="status"></span>
</p>
</fieldset> 

<p style="padding-bottom: 0px;"><strong>Username &amp; Password</strong></p>
<fieldset> 
<p>
	<label>Member Name:</label>
	<span class="input"><input type="text" id="username" name="username" value="{$user->username}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Status:</label>
	<span class="input">
	<select id="status" name="status">
	<option value="pending"{if $user->status eq 'pending'} selected{/if}>Pending</option>
	<option value="active"{if $user->status eq 'active'} selected{/if}>Active</option>
	<option value="admin"{if $user->status eq 'admin'} selected{/if}>Admin</option>
	</select>
	</span>
	<span class="status"></span>
</p>

<p>
	<label>Password:</label>
	<span class="input"><input type="button" value="Send Password Reminder" onclick="document.location.href='/profile/{$user->userid}/?do=pw_reminder&referer=/admin/users/{$user->userid}';" /></span>
	<span class="status"></span>
</p>

</fieldset> 


<p style="padding-bottom: 0px;"><strong>Contact Information</strong></p>
<fieldset> 
<p>
	<label>Street Address:</label>
	<span class="input"><input type="text" id="address" name="address" value="{$user->address}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Street Address Cont.:</label>
	<span class="input"><input type="text" id="address_2" name="address_2" value="{$user->address_2}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>City:</label>
	<span class="input"><input type="text" id="city" name="city" value="{$user->city}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>State:</label>
	<span class="input"><input type="text" id="state" name="state" value="{$user->state}" class="txtInput" /></span>
	<span class="status"></span>
</p>

<p>
	<label>Zipcode:</label>
	<span class="input"><input type="text" id="zipcode" name="zipcode" value="{$user->zipcode}" class="txtInput" /></span>
	<span class="status"></span>
</p>

</fieldset>

<p>
	<label></label>
	<span class="input">
		<input type="button" value="Save" onClick="document.getElementById('do').value='save';document.forms[0].submit();" />  
		<input type="button" value="Revert" onClick="document.location.href=document.location.href;" />  
		<input type="button" value="Delete" onClick="document.getElementById('do').value='delete';document.forms[0].submit();" />
	</span>
</p>


</div>
</form>


{include file='admin/pitch_list.tpl'}
