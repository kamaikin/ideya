<form method="POST" action="/admin/concept/concept_edit/{if $data.id}?id={$data.id}{/if}">
<table class="admin-mail-template">
	<tr>
		<td>Название</td>
		<td><input type="text" name="name" value="{$data.name}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Проблема</td>
		<td><input type="text" name="problem" value="{$data.problem}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Описание</td>
		<td><input type="text" name="solution" value="{$data.solution}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td>Решение</td>
		<td><input type="text" name="result" value="{$data.result}" class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td colspan="3" class="tar"><input type="submit" value="Сохранить" class="admin-btn"></td>
	</tr>
</table>
</form>