<nav class="menu_bottom">
<ul>
  <li class="active"><a href="/">Главная</a></li>
  <li><a href="/concept/new/">Новые идеи</a></li>
  <li><a href="/concept/discussed/">Самые обсуждаемые</a></li>
  {if $index_autorize}
  <li><a href="/user/profile/">Профиль ({$index_user_login})</a></li>
  <li><a href="/login/logout/">Выйти</a></li>
  {else}
  <li><a href="/login/#register">Регистрация</a></li>
  <li><a href="/login/">Войти</a></li>
  {/if}
</ul>
</nav>