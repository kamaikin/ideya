<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <title>{$IndexTitle}</title> 
</head>
<body>
	<a href="/">Главная Сайта</a> <a href="/admin/">Админка</a> <a href="/admin/user/">Пользователи</a> <a href="/admin/acl/">Права доступа</a> <a href="/admin/acl/pages/">Страницы доступа</a> <a href="/admin/concept/">Идеи</a> <a href="/admin/mailTemplate/">Шаблоны писем</a>
  <div class="container">
    <div class="info">
      {include file=$includeFileName}
    </div>
  </div>
</body>
</html>