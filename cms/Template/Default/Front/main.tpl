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
    <!--favicon-->
    <link rel="icon" href="/public/base/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/public/base/favicon.png" type="image/x-icon">
    <link  href="/public/Style/Default/Front/css/uploadify.css" rel="stylesheet" type="text/css" />
    <!-- Scripts -->
    <script src="/public/base/js/jquery.min.js"></script>
    <script data-headjs-load="/public/base/js/init.js" src="/public/base/js/head.min.js"></script>
    <script src="/public/Style/Default/Front/js/upload.js"></script>
    <script type="text/javascript" src="/public/Style/Default/Front/js/jquery.uploadify.min.js"></script>
</head>
<body>
    <div class="container-wrap">
        <header role="banner" class="header">
            <div class="header-body container clearfix">
                <div class="mobile-menu left">
                    <span class="lists-link listts-link-js"><i class="icon lists-icon"></i></span>
                    <ul class="mobile-menu-list mobile-menu-list-js">
                        <li class="mobile-menu-item"><a href="/user/profile/" class="mobile-menu-link">Мой профиль</a></li>
                        <li class="mobile-menu-item"><span class="mobile-menu-link popup-link popup-link-js" data-popup="add"><i class="icon plus-menu-icon"></i>Предложить идею</span></li>
                        <li class="mobile-menu-item"><a href="/" class="mobile-menu-link">Рейтинг идей</a></li>
                        <li class="mobile-menu-item"><a href="/tags/" class="mobile-menu-link">теги</a></li>
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
                    {if $includeFileName != 'User/profile.tpl'}
                    <div class="profile-ava loading left">
                        <a href="/user/profile/">
                            <img src="{if $index_user_avatar!=''}/i/41/{$index_user_avatar}{else}/public/img/nophoto.jpg{/if}" alt="" class="profile-ava-img" id="main_user_avatar">
                        </a>
                        <div class="profile-logout">
                            <div class="profile-tooltip">
                                <a href="/logout" class="btn">Выйти</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-content ellipsis">
                        <a href="/user/profile/">{$index_user_login}</a>
                    </div>
                    {else}
                    <div class="profile-ava loading left">
                        <img src="{if $index_user_avatar!=''}/i/41/{$index_user_avatar}{else}/public/img/nophoto.jpg{/if}" alt="" class="profile-ava-img" id="main_user_avatar">
                        <div class="profile-logout">
                            <div class="profile-tooltip">
                                <a href="/logout" class="btn">Выйти</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-content ellipsis">
                        {$index_user_login}
                    </div>
                    {/if}
                </div>
                <div class="points h-points right">
                    <div class="points-min left">{$index_points}</div>
                    <div class="points-max right">{$index_points_max}</div>
                    <div class="points-line">
                        <div class="points-clolor-line" style="width: {$index_points_procent}%"></div>
                    </div>
                    <div class="points-tooltip h-points-points-tooltip points-tooltip-bottom">
                        Вы сейчас на {$index_user_raiting_position} месте в рейтинге пользователей
                    </div>
                </div>
            </div>
        </header>
        <div role="main" class="content container clearfix">
            {include file=$includeFileName}
            {include file='Index/right_sidebar.tpl'}
        </div><!--end content-->
        <footer role="contentinfo" class="footer tac">
            <div class="dib design-logo">powered by <img src="/public/base/images/design_logo.png" alt=""></div>
        </footer><!--end footer-->
    </div><!--end main block-->
    <div class="popupper popupper-add popupper-js">
        <span class="popupper-close popupper-close-js"><i class="popupper-close-icon"></i></span>
        <form action="/concept/add/" method="POST" class="popupper-form" id="popupper-form-concept-add">
        <input type="hidden" id="concept_foto" name="concept_foto" />
        <input type="hidden" name="request_url" value="{$smarty.server.REQUEST_URI}" />
            <h2 class="popupper-add-title">Добавить идею</h2>
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_name" id="addname" class="popupper-add-field count_count" autocomplete="off" tabindex="1" placeholder="о чем ваша идея?" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addname">70</div>
                </div>
            </div>
