<hr>{include file="MailTemplate/sub_menu.tpl"}<hr>
<h1>{$IndexTitle}</h1>
<table>
	<tr>
		<td>id</td>
		<td width="20px"></td>
		<td>Название</td>
		<td width="20px"></td>
		<td>Ключ</td>
		<td width="20px"></td>
		<td>Описание</td>
		<td width="20px"></td>
		<td>Тема письма</td>
		<td width="20px"></td>
		<td>Действия</td>
	</tr>
	{foreach from=$data item="Value"}
	<tr>
		<td>{$Value.id}</td>
		<td width="20px"></td>
		<td>{$Value.title}</td>
		<td width="20px"></td>
		<td>{$Value.name}</td>
		<td width="20px"></td>
		<td>{$Value.description}</td>
		<td width="20px"></td>
		<td>{$Value.subject}</td>
		<td width="20px"></td>
		<td>
			<a href="/admin/mailTemplate/edit/?id={$Value.id}">Редактировать</a>
			<a href="/admin/mailTemplate/delete/?id={$Value.id}">Удалить</a>
		</td>
	</tr>
	{/foreach}
</table>