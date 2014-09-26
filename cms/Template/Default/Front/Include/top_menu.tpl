<nav class="menu_main">
<ul>
  <li class="active"><a href="/">Главная</a></li>
  <li><a href="/concept/new/">Новые</a></li>
  <li><a href="/concept/discussed/">Обсуждаемые</a></li>
  <li><a  href="#?w=600" rel="concept" class="poplight" id="add_concept">Добавить идею</a></li>
  {if $index_autorize}
  <li><a href="/user/profile/">Профиль ({$index_user_login})</a></li>
  <li><a href="/login/logout/">Выйти</a></li>
  {else}
  <li><a href="/login/#register">Регистрация</a></li>
  <li><a href="/login/">Войти</a></li>
  {/if}
</ul>
</nav>