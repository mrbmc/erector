
<form name="userForm" id="userForm" action="{$DOCROOT}/pitch" method="POST" enctype="multipart/form-data">

	<input type="hidden" name="do" value="save" />
	<input type="hidden" name="pitchid" value="{$DATA.pitches.pitchid}" />
	<input type="hidden" name="userid" value="{$DATA.user.userid}" />

	<p style="padding-bottom:0;font-weight:bold;">Brief</p>
	<fieldset>
	<p>
		<label></label>
		<span class="input">
			<strong><a href="{$DOCROOT}/assignments/{$DATA.pitches.brief.briefid}" class="link">{$DATA.pitches.brief.title}</a></strong><br />
			<strong>{$DATA.pitches.brief.client}</strong>
		</span>
		<span class="status"></span>
	</p>		
	</fieldset>
	
	<p style="padding-bottom:0;font-weight:bold;">Author</p>
	<fieldset>
	<p>
		<label></label>
		<span class="input">
			<strong><a href="{$DOCROOT}/admin/users/{$DATA.pitches.user.userid}" class="link">{$DATA.pitches.user.username}</a></strong><br />
		</span>
		<span class="status"></span>
	</p>		
	</fieldset>
	
	<p style="padding-bottom:0;font-weight:bold;">Your Pitch</p>
	<fieldset>
	<p>
		<label>Pitch Title</label>
		<span class="input">{$DATA.pitches.title}</span>
		<span class="status" style="clear:right;"></span>
	</p>

	<p>
		<label>Your Big Idea</label>
		<span class="input">{$DATA.pitches.body}</span>
		<span class="status" style="clear:right;"></span>
	</p>

	<p>
		<label>status</label>
		<span class="input">
		<input type="radio" name="status" value="pending"{if $DATA.pitches.status eq "pending"} checked{/if} /> pending<br />
		<input type="radio" name="status" value="active"{if $DATA.pitches.status eq "active"} checked{/if} /> active<br />
		<input type="radio" name="status" value="denied"{if $DATA.pitches.status eq "denied"} checked{/if} /> denied<br />
		</span>
	</p>
	<p>
		<label>Rating</label>
		<span class="input">
		<input type="radio" name="rating" value="1"{if $DATA.pitches.rating eq "1"} checked{/if} /> 1
		<input type="radio" name="rating" value="2"{if $DATA.pitches.rating eq "2"} checked{/if} /> 2
		<input type="radio" name="rating" value="3"{if $DATA.pitches.rating eq "3"} checked{/if} /> 3
		<input type="radio" name="rating" value="4"{if $DATA.pitches.rating eq "4"} checked{/if} /> 4
		<input type="radio" name="rating" value="5"{if $DATA.pitches.rating eq "5"} checked{/if} /> 5
		</span>
		<span class="status" style="clear:right;"></span>
	</p>

	</fieldset>

	<p style="padding-bottom:0;font-weight:bold;">Supporting Assets</p>
	<fieldset>
	{foreach from=$DATA.pitches.assets item=asset}
		<p><label></label><span><a href="http://studios.edelman.com{$asset.path}" target="_blank">{$asset.filename}</a></span></p>
	{/foreach}
	{foreach from=$DATA.pitches.urls item=asset}
		<p><label></label><span><a href="{$asset}" target="_blank">{$asset}</a></span></p>
	{/foreach}
	</fieldset>

	<fieldset>
		<label></label>
		<p><input type="submit" value="Submit" /></p>
	</fieldset>

	</form>


