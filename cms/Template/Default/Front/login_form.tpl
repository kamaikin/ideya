<!DOCTYPE html>
<html lang="en" class="home-second">
<head>
    <meta charset="UTF-8">
    <title>Вход и регистрация</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSS style -->
    <link rel="stylesheet" href="/public/base/css/index.css?v=2">
    <!-- CSS for developers -->
    <!-- <link rel="stylesheet" href="/public/base/css/dev.css?v=1" media="screen"> -->
    <!-- Scripts -->
    <script data-headjs-load="/public/base/js/init.js" src="/public/base/js/head.min.js"></script>
</head>
<body>
    <div class="container-wrap">
        <header role="banner" class="main-header">
            <h1 class="main-title">Место где воплощаются идеи</h1>
        </header>
        <div role="main" class="content">
            <form role="form" action="/login/check/{if $smarty.get.url}?url={$smarty.get.url}{/if}" class="aut-form" method="POST">
            {if $request_uri}<input type="hidden" name="request_uri" value="{$request_uri}" />{/if}
                <a href="/" class="tac main-logo"><img src="/public/base/images/main_logo2.png" alt="logo"></a>
                <div class="aut-form-title">Добро пожаловать!</div>
                <div class="aut-form-row first {if $login_error_id==1}error{else}valid{/if}">
                    <label for="aut_email" class="aut-form-label aut-form-label-email"></label>
                    <input type="email" name="login" id="aut_email" class="aut-field" autocomplete="off" tabindex="1" placeholder="Введите Ваш email" {if $login_email}value="{$login_email}"{/if}>
                    {if $login_error_id==1}<div class="validation-tooltip">{$login_error}</div>{/if}
                </div>
                <div class="aut-form-row {if $login_error_id==2}error{else}valid{/if}">
                    <label for="aut_password" class="aut-form-label aut-form-label-pass"></label>
                    <input type="password" name="pass" id="aut_password" class="aut-field" autocomplete="off" tabindex="2" placeholder="Введите Ваш пароль">
                    {if $login_error_id==2}<div class="validation-tooltip">{$login_error}</div>{/if}
                </div>
                <div class="aut-form-button">
                    <button class="aut-btn">Вход</button>
                </div>
                {*<div class="aut-form-footer tac">
                    <a href="#" class="aut-form-link">Забыли пароль?</a>
                </div>*}
            </form>
        </div><!--end content-->
        <footer role="contentinfo" class="main-footer tac">
            <a href="/" class="dib main-design-logo">powered by <img src="/public/base/images/main_design_logo.png" alt=""></a>
        </footer><!--end footer-->
    </div><!--end main block-->
</body>
</html>