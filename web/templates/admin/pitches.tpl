
{if $smarty.get.id}

{include file="admin/pitch_form.tpl"}

{else}
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th>#</th>
		<th>Date</th>
		<th>Title</th>
		<th>User</th>
		<th>Brief</th>
	</tr>
{foreach from=$DATA.pitches item=row name=foo}
	<tr>
		<td>{$smarty.foreach.foo.iteration}</td>
		<td>{$row.dateline|date_format:"%B %e, %Y"}</td>
		<td><a href="{$DOCROOT}/admin/pitches/{$row.pitchid}">{$row.title}</a></td>
		<td><a href="{$DOCROOT}/admin/users/{$row.userid}">{$row.username}</a></td>
		<td><a href="./briefs/{$row.briefid}">{$row.client}: {$row.brieftitle}</a></td>
	</tr>
{/foreach}
</table>
{/if}