{include file="Concept/sub_menu.tpl"}
<h1 class="admin-title">{$IndexTitle}</h1>
<table class="admin-table">
	<tr>
		<th>id Идеи</th>
		<th>Название</th>
		<th>Автор</th>
		<th>Анонимно</th>
		<th>Модерировано</th>
		<th>Добавлено</th>
		<th>Комментарии</th>
		<th colspan="3">Действия</th>
	</tr>
	{foreach from=$data item="Value"}
	<tr {if $Value.implemented == 'y'}style="background-color: #0F0;"{/if}>
		<td>{$Value.id}</td>
		<td>{$Value.name}</td>
		<td>{$Value.nick_name}</td>
		<td>{if $Value.anonimus == 'n'}Нет{else}Да{/if}</td>
		<td>{if $Value.moderating == 'n'}Нет{else}Да{/if}</td>
		<td>{$Value.date|date_format:"%d-%m-%y %T"}</td>
		<td class="tac"><a href="/admin/concept/comment/?concept_id={$Value.id}">{$Value.comment_count}</a> <i class="fa fa-eye"></i></td>
		<td>
			<a href="/admin/concept/concept_edit/?id={$Value.id}"><i class="fa fa-pencil" title="Редактировать"></i></a>
		</td>
		<td><a href="/admin/concept/concept_delete/?id={$Value.id}" class="js-delete"><i class="fa fa-trash" title="Удалить"></i></a></td>
		<td>{if $Value.implemented == 'n'}<a href="/admin/concept/concept_moderating/?id={$Value.id}&page={$smarty.get.url}"><i class="fa fa-check-circle" title="отметить идею как реализованную"></i></a>{/if}</td>
	</tr>
	{/foreach}
</table>
<div class="tar admin-text-footer">
    <label for="admin_number_of_output_ideas">Кол-во вывода:  </label>
    <select name="admin_number_of_output_ideas" id="admin_number_of_output_ideas" class="field">
        <option value="25" selected>25</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="500">500</option>
    </select>
</div>
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