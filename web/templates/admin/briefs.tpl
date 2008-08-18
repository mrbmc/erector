
{if $smarty.get.id eq ""}

<ul class="secondaryNav">
<li><a href="/admin/briefs/0">Add new brief</a></li>
<!--<li><form method="POST"><input type="text" name="query" /><input type="submit" value="Search Briefs" /></form></li>-->
</ul>
<br clear="all" />

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th>#</th>
		<th>Title</th>
		<th>Status</th>
		<th>Due Date</th>
	</tr>
{foreach from=$DATA.briefs item=row name=foo}
	<tr>
		<td>{$smarty.foreach.foo.iteration}</td>
		<td><a href="{$DOCROOT}/admin/briefs/{$row->briefid}">{$row->title}</a></td>
		<td>{$row->status}</td>
		<td>{$row->duedate|date_format:"%B %e, %Y"}</td>
	</tr>
{/foreach}
</table>

{else}

{include file='admin/brief_form.tpl'}

{/if}