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
    <link rel="stylesheet" href="/public/base/css/animate.min.css?v=2">
    <link rel="stylesheet" href="/public/base/css/index.css?v=2">
    <!-- CSS for developers -->
    <!-- <link rel="stylesheet" href="/public/base/css/dev.css?v=1" media="screen"> -->
    <!--favicon-->
    <link rel="icon" href="/public/base/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/public/base/favicon.png" type="image/x-icon">
    <!-- Scripts -->
    <script src="/public/base/js/jquery.min.js"></script>
    <script data-headjs-load="/public/base/js/init.js" src="/public/base/js/head.min.js"></script>
</head>
<body>
    <div class="container-wrap">
        <header role="banner" class="main-header">
            <h1 class="main-title">Место, где воплощаются идеи</h1>
        </header>
        <div role="main" class="content">
            <form role="form" action="/login/check/{if $smarty.get.url}?url={$smarty.get.url}{/if}" class="aut-form animated fadeInDown" method="POST" id="form-1">
            {if $request_uri}<input type="hidden" name="request_uri" value="{$request_uri}" />{/if}
                <div class="tac main-logo"><img src="/public/base/images/main_logo2.png" alt="logo"></div>
                <div class="aut-form-title">Добро пожаловать!</div>
                <div class="aut-form-row-box first">
                    <div class="aut-form-row {if $login_error_id==1}error{else}{/if}">
                        <label for="aut_email" class="aut-form-label aut-form-label-email"></label>
                        <input type="email" name="login" id="aut_email" class="aut-field" autocomplete="off" tabindex="1" placeholder="Введите Ваш email" {if $login_email}value="{$login_email}"{/if}>
                        {if $login_error_id==1}<div class="validation-tooltip">{$login_error}</div>{/if}
                    </div>
                </div>
                <div class="aut-form-row-box">
                    <div class="aut-form-row {if $login_error_id==2}error{else}{/if}">
                        <label for="aut_password" class="aut-form-label aut-form-label-pass"></label>
                        <input type="password" name="pass" id="aut_password" class="aut-field" autocomplete="off" tabindex="2" placeholder="Введите Ваш пароль">
                        {if $login_error_id==2}<div class="validation-tooltip">{$login_error}</div>{/if}
                    </div>
                </div>
                {if $smarty.get.url}
                <div class="aut-form-row-box">
                    <div class="aut-form-row {if $login_error_id==2}error{else}{/if}">
                        <label for="aut_password" class="aut-form-label aut-form-label-pass"></label>
                        <input type="password" name="pass1" id="aut_password1" class="aut-field" autocomplete="off" tabindex="2" placeholder="Повторите Ваш пароль">
                        {if $login_error_id==2}<div class="validation-tooltip">{$login_error}</div>{/if}
                    </div>
                </div>
                {/if}
                <div class="aut-form-button">
                    <button class="aut-btn" id='vxod'>Вход</button>
                </div>
                <div class="aut-form-footer tac">
                    <a href="#" class="aut-form-link" id="aut-form-link-1">Забыли пароль?</a>
                </div>
            </form>
            <form role="form" action="/login/check_pass/" class="aut-form animated fadeInDown" method="POST" style="display: none;"  id="form-2">
                <div class="tac main-logo"><img src="/public/base/images/main_logo2.png" alt="logo"></div>
                <div class="aut-form-title">Восстановить пароль</div>
                <div class="aut-form-row-box first">
                    <div class="aut-form-row">
                        <label for="aut_email" class="aut-form-label aut-form-label-email"></label>
                        <input type="email" name="login1" id="aut_email1" class="aut-field" autocomplete="off" tabindex="1" placeholder="Введите Ваш email">
                        <div class="validation-tooltip" id="error-pass1"></div>
                    </div>
                </div>
                <div class="aut-form-button">
                    <button class="aut-btn">Восстановить</button>
                </div>
                <div class="aut-form-footer tac">
                    <a href="#" class="aut-form-link" id="aut-form-link-2">Вернуться</a>
                </div>
            </form>
        </div><!--end content-->
        <footer role="contentinfo" class="main-footer tac">
            <div class="dib main-design-logo">powered by <img src="/public/base/images/main_design_logo.png" alt=""></div>
        </footer><!--end footer-->
    </div><!--end main block-->
    {literal}
    <script type="text/javascript">
        $(function() {
            $("#aut-form-link-1").click(function(){
                $("#form-2").show();
                $("#form-1").hide();
                return false;
            })
            $("#aut-form-link-2").click(function(){
                $("#form-1").show();
                $("#form-2").hide();
                return false;
            })
        })
    </script>
    {/literal}
    {if $smarty.get.url}
    {literal}
    <script type="text/javascript">
        $(function() {
            $("#error-pass1").hide();
            $("#form-1").send(function(){
                if($("#aut_password1").val()!=$("#aut_password").val()){
                    $("#error-pass1").show();
                    $("#error-pass1").html("Пароли не совпадают");
                    return false;
                }
            })
        })
    </script>
    {/literal}
    {/if}
</body>
</html>