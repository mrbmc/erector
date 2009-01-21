{include file='admin/header.tpl'}

{if $DATA.user.status eq 'admin'}
{assign var=tpl value='admin/'}
{assign var=tpl value=$tpl|cat:$smarty.get.do}
{assign var=tpl value=$tpl|cat:'.tpl'}
{include file=$tpl}
{else}
{if $smarty.session.userid >= 0}
You don't have permissions to access this area.
{/if}
{include file='login_form.tpl'}
{/if}


{include file='admin/footer.tpl'}
