<hr>{include file="User/sub_menu.tpl"}<hr>
<table>
	<tr>
		<td>id Пользоватея</td>
		<td width="20px"></td>
		<td>Ник</td>
		<td width="20px"></td>
		<td>ФИО</td>
		<td width="20px"></td>
		<td>Email</td>
		<td width="20px"></td>
		<td>Регистрация</td>
		<td width="20px"></td>
		<td>Последний вход</td>
		<td width="20px"></td>
		<td>Роль</td>
		<td width="20px"></td>
		<td>Ltqcndbz</td>
	</tr>
	{foreach from=$data item="Value"}
	<tr>
		<td>{$Value.user_id}</td>
		<td width="20px"></td>
		<td>{$Value.nick_name}</td>
		<td width="20px"></td>
		<td>{$Value.surname} {$Value.name} {$Value.patronymic}</td>
		<td width="20px"></td>
		<td>{$Value.email}</td>
		<td width="20px"></td>
		<td>{$Value.register_date|date_format:"%d-%m-%y %T"}</td>
		<td width="20px"></td>
		<td>{$Value.last_visit_date|date_format:"%d-%m-%y %T"}</td>
		<td width="20px"></td>
		<td>{$Value.user_role}</td>
		<td width="20px"></td>
		<td>
			<a href="/admin/user/edit/?id={$Value.user_id}">Редактировать</a>
			<a href="/admin/user/delete/?id={$Value.user_id}">Удалить</a>
		</td>
	</tr>
	{/foreach}
</table>