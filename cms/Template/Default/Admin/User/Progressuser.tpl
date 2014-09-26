{include file="User/sub_menu.tpl"}
<form enctype="multipart/form-data" action="{$post_url}" method="post">
    <table class="admin-table admin-table-progress">
        <tr>
            <th>id</th>
            <th>Ключ</th>
            <th>Описание</th>
            <th class="tac">Кредиты</th>
        </tr>
        {foreach from=$data item="Value"}
        <tr>
            <td>{$Value.id}</td>
            <td>{$Value.key}</td>
            <td>{$Value.name}</td>
            <td class="tac"><input type="text" value="{$Value.Credits}" name="data[{$Value.id}]" class="admin-field admin-credits"></td>
        </tr>
        {/foreach}
        {*<tr>
            <td></td>
            <td><input type="text" value="" name="key" class="admin-field" ></td>
            <td><input type="text" value="" name="name" class="admin-field" ></td>
            <td class="tac"><input type="text" value="" name="credits" class="admin-field admin-credits"></td>
        </tr>*}
        <tr>
            <td colspan="7" class="tar"><input type="submit" class="admin-btn" value="Сохранить"></td>
        </tr>
    </table>
</form>