<!--             <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_problem" id="addname1" class="popupper-add-field count_count" autocomplete="off" tabindex="2" placeholder="Опишите проблему" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addname1">70</div>
                </div>
            </div> -->
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_decision" id="addname2" class="popupper-add-field count_count" autocomplete="off" tabindex="3" placeholder="что вы предлагаете сделать?" max_count="140">
                    <div class="popupper-form-word_counter" id="count_addname2">140</div>
                </div>
            </div>
            <div class="popupper-form-row">
                <div class="popupper-form-fieldbox">
                    <input type="text" name="concept_result" id="addresult" class="popupper-add-field count_count" autocomplete="off" tabindex="4" placeholder="какого результата вы ждёте?" max_count="70">
                    <div class="popupper-form-word_counter" id="count_addresult">70</div>
                </div>
            </div>
            <div class="popupper-add-picbox tac" id="dropzone">
                <p id="img_foto_text">
                    <span class="popupper-add-picbox-title">можно добавить фото</span>
                </p>
                <p>
                    <span class="popupper-add-btn" id="concept_foto_add"><i class="icon download-icon"></i> Загрузить</span>
                </p>
                <div class="popupper-add-photo">
                    <img src="/public/img/nophoto.jpg" style="width: 150px; height: 120px; display: none;" id="img_foto" />
                    <div class="profile-change-avatar" id="remove_click_add"><i class="icon remove-icon"></i></div>
                </div>
                <div id="ie8fotoupload"></div>
                <input type="file" style="display: none;" name="File" id="concept_foto_add_input">
                <div id="concept_file_progress" style="display:none;">
                    <progress max="100" value="0" id="concept_file_progress_barr"></progress>
                </div>
            </div>
            <div class="popupper-add-tagsbox">
                {*<input type="text" name="tagsinput" id="tagsinput" class="popupper-add-tags-hidden-input" value="">
                <span class="popupper-add-tag-item"><a href="#" class="popupper-add-tag-link">зима <i class="icon delete-tag-icon"></i></a></span>
                <span class="popupper-add-tag-item"><a href="#" class="popupper-add-tag-link">тепло <i class="icon delete-tag-icon"></i></a></span>
                <span class="popupper-add-tag-item"><a href="#" class="popupper-add-tag-link">необычное <i class="icon delete-tag-icon"></i></a></span>*}
                <span class="dib popupper-add-tag-container" id="popupper-add-tag-container">
                    <span class="popupper-add-tag-item popupper-add-tag-add"><a href="#" class="popupper-add-tag-add-link"><i class="icon add-tag-icon"></i> тег</a></span>
                    <input type="text" id="addtag" class="popupper-add-tag-input" style="display: none;">
                </span>
            </div>
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
                    <div class="popupper-add-anonim-trigger off" id="is_anonimus"><span class="popupper-add-anonim-trigger-text">выкл</span><span class="popupper-add-anonim-trigger-pic"></span></div>
                </div>
                <button class="btn popupper-add-f-btn right">Опубликовать</button>
            </div>
        </form>
    </div><!-- /Popupper-add -->
    <div class="popupper popupper-success">
        Ваша идея успешно опубликована!
    </div>
    {literal}
    <script type="text/javascript">
        var popupperAddFile = new Object()
        var popupperAddFileNum = []
        $(function() {
            var popupperAddTag = new Object()
            var popupperAddTagNum = []
            //var popupperAddFile = new Object()
            //var popupperAddFileNum = []
            /*$("#drag_and_drop").bind( // #drop-block блок куда мы будем перетаскивать наши файлы
                'dragenter',
                function(e) {
                    // Действия при входе курсора с файлами  в блок.
                    console.log('11111');
                }) .bind(
                'dragover',
                function(e) {
                    // Действия при перемещении курсора с файлами над блоком.
                    console.log('222222');
                }).bind(
                'dragleave',
                function(e) {
                    // Действия при выходе курсора с файлами за пределы блока.
                    console.log('3333');
                }).bind(
                'drop',
                function(e) { // Действия при «вбросе» файлов в блок.
                    console.log(e);
                    e.preventDefault();
                    e.stopPropagation();
                    if (e.originalEvent.dataTransfer.files.length) {
                        
                        // Отменяем реакцию браузера по-умолчанию на перетаскивание файлов.
                        e.preventDefault();
                        e.stopPropagation();
                        alert("!");
                        // e.originalEvent.dataTransfer.files — массив файлов переданных в браузер.
                        // e.originalEvent.dataTransfer.files[i].size — размер отдельного файла в байтах.
                        // e.originalEvent.dataTransfer.files[i].name — имя отдельного файла.
                        // Что какбэ намекает :-)
                                
                        //upload(e.originalEvent.dataTransfer.files); // Функция загрузки файлов.
                    }
                });*/
            var dropzone = document.getElementById("dropzone");
            dropzone.ondragover = function() {
                //this.className = 'dropzone dragover';
                //console.log('Отпустите мышку');
                return false;
               };
            dropzone.ondrop = function(e) {
                //this.className = 'dropzone';
                //this.innerHTML = 'Перетащите файлы сюда';
                e.preventDefault();
                //console.log(e.dataTransfer.files)
                files = e.dataTransfer.files
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
                return false;
               };





            $(".count_count").keypress(function(){
                var id = $(this).attr('id');
                var max_count = $(this).attr('max_count');
                var new_id = '#count_' + id;
                var count = $(this).val().length;
                var result = (max_count - count)+1;
                if (result<1) {
                    var text = $(this).val().substr(0, max_count)
                    $(this).val(text);
                };
                $(new_id).html(result);
            })
            $("#remove_click_add").click(function(){
                $("#img_foto").hide();
                $("#concept_foto").val('');
                $("#popupper-add-photo").hide();
                return false;
            })
            //  Теги
            $(".popupper-add-tag-add-link").click(function(){
                var css = $("#addtag").css('display');
                if (css == 'none') {
                    $("#addtag").show();
                    $("#addtag").val('');
                    $("#addtag").focus();
                } else{
                    var tag = $("#addtag").val();
                    tag = $.trim(tag);
                    if(tag!=''){
                        tag = tag.substr(0, 32)
                        if (!popupperAddTag[tag]) {
                            var id = popupperAddTagNum.length
                            popupperAddTag[tag] = 1;
                            popupperAddTagNum[popupperAddTagNum.length] = tag;
                            var text ='<span class="popupper-add-tag-item" id="b' + id + '"><a href="#" class="popupper-add-tag-link" id="a' + id + '"><input type="hidden" name="tags[]" value="' + tag + '" />' + tag + ' <i class="icon delete-tag-icon" id="d' + id + '" aid="' + id + '"></i></a></span>'
                            //var text = '<li class="popupper-add-tag-item" id="b' + id + '"><a href="#" class="popupper-add-tag-link" id="a' + id + '"><input type="hidden" name="tags[]" value="' + tag + '" />' + tag + ' <span class="icon delete-tag-icon" id="d' + id + '" aid="' + id + '"></span></a></li>';
                            $("#popupper-add-tag-container").before(text);
                            var aid = '#a' + id
                            $(aid).click(function(){return false;})
                            var bid = '#b' + id
                            $(bid).click(function(){return false;})
                            var did = '#d' + id
                            $(did).click(function(){
                                //alert("Удаляем");
                                var id = $(this).attr('aid');
                                var bid = '#b' + id
                                $(bid).remove();
                                var t = popupperAddTagNum[id];
                                delete popupperAddTag[t];
                                return false;
                            })
                        }
                    }
                    $("#addtag").hide();
                };
                return false;
            })
            //  Отправка формы
            $("#popupper-form-concept-add").submit(function(){
                var nosubmit = false;
                //  Проверка на заполненность полей
                if($("#addname").val()==''){
                    $("#addname").attr('placeholder','Не заполнено! Введите название');
                    $("#addname").attr('title','Не заполнено! Введите название');
                    nosubmit = true;
                }
                if($("#addname1").val()==''){
                    $("#addname1").attr('placeholder','Не заполнено! Опишите проблему');
                    $("#addname1").attr('title','Не заполнено! Опишите проблему');
                    nosubmit = true;
                }
                if($("#addname2").val()==''){
                    $("#addname2").attr('placeholder','Не заполнено! Опишите решение');
                    $("#addname2").attr('title','Не заполнено! Опишите решение');
                    nosubmit = true;
                }
                if($("#addresult").val()==''){
                    $("#addresult").attr('placeholder','Не заполнено! Опишите результат');
                    $("#addresult").attr('title','Не заполнено! Опишите результат');
                    nosubmit = true;
                }
                if (nosubmit) {
                    return false;
                };
                //  Если есть класс то публикуем Как обычно
                if(!$("#is_anonimus").hasClass("off")){
                    var text = '<input type="hidden" name="concept_anonimus" value="1" />';
                    $("#is_anonimus_data").html(text);
                }
                //return false;
            })
            //  Отправка файлов
            if (window.FormData === undefined) {
                $("#concept_foto_add").hide();
                //$("#concept_foto_add_input").show();
                //  сначала создаем форму
                form = document.createElement('form');
                form.setAttribute('action', '/ajax/file/uploadifyUpload/');
                form.setAttribute('method', 'post');
                form.setAttribute('enctype', 'multipart/form-data');
                form.setAttribute('target', 'frame_foto');
                //  Создаем хидден
                hidden = document.createElement('input');
                hidden.setAttribute('type', 'hidden');
                hidden.setAttribute('name', 'md5_key');
                hidden.setAttribute('value', '{/literal}{$index_md5_key}{literal}_1');
                form.appendChild(hidden);
                //  Создаем инпут
                input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('name', 'Filedata');
                input.setAttribute('id', 'iframe_foto_upload');
                // Навешиваем на INPUT обработчик события onChange
                if (input.addEventListener){
                  input.addEventListener("change", function() {upload()}, false);
                }else{
                  input.attachEvent("onchange", function() {upload()});
                }
                form.appendChild(input);
                //  Помещаем форму в див
                var div_form = document.getElementById("ie8fotoupload")
                //  Помещаем форму в оболочку
                div_form.appendChild(form);
                // Создаём IFRAME (сразу с атрибутом name) и устанавливаем значения атрибутов
                frame = document.createElement('iframe');
                frame.setAttribute('src', '/ajax/file/uploadifyUpload/');
                frame.setAttribute('name', 'frame_foto');
                // Создаём DIV обёртку для IFRAME
                var wrapper = document.createElement('DIV');
                // Помещаем IFRAME в DIV обёртку
                wrapper.appendChild(frame);
                // Делаем обёртку (и её содержимое) невидимой
                wrapper.style.display = 'none';
                // Помещаем невидимую DIV обёртку содержащую IFRAME на страницу
                document.body.appendChild(wrapper);
                function upload() {
                    form.submit();
                    $("#iframe_foto_upload").hide();
                    setTimeout(function() {
                      var data = frame.contentWindow.document.body.innerHTML;
                      console.log(data);
                      var myObject = eval('(' + data + ')');
                        if (myObject.error) {
                            console.log(myObject.error);
                        } else{
                            var src = '/i/150/' + myObject.file_name
                            $("#concept_foto").val(myObject.file_name);
                            $("#img_foto").attr("src", src);
                            $("#img_foto").show();
                            $("#img_foto_text").hide();
                            //$("#concept_foto_add").show();
                            $("#concept_file_progress").hide();
                            $("#popupper-add-photo").show();
                        };
                    }, 5000)
                }
            }else{
                $("#file_upload").click(function(){
                    $("#file_upload_input").trigger('click');
                    $("#file_upload_input").change(function () {
                        var t_file_name = $("#file_upload_input").val();
                        if (t_file_name!='') {
                            var name = this.files[0].name;
                            if (!popupperAddFile[name]) {
                                popupperAddFile[name]=name;
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
                        }
                    })
                    return false;
                })
                //  Загрузка фото
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
            }
        });
    </script>
    {/literal}
</body>
</html>