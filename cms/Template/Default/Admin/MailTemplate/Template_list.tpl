{include file="MailTemplate/sub_menu.tpl"}
<h1 class="admin-title">{$IndexTitle}</h1>
<table class="admin-table">
    <tr>
        <th>id</th>
        <th>Название</th>
        <th>Ключ</th>
        <th>Описание</th>
        <th>Тема письма</th>
        <th colspan="2">Действия</th>
    </tr>
    {foreach from=$data item="Value"}
    <tr>
        <td>{$Value.id}</td>
        <td>{$Value.title}</td>
        <td>{$Value.name}</td>
        <td>{$Value.description}</td>
        <td>{$Value.subject}</td>
        <td>
            <a href="/admin/mailTemplate/edit/?id={$Value.id}"><i class="fa fa-pencil" title="Редактировать"></i></a>
        </td>
        <td>
            <a href="/admin/mailTemplate/delete/?id={$Value.id}" class="js-delete"><i class="fa fa-trash" title="Удалить"></i></a>
        </td>
    </tr>
    {/foreach}
</table>
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
    })
</script>
{/literal}