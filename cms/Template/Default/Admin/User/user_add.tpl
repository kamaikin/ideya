<hr>{include file="User/sub_menu.tpl"}<hr>
<center>
<h1>Добавить пользователя</h1>
{if $error}<h2 style="color: #F00;">{$error}</h2>{/if}
<form enctype="multipart/form-data" action="/admin/user/new/" method="post">
<table>
	<tr>
		<td>E-mail:</td>
		<td width="20px"></td>
		<td>
			<input type="text" name="email" value="{$smarty.post.email}" />
		</td>
	</tr>
	<tr>
		<td>Фамилия:</td>
		<td width="20px"></td>
		<td>
			<input type="text" name="surname" value="{$smarty.post.surname}" />
		</td>
	</tr>
	<tr>
		<td>Имя:</td>
		<td width="20px"></td>
		<td>
			<input type="text" name="name" value="{$smarty.post.name}" />
		</td>
	</tr>
	<tr>
		<td>Отчество:</td>
		<td width="20px"></td>
		<td>
			<input type="text" name="patronymic" value="{$smarty.post.patronymic}" />
		</td>
	</tr>
	<tr>
		<td>Права пользователя:</td>
		<td width="20px"></td>
		<td>
			<select name="role">
				<option value="user" {if $smarty.post.role == 'user'}selected{/if}>Пользователь</option>
				<option value="sponsor" {if $smarty.post.role == 'sponsor'}selected{/if}>Спонсор</option>
				<option value="moderator" {if $smarty.post.role == 'moderator'}selected{/if}>Модератор</option>
				<option value="admin" {if $smarty.post.role == 'admin'}selected{/if}>Администратор</option>
			</select>
		</td>
	</tr>
</table><br>
<input type="submit" value="Создать">
</form>
</center>