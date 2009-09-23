
{if $DISPATCHER.id>0}

{include file='admin/user_form.tpl'}

{else}

<p><a href="?format=xls">Download this list for Excel</a> | <a href="{$DOCROOT}/admin/subscribed/download">Download List of subscribed users</a></p>


<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th>#</th>
		<th>Username</th>
		<th>Name</th>
		<th>Date Joined</th>
	</tr>
{foreach from=$DATA.users item=row name=foo}
	<tr>
		<td>{$smarty.foreach.foo.iteration}</td>
		<td><a href="{$DOCROOT}/admin/users/{$row->userid}">{$row->username}</a></td>
		<td><strong>{$row->first_name} {$row->last_name}</strong></td>
		<td>{$row->date_created|date_format:"%B %e, %Y"}</td>
	</tr>
{/foreach}
</table>

<p><a href="?format=xls">Download this list for Excel</a></p>

{/if}