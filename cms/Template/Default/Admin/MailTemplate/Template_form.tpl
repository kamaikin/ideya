<form method="POST" action="/admin/mailTemplate/edit/{if $data.id}?id={$data.id}{/if}">
<table class="admin-mail-template">
	<tr>
		<td>Название шаблона</td>
		<td><input type="text" name="title" value="{$data.title}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Описание шаблона</td>
		<td><input type="text" name="description" value="{$data.description}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Ключ</td>
		<td><input type="text" name="name" value="{$data.name}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Доп информация</td>
		<td><input type="text" name="info" value="{$data.info}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Ключи</td>
		<td>
			<table>
			{foreach from=$sub_data item="value"}
				<tr>
					<td>{literal}{{/literal}<input type="text" name="tkey[]" value="{$value.key}" class="admin-field" style="width: 100px">{literal}}{/literal}</td>
					<td><input type="text" value="{$value.value}" name="tvalue[]" class="admin-field" style="width: 300px"></td>
				</tr>
			{/foreach}
			<tr>
				<td>{literal}{{/literal}<input type="text" name="tkey[]" value="" class="admin-field" style="width: 100px">{literal}}{/literal}</td>
				<td><input type="text" value="" name="tvalue[]" class="admin-field" style="width: 300px"></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Заголовок шаблона</td>
		<td><input type="text" name="subject" value="{$data.subject}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Шаблон</td>
		<td><textarea style="width: 700px; height: 300px" class="admin-field" name="body">{$data.body}</textarea></td>
	</tr>
	<tr>
		<td colspan="3" class="tar"><input type="submit" value="Сохранить" class="admin-btn"></td>
	</tr>
</table>
</form>