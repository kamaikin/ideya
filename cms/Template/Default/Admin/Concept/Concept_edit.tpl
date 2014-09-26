<form method="POST" action="/admin/concept/concept_edit/{if $data.id}?id={$data.id}{/if}">
<table class="admin-mail-template">
	<tr>
		<td>Изображение</td>
		<td><img src="{if $data.foto==''}/public/img/nophoto.jpg{else}/i/126/{$data.foto}{/if}" /><br>{if $data.foto!=''}<input type="checkbox" name="foto" value="1" /> - Удалить{/if}</td>
	</tr>
	<tr>
		<td>Файлы</td>
		<td>
			{if $data.file_1}<a href="/d/{$data.file_1}" >{$data.file_1_name}</a> <input type="checkbox" name="file1" value="1" /> - Удалить<br>{/if}
			{if $data.file_2}<a href="/d/{$data.file_2}" >{$data.file_2_name}</a> <input type="checkbox" name="file2" value="1" /> - Удалить<br>{/if}
			{if $data.file_3}<a href="/d/{$data.file_3}" >{$data.file_3_name}</a> <input type="checkbox" name="file3" value="1" /> - Удалить<br>{/if}
		</td>
	</tr>
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
		<td>Анонимно</td>
		<td><input type="checkbox" name="anonimus" value="1" {if $data.anonimus=='y'}checked
{/if} class="admin-field" style="width: 700px"></td>
	</tr>
	<tr>
		<td colspan="3" class="tar"><input type="submit" value="Сохранить" class="admin-btn"></td>
	</tr>
</table>
</form>