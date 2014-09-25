<section role="section" class="main-section left">
<article class="post clearfix">
<form action="/concept/edit/?id={$data.id}" method="POST" class="popupper-form" id="popupper-form-concept-add">
<input type="hidden" id="concept_foto" name="concept_foto" value="{if $data.foto!=''}{$data.foto}{/if}" />
    <h2 class="popupper-add-title">Редактировать идею</h2>
    <div class="popupper-form-row">
        <div class="popupper-form-fieldbox">
            <input type="text" name="concept_name" id="addname" class="popupper-add-field count_count" autocomplete="off" tabindex="1" placeholder="о чем ваша идея?" max_count="70" value="{$data.name}">
            {*<div class="popupper-form-word_counter" id="count_addname">70</div>*}
        </div>
    </div>
    <div class="popupper-form-row">
        <div class="popupper-form-fieldbox">
            <input type="text" name="concept_decision" id="addname2" class="popupper-add-field count_count" autocomplete="off" tabindex="3" placeholder="что вы предлагаете сделать?" max_count="140" value="{$data.solution}">
            {*<div class="popupper-form-word_counter" id="count_addname2">140</div>*}
        </div>
    </div>
    <div class="popupper-form-row">
        <div class="popupper-form-fieldbox">
            <input type="text" name="concept_result" id="addresult" class="popupper-add-field count_count" autocomplete="off" tabindex="4" placeholder="какого результата вы ждёте?" max_count="70" value="{$data.result}">
            {*<div class="popupper-form-word_counter" id="count_addresult">70</div>*}
        </div>
    </div>
    <div class="popupper-add-picbox tac">
        {if $data.foto==''}
        <p id="img_foto_text">
            <span class="popupper-add-picbox-title">можно добавить фото</span>
        </p>
        {/if}
        <p>
            <span class="popupper-add-btn" id="concept_foto_add"><i class="icon download-icon"></i> Загрузить</span>
        </p>
        <div class="popupper-add-photo">
            <img src="{if $data.foto==''}/public/img/nophoto.jpg{else}/i/150/{$data.foto}{/if}" style="width: 150px; height: 120px;  {if $data.foto!=''}dispalay: block;{else}display: none;{/if}" id="img_foto" />
            <div class="profile-change-avatar" id="remove_click_add"><i class="icon remove-icon"></i></div>
        </div>
        <div id="ie8fotoupload"></div>
        <input type="file" style="display: none;" name="File" id="concept_foto_add_input">
        <div id="concept_file_progress" style="display:none;">
            <progress max="100" value="0" id="concept_file_progress_barr"></progress>
        </div>
    </div>
    <div class="popupper-add-tagsbox">
        {foreach from=$data.tags item="value"}
        <span class="popupper-add-tag-item" id="b{$value.id}"><a href="#" class="popupper-add-tag-link" id="a{$value.id}"><input type="hidden" name="tags[]" value="{$value.name}" />{$value.name} <i class="icon delete-tag-icon" id="d{$value.id}" aid="{$value.id}"></i></a></span>
        {/foreach}
        <span class="dib popupper-add-tag-container" id="popupper-add-tag-container">
            <span class="popupper-add-tag-item popupper-add-tag-add"><a href="#" class="popupper-add-tag-add-link"><i class="icon add-tag-icon"></i> тег</a></span>
            <input type="text" id="addtag" class="popupper-add-tag-input" style="display: none;">
        </span>
    </div>
    <div class="popupper-add-filebox">
        <div class="popupper-add-filebox-title">Прикрепленные файлы:</div>
        <div class="popupper-add-filebox-list" id="file_list">
            {if $data.file_1_name!=''}
            <span id="file_div_1" class="popupper-add-filebox-item"><input type="hidden" value="{$data.file_1_name}" name="file_1_user_name" id="file_1_user_name"><input type="hidden" value="{$data.file_1}" name="file_1_server_name" id="file_1_server_name">{$data.file_1_name} <i class="icon add-file-delete-icon" id="delete_file_div_1" name="{$data.file_1_name}"></i></span>
            {/if}
            {if $data.file_2_name!=''}
            <span id="file_div_2" class="popupper-add-filebox-item"><input type="hidden" value="{$data.file_2_name}" name="file_2_user_name" id="file_2_user_name"><input type="hidden" value="{$data.file_2}" name="file_2_server_name" id="file_2_server_name">{$data.file_1_name} <i class="icon add-file-delete-icon" id="delete_file_div_2" name="{$data.file_2_name}"></i></span>
            {/if}
            {if $data.file_3_name!=''}
            <span id="file_div_3" class="popupper-add-filebox-item"><input type="hidden" value="{$data.file_3_name}" name="file_3_user_name" id="file_3_user_name"><input type="hidden" value="{$data.file_3}" name="file_3_server_name" id="file_3_server_name">{$data.file_3_name} <i class="icon add-file-delete-icon" id="delete_file_div_3" name="{$data.file_3_name}"></i></span>
            {/if}
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
            <div class="popupper-add-anonim-trigger {if $data.anonimus=='n'}off{else}on{/if}" id="is_anonimus"><span class="popupper-add-anonim-trigger-text">{if $data.anonimus=='n'}выкл{else}вкл{/if}</span><span class="popupper-add-anonim-trigger-pic"></span></div>
        </div>
        <button class="btn popupper-add-f-btn right">Сохранить изменения</button>
    </div>
