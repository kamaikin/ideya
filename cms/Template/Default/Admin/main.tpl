<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/public/Style/Default/Admin/css/index.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <title>{$IndexTitle}</title>
  <script>
    $.datepicker.regional['ru'] = {
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        dateFormat: 'dd.mm.yy',
        firstDay: 1
    };
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $(document).ready(function() {
      $('#date-before, #date-after').datepicker();
    });
  </script>
</head>
<body>
  <ul class="admin-nav">
    <li class="admin-nav-item"><a href="/" class="admin-nav-link">Главная</a></li>
    <li class="admin-nav-item"><a href="/admin/" class="admin-nav-link">Админка</a></li>
    {if $index_user_role == 'admin'}
    <li class="admin-nav-item"><a href="/admin/user/" class="admin-nav-link">Пользователи</a></li>
    {/if}
    {*if $index_user_role == 'admin'}
    <li class="admin-nav-item"><a href="/admin/acl/" class="admin-nav-link">Права доступа</a></li>
    {/if*}
    <li class="admin-nav-item"><a href="/admin/concept/" class="admin-nav-link">Идеи</a></li>
    {if $index_user_role == 'admin'}
    <li class="admin-nav-item"><a href="/admin/mailTemplate/" class="admin-nav-link">Шаблоны писем</a></li>
    {/if}
  </ul>
  <div class="logo tac">
    <a href="/"><img src="/public/base/images/logo.png" alt="{$IndexTitle}"></a>
  </div>
  <div class="container">
    <div class="info">
      {include file=$includeFileName}
    </div>
  </div>
</body>
</html>