<hr>{include file="User/sub_menu.tpl"}<hr>
<center>
<h1>Импортировать пользователей</h1>
{if $formView == 'form'}
<form enctype="multipart/form-data" action="/admin/user/import/" method="post">
Выбирите файл с информацией о пользователях: <input name="userfile" type="file">(.xls)<br />
<table>
	<tr>
		<td></td>
		<td width="20px"></td>
		<td></td>
	</tr>
	<tr>
		<td>Права пользователей:</td>
		<td width="20px"></td>
		<td>
			<select>
				<option value="0">Определены в файле</option>
				<option value="1">Пользователь</option>
				<option value="2">Спонсор</option>
				<option value="3">Модератор</option>
				<option value="4">Администратор</option>
			</select>
		</td>
	</tr>
</table><br>
<input type="submit" value="Импортировать список пользователей">
</form>
{/if}

{if $formView == 'result'}
<h2>Данные импортированы успешно</h2>
{foreach from=$data item="value"}
<p>{$value}</p>
{/foreach}
{/if}

{if $formView == 'error'}
<h2>{$info}</h2>
{/if}
</center>