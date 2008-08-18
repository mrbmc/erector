<style type="text/css" media="all">@import "{$DOCROOT}/code/css/jquery.datePicker.css";</style>
<script type="text/javascript" src="{$DOCROOT}/code/js/jquery.datePicker.js"></script>
<script type="text/javascript" src="{$DOCROOT}/code/js/date.js"></script>

<script type="text/javascript">{literal}
/*<![CDATA[*/
Date.format = 'mm/dd/yyyy';
$(function()
{
	$('.date-pick').datePicker({startDate:'01/01/2008'});
	$('#startdate').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#duedate').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#duedate').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#startdate').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
	$('#startdate').val(new Date('{/literal}{$DATA.briefs.startdate|date_format:"%m/%d/%Y"}{literal}').asString()).trigger('change');
	$('#duedate').val(new Date('{/literal}{$DATA.briefs.duedate|date_format:"%m/%d/%Y"}{literal}').asString()).trigger('change');
	
});
/*]]>*/
{/literal}</script>


			<div class="content">
				<!-- column -->
				<div class="column">
					<!-- blue-promo-box -->
					<div class="white-box">


<form id="userForm" name="userForm" method="post" enctype="multipart/form-data">
<input type="hidden" name="briefid" value="{$DATA.briefs.briefid}" />
<input type="hidden" name="do" value="save" />


<p style="clear:both;"><strong>Brief Details</strong></p>
<fieldset> 
<p>
	<label>Title</label>
	<span class="input"><input type="text" name="title" value="{$DATA.briefs.title}" /></span>
</p>
<p>
	<label>client</label>
	<span class="input"><input type="text" name="client" value="{$DATA.briefs.client}" /></span>
</p>
<p>
	<label>status</label>
	<span class="input">
	<input type="radio" name="status" value="pending"{if $DATA.briefs.status eq "pending"} checked{/if} /> pending<br />
	<input type="radio" name="status" value="active"{if $DATA.briefs.status eq "active"} checked{/if} /> active<br />
	</span>
</p>
<p>
	<label>startdate</label>
	<span class="input"><input name="startdate" id="startdate" class="date-pick" value="{$DATA.briefs.startdate}" /></span>
</p>
<p>
	<label>duedate</label>
	<span class="input"><input name="duedate" id="duedate" class="date-pick" value="{$DATA.briefs.duedate}" /></span>
</p>
<br clear="all" />
<p>
	<label>keywords</label>
	<span class="input"><input type="text" name="keywords" value="{$DATA.briefs.keywords}" /></span>
</p>
<p>
	<label>Summary</label>
	<span class="input"><textarea name="summary">{$DATA.briefs.summary|stripslashes}</textarea></span>
</p>
</fieldset> 

<p style="clear:both;"><strong>Brief Summary</strong></p>
<fieldset> 
<p>
	<label>premise</label>
	<span class="input"><textarea name="premise" >{$DATA.briefs.premise|stripslashes}</textarea></span>
</p>
<p>
	<label>challenge</label>
	<span class="input"><textarea name="challenge" >{$DATA.briefs.challenge|stripslashes}</textarea></span>
</p>
<p>
	<label>assignment</label>
	<span class="input"><textarea name="assignment" >{$DATA.briefs.assignment|stripslashes}</textarea></span>
</p>
<p>
	<label>reward</label>
	<span class="input"><textarea name="reward" >{$DATA.briefs.reward|stripslashes}</textarea></span>
</p>
</fieldset> 


<p style="clear:both;"><strong>Supporting Assets</strong></p>
<fieldset> 
<p>
	<label>Client Logo</label>
	<span class="input"><input type="file" name="logofile" /></span>
	{html_image file='/images/assignments/'|cat:$DATA.briefs.briefid|cat:'/logo.gif' href='/images/assignments/'|cat:$DATA.briefs.briefid|cat:'/logo.gif' align="right" width="50" height="50"}
</p>
<p>
	<label>banner image</label>
	<span class="input"><input type="file" name="bannerfile" /></span>
	{html_image file='/images/assignments/'|cat:$DATA.briefs.briefid|cat:'/banner.jpg' href='/images/assignments/'|cat:$DATA.briefs.briefid|cat:'/banner.jpg' align="right" width="50" height="50"}
</p>
<p>
	<label>Sidebar image</label>
	<span class="input"><input type="file" name="sidebarfile" /></span>
	{html_image file='/images/assignments/'|cat:$DATA.briefs.briefid|cat:'/sidebar.jpg' href='/images/assignments/'|cat:$DATA.briefs.briefid|cat:'/sidebar.jpg' align="right" width="50" height="50"}
</p>
</fieldset> 


<p style="clear:both;"><strong>Brief Summary</strong></p>
<fieldset> 
<p>
	<label></label>
	<span class="input">
		<input type="submit" value="save" /> &nbsp;
		<input type="button" value="Revert" onClick="document.location.href=document.location.href;" /> &nbsp;
	</span> 
</p>
</fieldset> 

</form>


{include file='admin/pitch_list.tpl'}



				<span class="footer"><br /></span>

				</div>
			</div>
		</div>