{include file="User/sub_menu.tpl"}
<h1 class="admin-title">Редактирование пользователя</h1>
{if $error}<h2 style="color: #F00;">{$error}</h2>{/if}
<form enctype="multipart/form-data" action="{if $smarty.get.id}/admin/user/edit/?id={$smarty.get.id}{else}/admin/user/new/{/if}" method="post">
<table class="admin-add-user">
	<tr>
		<td>E-mail:</td>
		<td>
			<input type="text" name="email" value="{$smarty.post.email}" class="admin-field">
		</td>
	</tr>
	<tr>
		<td>Фамилия:</td>
		<td>
			<input type="text" name="surname" value="{$smarty.post.surname}" class="admin-field">
		</td>
	</tr>
	<tr>
		<td>Имя:</td>
		<td>
			<input type="text" name="name" value="{$smarty.post.name}" class="admin-field">
		</td>
	</tr>
	<tr>
		<td>Отчество:</td>
		<td>
			<input type="text" name="patronymic" value="{$smarty.post.patronymic}" class="admin-field">
		</td>
	</tr>
	<tr>
		<td>Права пользователя:</td>
		<td>
			<select name="role" class="admin-field">
				<option value="user" {if $smarty.post.role == 'user'}selected{/if}{if $smarty.post.user_role == 'user'}selected{/if}>Пользователь</option>
				<option value="sponsor" {if $smarty.post.role == 'sponsor'}selected{/if}{if $smarty.post.user_role == 'sponsor'}selected{/if}>Спонсор</option>
				<option value="moderator" {if $smarty.post.role == 'moderator'}selected{/if}{if $smarty.post.user_role == 'moderator'}selected{/if}>Модератор</option>
				<option value="admin" {if $smarty.post.role == 'admin'}selected{/if}{if $smarty.post.user_role == 'admin'}selected{/if}>Администратор</option>
			</select>
		</td>
	</tr>
</table><br>
<p class="tac">
	<input type="submit" value="Создать" class="admin-btn">
</p>
</form>