{include file="User/sub_menu.tpl"}
<table class="admin-table">
    <tr>
        <th>id Пользоватея</th>
        <th>Ник</th>
        <th>ФИО</th>
        <th>Email</th>
        <th>Регистрация</th>
        <th>Последний вход</th>
        <th>Роль</th>
        <th></td>
        <th></td>
    </tr>
    {foreach from=$data item="Value"}
    <tr>
        <td>{$Value.user_id}</td>
        <td>{$Value.nick_name}</td>
        <td>{$Value.surname} {$Value.name} {$Value.patronymic}</td>
        <td>{$Value.email}</td>
        <td>{$Value.register_date|date_format:"%d-%m-%y %T"}</td>
        <td>{$Value.last_visit_date|date_format:"%d-%m-%y %T"}</td>
        <td>{$Value.user_role}</td>
        <td><a href="/admin/user/edit/?id={$Value.user_id}"><i class="fa fa-pencil" title="Редактировать"></i></a></td>
        <td><a href="/admin/user/delete/?id={$Value.user_id}" class="js-delete"><i class="fa fa-trash" title="Удалить"></i></a></td>
    </tr>
    {/foreach}
    <tr>
        <td colspan="9" align="center">{$paginator}</td>
    </tr>
</table>
<div class="tar admin-text-footer">
    <label for="admin_number_of_output">Кол-во вывода:  </label>
    <select name="admin_number_of_output" id="admin_number_of_output" class="field">
        <option value="25" {if $smarty.session.user_count=='25'}selected{/if}>25</option>
        <option value="50" {if $smarty.session.user_count=='50'}selected{/if}>50</option>
        <option value="100" {if $smarty.session.user_count=='100'}selected{/if}>100</option>
        <option value="500" {if $smarty.session.user_count=='500'}selected{/if}>500</option>
    </select>
</div>
{literal}
<script type="text/javascript">
    $(function() {
        $(".js-delete").click(function(){
            if (confirm("Вы точно хотите удалить?")) {
                return true;
            } else {
                return false;
            }
        })
        $("#admin_number_of_output").change(function(){
            url = location.href + '?count=' + $("#admin_number_of_output").val();
            location.href = url;
            return false;
        })
    })
</script>
{/literal}