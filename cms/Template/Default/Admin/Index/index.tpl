<div class="tar admin-text-header">
    <span class="admin-text-title">Период:</span>
    <label for="date-before" class="admin-text-icon"><i class="fa fa-calendar"></i></label>
    <input type="text" name="date-before" id="date-before" class="admin-field admin-field-date" autocomplete="off" tabindex="1">
    <span class="date-separator">-</span>
    <label for="date-after" class="admin-text-icon"><i class="fa fa-calendar"></i></label>
    <input type="text" name="date-after" id="date-after" class="admin-field admin-field-date" autocomplete="off" tabindex="2">
</div>
<table class="admin-table admin-table-progress">
	<tr>
		<th></th>
		<th width="20px"></th>
		<th>Всего</th>
		<th width="20px"></th>
		<th>За последние сутки</th>
		<th width="20px"></th>
		<th></th>
	</tr>
	<tr>
		<td>Идей</td>
		<td width="20px"></td>
		<td>{$data1}</td>
		<td width="20px"></td>
		<td>{$data2}</td>
		<td width="20px"></td>
		<td></td>
	</tr>
	<tr>
		<td>Комментариев</td>
		<td width="20px"></td>
		<td>{$data3}</td>
		<td width="20px"></td>
		<td>{$data4}</td>
		<td width="20px"></td>
		<td></td>
	</tr>
	<tr>
		<td>Лайки</td>
		<td width="20px"></td>
		<td>{$data5}</td>
		<td width="20px"></td>
		<td>{$data6}</td>
		<td width="20px"></td>
		<td></td>
	</tr>
	<tr>
		<td>Пользователи</td>
		<td width="20px"></td>
		<td>{$data7}</td>
		<td width="20px"></td>
		<td>{$data8}</td>
		<td width="20px"></td>
		<td></td>
	</tr>
</table>