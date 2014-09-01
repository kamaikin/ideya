<!DOCTYPE html>
<html lang="en" class="{$main_page_class|default:'main-page'}">
<head>
    <meta charset="UTF-8">
    <title>{$mainTitle}</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSS style -->
    <link rel="stylesheet" href="/public/base/css/index.css?v=2">
    <!-- CSS for developers -->
    <!-- <link rel="stylesheet" href="/public/base/css/dev.css?v=1" media="screen"> -->
    <!-- Scripts -->
    <script src="/public/base/js/jquery.min.js"></script>
    <script data-headjs-load="/public/base/js/init.js" src="/public/base/js/head.min.js"></script>
    <script src="/public/Style/Default/Front/js/upload.js"></script>
</head>
<body>
    <div class="container-wrap">
        <header role="banner" class="header">
            <div class="header-body container clearfix">
                <div class="mobile-menu left">
                    <span class="lists-link listts-link-js"><i class="icon lists-icon"></i></span>
                    <ul class="mobile-menu-list mobile-menu-list-js">
                        <li class="mobile-menu-item"><a href="/user/profile/" class="mobile-menu-link">Мой профиль</a></li>
                        <li class="mobile-menu-item"><a href="#" class="mobile-menu-link"><i class="icon plus-menu-icon"></i>Предложить идею</a></li>
                        <li class="mobile-menu-item"><a href="#" class="mobile-menu-link">Зал славы</a></li>
                        <li class="mobile-menu-item"><a href="#" class="mobile-menu-link">теги</a></li>
                    </ul>
                </div>
                <a href="/" class="logo left"><img src="/public/base/images/logo.png" alt=""></a>
                <form action="/search/" class="searchbox h-searchbox left" method="GET">
                    <button class="search-btn left"><i class="icon search_white-icon"></i></button>
                    <div class="search-field-box">
                        <input type="search" name="search" id="search" class="search-field" autocomplete="off" tabindex="1" placeholder="Поиск" {if $smarty.get.search}value="{$smarty.get.search}"{/if}>
                    </div>
                </form>
                <span class="add h-add left popup-link popup-link-js" data-popup="add">Предложить идею</span>
                <div class="profile h-profile right">
                    <div class="profile-ava loading left"><a href="/user/profile/"><img src="{if $index_user_avatar!=''}/i/41/{$index_user_avatar}{else}/public/img/nophoto.jpg{/if}" alt="" class="profile-ava-img"></a></div>
                    <div class="profile-content ellipsis">
                        {$index_user_login}
                    </div>
                </div>
                <div class="points h-points right">
                    <div class="points-min left">{$index_points}</div>
                    <div class="points-max right">{$index_points_max}</div>
                    <div class="points-line">
                        <div class="points-clolor-line" style="width: {$index_points_procent}%"></div>
                    </div>
                </div>
            </div>
        </header>
        <div role="main" class="content container clearfix">
            {include file=$includeFileName}
            {include file='Index/right_sidebar.tpl'}
        </div><!--end content-->
        <footer role="contentinfo" class="footer tac">
            <a href="/" class="dib design-logo">powered by <img src="/public/base/images/design_logo.png" alt=""></a>
        </footer><!--end footer-->
    </div><!--end main block-->
    <div class="popupper popupper-add popupper-js">
        <span class="popupper-close popupper-close-js"><i class="popupper-close-icon"></i></span>
        <form action="/concept/add/" method="POST" class="popupper-form" id="popupper-form-concept-add">
        <input type="hidden" id="concept_foto" name="concept_foto" />
        <input type="hidden" name="request_url" value="{$smarty.server.REQUEST_URI}" />
        <input type="hidden" name="request_url" value="{$smarty.server.REQUEST_URI}" />
            <h2 class="popupper-add-title">Добавить идею</h2>
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_name" id="addname" class="popupper-add-field count_count" autocomplete="off" tabindex="1" placeholder="Введите название" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addname">70</div>
                </div>
            </div>
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_problem" id="addname1" class="popupper-add-field count_count" autocomplete="off" tabindex="2" placeholder="Опишите проблему" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addname1">70</div>
                </div>
            </div>
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_decision" id="addname2" class="popupper-add-field count_count" autocomplete="off" tabindex="3" placeholder="Опишите решение" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addname2">70</div>
                </div>
            </div>
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_result" id="addresult" class="popupper-add-field count_count" autocomplete="off" tabindex="4" placeholder="Опишите результат" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addresult">70</div>
                </div>
            </div>
            <div class="popupper-add-picbox tac">
                <img src="/public/img/nophoto.jpg" style="width: 150px; height: 120px; display: none;" id="img_foto" />
                <input type="file" style="display: none;" name="file" id="concept_foto_add_input" />
                <p id="img_foto_text">
                    <span class="popupper-add-picbox-title">можно добавить фото</span>
                </p>
                <span class="popupper-add-btn" id="concept_foto_add"><i class="icon download-icon"></i> Загрузить</span>
                <div id="concept_file_progress" style="display:none;">
                    <progress max="100" value="0" id="concept_file_progress_barr"></progress>
                </div>
            </div>
            <ul class="popupper-add-tagsbox">
                {*<li class="popupper-add-tag-item"><a href="#" class="popupper-add-tag-link">зима <span class="icon delete-tag-icon"></span></a></li>
                <li class="popupper-add-tag-item"><a href="#" class="popupper-add-tag-link">тепло <span class="icon delete-tag-icon"></span></a></li>
                <li class="popupper-add-tag-item"><a href="#" class="popupper-add-tag-link">необычное <span class="icon delete-tag-icon"></span></a></li>*}
                <li class="popupper-add-tag-item popupper-add-tag-add"><a href="#" class="popupper-add-tag-add-link"><i class="icon add-tag-icon"></i> тег</a></li>
            </ul>
            <div class="popupper-add-filebox">
                <div class="popupper-add-filebox-title">Прикрепленные файлы:</div>
                <div class="popupper-add-filebox-list" id="file_list">
                    {*<span class="popupper-add-filebox-item">идея1.doc <i class="icon add-file-delete-icon"></i></span>*}
                </div>
                <div class="popupper-add-filebox-add">
                    <input type="file" style="display: none;" name="file1" id="file_upload_input" />
                    <span class="popupper-add-filebox-add-link" id="file_upload"><i class="icon addfile-icon"></i> Прикрепить файл</span>
                    <div id="file_upload_progress" style="display:none;">
                        <progress max="100" value="0" id="file_upload_progress_barr"></progress>
                    </div>
                </div>
            </div>
            <div class="popupper-add-footer clearfix">
                <div class="popupper-add-anonim left">
                    <span id="is_anonimus_data"></span>
                    <div class="popupper-add-anonim-title">Опубликовать анонимно?</div>
                    <div class="popupper-add-anonim-trigger" id="is_anonimus"><span class="popupper-add-anonim-trigger-text">вкл</span><span class="popupper-add-anonim-trigger-pic"></span></div>
                </div>
                <button class="btn popupper-add-f-btn right">Опубликовать</button>
            </div>
        </form>
    </div><!-- /Popupper-add -->
    {literal}
    <script type="text/javascript">
        $(function() {
            var popupperAddTag = new Object()
            var popupperAddTagNum = []
            $(".count_count").keypress(function(){
                var id = $(this).attr('id');
                var max_count = $(this).attr('max_count');
                var new_id = '#count_' + id;
                var count = $(this).val().length;
                var result = (max_count - count)-1;
                if (result<1) {
                    result = '<span style="color: #F00;">' + result + '</span>'
                };
                $(new_id).html(result);
            })
            //  Теги
            $(".popupper-add-tag-add-link").click(function(){
                var test = prompt("Тест", '');
                if (test) {
                    if (!popupperAddTag[test]) {
                        popupperAddTag[test]=test;
                        var id = popupperAddTagNum.length
                        popupperAddTagNum[popupperAddTagNum.length] = test
                        var text = '<li class="popupper-add-tag-item" id="b' + id + '"><a href="#" class="popupper-add-tag-link" id="a' + id + '"><input type="hidden" name="tags[]" value="' + test + '" />' + test + ' <span class="icon delete-tag-icon" id="d' + id + '" aid="' + id + '"></span></a></li>';
                        $(".popupper-add-tag-add-link").before(text);
                        var aid = '#a' + id
                        $(aid).click(function(){return false;})
                        var bid = '#b' + id
                        $(bid).click(function(){return false;})
                        var did = '#d' + id
                        $(did).click(function(){
                            alert("Удаляем"); 
                            var id = $(this).attr('aid');
                            var bid = '#b' + id
                            $(bid).remove();
                            var t = popupperAddTagNum[id];
                            delete popupperAddTag[t];
                            return false;
                        })
                    };
                };
                return false;
            })
            //  Отправка формы
            $("#popupper-form-concept-add").submit(function(){
                //  Если есть класс то публикуем Как обычно
                if(!$("#is_anonimus").hasClass("off")){
                    var text = '<input type="hidden" name="concept_anonimus" value="1" />';
                    $("#is_anonimus_data").html(text);
                }
                //return false;
            })
            //  Отправка файлов
            $("#file_upload").click(function(){
                $("#file_upload_input").trigger('click');
                $("#file_upload_input").change(function () {
                    var t_file_name = $("#file_upload_input").val();
                        if (t_file_name!='') {
                            files = this.files
                            $("#file_upload").hide();
                            $("#file_upload_progress").show();
                            var rand = Math.floor(Math.random() * (10000 - 1 + 1)) + 1
                            var rand_1 = '{/literal}{$index_md5_key}{literal}_' + rand
                            FileUploader({
                            session_id: '{/literal}{$index_md5_key}{literal}',
                            md5: rand_1,
                            message_error: 'Ошибка при загрузке файла', 
                            uploadid: '123456789',
                            uploadscript: '/ajax/file/upload/',
                            progres_barr_id: 'file_upload_progress_barr',
                            param1: 'file',
                            portion: 1024*20  //  Размер кусочка для загрузки... 20 килобайт (1024*1024*2 - 2 мегобайта)
                        }, files[0]);
                    }
                })
                return false;
            })
            
            $("#concept_foto_add").click(function(){
              $("#concept_foto_add_input").trigger('click');
              $("#concept_foto_add_input").change(function () {
                var t_file_name = $("#concept_foto_add_input").val();
                if (t_file_name!='') {
                  files = this.files
                  $("#concept_foto_add").hide();
                  $("#concept_file_progress").show();
                  var rand = Math.floor(Math.random() * (10000 - 1 + 1)) + 1
                  var rand_1 = '{/literal}{$index_md5_key}{literal}_' + rand
                  FileUploader({
                      session_id: '{/literal}{$index_md5_key}{literal}',
                      md5: rand_1,
                      message_error: 'Ошибка при загрузке файла', 
                      uploadid: '123456789',
                      uploadscript: '/ajax/file/upload/',
                      progres_barr_id: 'concept_file_progress_barr',
                      param1: 'foto',
                      portion: 1024*20  //  Размер кусочка для загрузки... 20 килобайт (1024*1024*2 - 2 мегобайта)
                    }, files[0]);
                }
              })
              return false;
            })
        });
    </script>
    {/literal}
</body>
</html>