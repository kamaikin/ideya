{include file="User/sub_menu.tpl"}
<h1 class="admin-title">Импортировать пользователей</h1>
{if $formView == 'form'}
<form enctype="multipart/form-data" action="/admin/user/import/" method="post">
<table class="admin-import-user">
	<tr>
		<td>Выбирите файл с информацией о пользователях:</td>
		<td><input name="userfile" type="file">(.xls)</td>
	</tr>
	<tr>
		<td>Права пользователей:</td>
		<td>
			<select class="admin-field">
				<option value="0">Определены в файле</option>
				<option value="1">Пользователь</option>
				<option value="2">Спонсор</option>
				<option value="3">Модератор</option>
				<option value="4">Администратор</option>
			</select>
		</td>
	</tr>
</table>
<p class="tac">
	<input type="submit" class="admin-btn" value="Импортировать список пользователей">
</p>
</form>
{/if}

{if $formView == 'result'}
<h2 class="admin-title">Данные импортированы успешно</h2>
{foreach from=$data item="value"}
<p>{$value}</p>
{/foreach}
{/if}

{if $formView == 'error'}
<h2 class="admin-title">{$info}</h2>
{/if}