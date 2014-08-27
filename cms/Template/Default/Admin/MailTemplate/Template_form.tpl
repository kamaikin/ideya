<form method="POST" action="/admin/mailTemplate/edit/?id={$data.id}">
<table>
	<tr>
		<td>Название шаблона</td>
		<td width="20px"></td>
		<td><input type="text" name="title" value="{$data.title}" style="width: 700px;" /></td>
	</tr>
	<tr>
		<td>Описание шаблона</td>
		<td width="20px"></td>
		<td><input type="text" name="description" value="{$data.description}" style="width: 700px;" /><</td>
	</tr>
	<tr>
		<td>Ключ</td>
		<td width="20px"></td>
		<td><input type="text" name="name" value="{$data.name}" style="width: 100px;" /></td>
	</tr>
	<tr>
		<td>Доп информация</td>
		<td width="20px"></td>
		<td><input type="text" name="info" value="{$data.info}" style="width: 700px;" /></td>
	</tr>
	<tr>
		<td>Ключи</td>
		<td width="20px"></td>
		<td>
			<table>
			{foreach from=$sub_data item="value"}
				<tr>
					<td>{literal}{{/literal}<input type="text" name="tkey[]" value="{$value.key}" style="width: 100px;" />{literal}}{/literal}</td>
					<td width="20px"></td>
					<td><input type="text" value="{$value.value}" name="tvalue[]" style="width: 300px;" /></td>
				</tr>
			{/foreach}
			<tr>
				<td>{literal}{{/literal}<input type="text" name="tkey[]" value="" style="width: 100px;" />{literal}}{/literal}</td>
				<td width="20px"></td>
				<td><input type="text" value="" name="tvalue[]" style="width: 300px;" /></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Заголовок шаблона</td>
		<td width="20px"></td>
		<td><input type="text" name="subject" value="{$data.subject}" style="width: 700px;" /></td>
	</tr>
	<tr>
		<td>Шаблон</td>
		<td width="20px"></td>
		<td><textarea style="width: 700px; height: 300px" name="body">{$data.body}</textarea></td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center;"><input type="submit" value="Сохранить" /></td>
	</tr>
</table>
</form>