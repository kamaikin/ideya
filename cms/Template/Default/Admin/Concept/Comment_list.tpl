{include file="Concept/sub_menu.tpl"}
<h1 class="admin-title">{$IndexTitle}</h1>
<table class="admin-table">
	<tr>
		<th>id Комментария</th>
		<th>Автор</th>
		<th>Текст</th>
		<th>Модерировано</th>
		<th>Добавлено</th>
		<th colspan="2">Действия</th>
	</tr>
	{foreach from=$data item="Value"}
	<tr {if $Value.moderating == 'n'}style="background-color: #F00;"{/if}>
		<td>{$Value.id}</td>
		<td>{$Value.nick_name}</td>
		<td>{$Value.body}</td>
		<td>{if $Value.moderating == 'n'}Нет{else}Да{/if}</td>
		<td>{$Value.date|date_format:"%d-%m-%y %T"}</td>
		<td>
			<a href="/admin/concept/comment_delete/?id={$Value.id}&concept_id={$smarty.get.concept_id}"><i class="fa fa-trash" title="Удалить"></i></a>
		</td>
		<td>
			{if $Value.moderating == 'n'}<a href="/admin/concept/comment_moderating/?id={$Value.id}&page={$smarty.get.url}&concept_id={$smarty.get.concept_id}"><i class="fa fa-check-circle" title="Разрешить"></i></a>{/if}
		</td>
	</tr>
	{/foreach}
</table>