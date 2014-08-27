<hr>{include file="User/sub_menu.tpl"}<hr>
<form enctype="multipart/form-data" action="{$post_url}" method="post">
<table>
	<tr>
		<td>id</td>
		<td width="20px"></td>
		<td>Ключ</td>
		<td width="20px"></td>
		<td>Описание</td>
		<td width="20px"></td>
		<td>Кредиты</td>
	</tr>
	{foreach from=$data item="Value"}
	<tr>
		<td>{$Value.id}</td>
		<td width="20px"></td>
		<td>{$Value.key}</td>
		<td width="20px"></td>
		<td>{$Value.name}</td>
		<td width="20px"></td>
		<td><input type="text" value="{$Value.Credits}" name="data[{$Value.id}]" style="width: 40px" /></td>
	</tr>
	{/foreach}
	<tr>
		<td></td>
		<td width="20px"></td>
		<td><input type="text" value="" name="key" style="width: 200px" /></td>
		<td width="20px"></td>
		<td><input type="text" value="" name="name" style="width: 200px" /></td>
		<td width="20px"></td>
		<td><input type="text" value="" name="credits" style="width: 40px" /></td>
	</tr>
	<tr>
		<td colspan="7" style="text-align: center;"><input type="submit" value="Сохранить"></td>
	</tr>
</table>
</form>