</form>
</article>
</section>
{literal}
    <script type="text/javascript">
    $(function() {
    {/literal}{foreach from=$data.tags item="value"}{literal}
        var aid = '#a' + {/literal}{$value.id}{literal}
        $(aid).click(function(){return false;})
        var bid = '#b' + {/literal}{$value.id}{literal}
        $(bid).click(function(){return false;})
        var did = '#d' + {/literal}{$value.id}{literal}
        $(did).click(function(){
            //alert("Удаляем");
            var id = $(this).attr('aid');
            var bid = '#b' + {/literal}{$value.id}{literal}
            $(bid).remove();
            var t = popupperAddTagNum[{/literal}{$value.id}{literal}];
            delete popupperAddTag[t];
            return false;
        })
    {/literal}{/foreach}{literal}
    {/literal}{if $data.file_1_name!=''}{literal}
      var delete_id = '#delete_file_div_1'
      $(delete_id).click(function(){
        //  Удалить элемент из массива
        var name = $(this).attr('name');
        delete popupperAddFile[name];
        $(id).remove()
        if($(".popupper-add-filebox-item").length > 2){
          //  Скрываем ссылку загрузить файл
          $("#file_upload").hide();
        }else{
          $("#file_upload").show();
        }
        return false;
      })
    {/literal}{/if}{literal}
    {/literal}{if $data.file_2_name!=''}{literal}
        var delete_id = '#delete_file_div_2'
      $(delete_id).click(function(){
        //  Удалить элемент из массива
        var name = $(this).attr('name');
        delete popupperAddFile[name];
        $(id).remove()
        if($(".popupper-add-filebox-item").length > 2){
          //  Скрываем ссылку загрузить файл
          $("#file_upload").hide();
        }else{
          $("#file_upload").show();
        }
        return false;
      })
    {/literal}{/if}{literal}
    {/literal}{if $data.file_3_name!=''}{literal}
        var delete_id = '#delete_file_div_3'
      $(delete_id).click(function(){
        //  Удалить элемент из массива
        var name = $(this).attr('name');
        delete popupperAddFile[name];
        $(id).remove()
        if($(".popupper-add-filebox-item").length > 2){
          //  Скрываем ссылку загрузить файл
          $("#file_upload").hide();
        }else{
          $("#file_upload").show();
        }
        return false;
      })
    {/literal}{/if}{literal}
    })
    </script>
{/literal}