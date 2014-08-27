<hr><a href="/admin/concept/comment/">Комментарии к идеям</a> <a href="/admin/concept/comment/new/">Комментарии идей на модерацию</a><hr>
<h1>{$IndexTitle}</h1>
<table>
	<tr>
		<td>id Идеи</td>
		<td width="20px"></td>
		<td>Название</td>
		<td width="20px"></td>
		<td>Автор</td>
		<td width="20px"></td>
		<td>Анонимно</td>
		<td width="20px"></td>
		<td>Модерировано</td>
		<td width="20px"></td>
		<td>Добавлено</td>
		<td width="20px"></td>
		<td>Комментарии</td>
		<td width="20px"></td>
		<td>Действия</td>
	</tr>
	{foreach from=$data item="Value"}
	<tr {if $Value.moderating == 'n'}style="background-color: #F00;"{/if}>
		<td>{$Value.id}</td>
		<td width="20px"></td>
		<td>{$Value.name}</td>
		<td width="20px"></td>
		<td>{$Value.nick_name}</td>
		<td width="20px"></td>
		<td>{if $Value.anonimus == 'n'}Нет{else}Да{/if}</td>
		<td width="20px"></td>
		<td>{if $Value.moderating == 'n'}Нет{else}Да{/if}</td>
		<td width="20px"></td>
		<td>{$Value.date|date_format:"%d-%m-%y %T"}</td>
		<td width="20px"></td>
		<td style="text-align: center;"><a href="/admin/concept/comment/?concept_id={$Value.id}">{$Value.comment_count} Просмотреть</a></td>
		<td width="20px"></td>
		<td>
			<a href="/admin/concept/concept_edit/?id={$Value.id}">Редактировать</a>
			<a href="/admin/concept/concept_delete/?id={$Value.id}">Удалить</a>
			{if $Value.moderating == 'n'}<a href="/admin/concept/concept_moderating/?id={$Value.id}&page={$smarty.get.url}">Разрешить</a>{/if}
		</td>
	</tr>
	{/foreach}
</table>