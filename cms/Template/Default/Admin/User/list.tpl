{include file="User/sub_menu.tpl"}
<table class="admin-table">
	<tr>
		<th>id Пользоватея</th>
		<th>Ник</th>
		<th>ФИО</th>
		<th>Email</th>
		<th>Регистрация</th>
		<th>Последний вход</th>
		<th>Роль</th>
		<th></td>
		<th></td>
	</tr>
	{foreach from=$data item="Value"}
	<tr>
		<td>{$Value.user_id}</td>
		<td>{$Value.nick_name}</td>
		<td>{$Value.surname} {$Value.name} {$Value.patronymic}</td>
		<td>{$Value.email}</td>
		<td>{$Value.register_date|date_format:"%d-%m-%y %T"}</td>
		<td>{$Value.last_visit_date|date_format:"%d-%m-%y %T"}</td>
		<td>{$Value.user_role}</td>
		<td><a href="/admin/user/edit/?id={$Value.user_id}"><i class="fa fa-pencil" title="Редактировать"></i></a></td>
		<td><a href="/admin/user/delete/?id={$Value.user_id}"><i class="fa fa-trash" title="Удалить"></i></a></td>
	</tr>
	{/foreach}
</table>