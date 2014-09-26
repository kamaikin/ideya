{include file="Concept/sub_menu.tpl"}
<h1 class="admin-title">{$IndexTitle}</h1>
<table class="admin-table">
	<tr>
		<th>Тег</th>
		<th>Количество идей</th>
		<th>Действия</th>
	</tr>
	{foreach from=$data key="key" item="Value"}
	<tr {if $Value.moderating == 'n'}style="background-color: #F00;"{/if}>
		<td>{$tags[$key]}</td>
		<td>{$Value}</td>
		<td><a href="/admin/concept/tags_delete/?id={$key}" class="js-delete"><i class="fa fa-trash" title="Удалить"></i></a></td>
	</tr>
	{/foreach}
</table>
{literal}
<script type="text/javascript">
    $(function() {
        $(".js-delete").click(function(){
            if (confirm("Вы точно хотите удалить?")) {
				return true;
			} else {
				return false;
			}
        })
    })
</script>
{/literal}