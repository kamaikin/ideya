<section role="section" class="main-section left">
<article class="post clearfix">
    {if $index_user_role == 'sponsor' ||  $index_user_role == 'admin'}
        {if $Concept_data.add_sponsor == 'y'}
            <a href="#" class="post-sponsorbox" id="add_sponsor">спонсировать</a>
        {/if}
    {/if}
    {if $Concept_data.add_licke == 'y'}
        <a href="#" class="post-likebox" id="add_licke"><i class="heart_white_big-icon"></i></a>
    {/if}
    <div class="post-thumbnail left">
        {if $Concept_data.foto==''}<img src="/public/img/nophoto.jpg" alt="" class="post-thumbnail-img">{else}<img src="/i/126/{$Concept_data.foto}" alt="" class="post-thumbnail-img">{/if}
        <div class="post-author tac">
            <div class="post-author-pic">
                {if $Concept_data.anonimus == 'n'}<a href="/user/profile/{$Concept_data.user_id}.html">{/if}<img src="{if $Concept_data.anonimus == 'y'}/public/img/nophoto.jpg{else}{if $Concept_data.user_avatar!=''}/i/41/{$Concept_data.user_avatar}{else}/public/img/nophoto.jpg{/if}{/if}" alt="" class="post-author-ava">{if $Concept_data.anonimus == 'n'}</a>{/if}
            </div>
            {if $Concept_data.anonimus == 'n'}<a href="/user/profile/{$Concept_data.user_id}.html" class="post-author-link">{/if}{if $Concept_data.anonimus == 'n'}{$Concept_data.surname} {$Concept_data.name}{else}Аноним{/if}{if $Concept_data.anonimus == 'n'}</a>{/if}
        </div>
    </div>
    <div class="post-info right">
        <div class="post-rating orange">{$Concept_data.points}</div>
        <ul class="info-list tar">
            <li class="info-list-item post-like" id="post_like">{$Concept_data.post_like}</li>
            <li class="info-list-item post-comment">{$Concept_data.comment_count}</li>
            <li class="info-list-item post-date">{$Concept_data.date|date_format:"%d-%m-%y"}</li>
        </ul>
    </div>
    <div class="post-content">
        <div class="post-title">
            <span class="post-title-stat" title="{$Concept_data.concept_name}">{$Concept_data.concept_name}</span>
            {*<a href="#" class="icon ok_green-icon"></a>*}
            {*<span class="icon clip_grey-icon"></span>*}
            {if $Concept_data.implemented == "y"}<a href="#" class="icon ok_green-icon"></a>{/if}
            {if $Concept_data.sponsors}<a href="#" class="icon money_orange-icon"></a>{/if}
            {if $Concept_data.file_1}<a href="/d/{$Concept_data.file_1}" class="icon clip_green-icon tip-js" data-tip_message="{if $Concept_data.file_1}<a herf='/d/{$Concept_data.file_1}'>{$Concept_data.file_1_name}</a><br>{/if}{if $Concept_data.file_2}<a herf='/d/{$Concept_data.file_2}'>{$Concept_data.file_2_name}</a><br>{/if}{if $Concept_data.file_3}<a herf='/d/{$Concept_data.file_3}'>{$Concept_data.file_3_name}</a><br>{/if}" data-tip_class="tip"></a>{/if}
        </div>
        <ul class="post-text-list">
            <li class="post-text-item"><strong>Проблема:</strong> {$Concept_data.concept_problem}</li>
            <li class="post-text-item"><strong>Решение:</strong> {$Concept_data.concept_solution}</li>
            <li class="post-text-item"><strong>Результат:</strong> {$Concept_data.concept_result}</li>
        </ul>
        <ul class="post-tags">
            {foreach from=$Concept_data.tags item="value"}
                <li class="post-tag"><a href="/tags/{$value.url}.html" class="post-tag-link">{$value.name}</a></li>
            {/foreach}
        </ul>
        {if $Concept_data.sponsors}
        <ul class="post-sponsors">
            <li class="dib post-sponsors-title">Спонсоры:</li>
            {foreach from=$Concept_data.sponsors item="value"}
            <li class="dib post-sponsors-item">
                <a href="/user/profile/{$value.user_id}.html"><img width="32" src="{if $value.avatar==''}/public/img/noavatar.gif{else}/i/50/{$value.avatar}{/if}" alt="" class="sponsors-tip-js" data-tip_message="{$value.name} {$value.surname}" data-tip_class="sponsors-tip"></a>
            </li>
            {/foreach}
        </ul>
        {/if}
    </div>
</article>
<div class="post-comments">
    {foreach from=$Concept_comment item="value"}
    <div class="post-comment-bl clearfix"><a name="comment{$value.id}" ></a>
        {if $index_user_role == 'moderator' ||  $index_user_role == 'admin'}
            <div class="post-comment-bl-delete-box">
                <a href="#" class="post-comment-bl-delete-box-link" kid="{$value.id}">
                    Удалить <i class="icon wastebasket-icon"></i>
                </a>
                <form action="#" class="post-comment-bl-delete-cloud" id="delete_comment_info_{$value.id}">
                    <h2 class="post-comment-bl-delete-cloud-title">Причина удаления</h2>
                    <textarea name="deleteArea" id="deleteArea_{$value.id}" class="post-comment-bl-delete-cloud-area" placeholder="Напишите причину удаления"></textarea>
                    <div class="post-comment-bl-delete-cloud-button">
                        <button class="btn moderator_delete" delete="{$value.id}">Отправить</button>
                    </div>
                </form>
            </div>
        {/if}
        <div class="post-comment-bl-edit-box">
            <a href="#" class="post-comment-bl-edit-box-link">
                Редактировать <i class="icon penci-icon"></i>
            </a>
        </div>
        {if $value.user_id==$index_user_id}{if $timemetka < $value.date}<a href="/concept/deletecomment?id={$value.id}&rid={$Concept_data.id}" class="post-comment-bl-delete"></a>{/if}{/if}
        <div class="post-comment-bl-ava left">
            <img src="{if $value.avatar==''}/public/img/noavatar.gif{else}/i/50/{$value.avatar}{/if}" alt="" width="50px" class="post-comment-bl-img">
        </div>
        <div class="post-comment-bl-body">
            <h2 class="post-comment-bl-name"><a href="/user/profile/{$value.user_id}.html" class="post-comment-bl-name-link" id="name_{$value.id}">{$value.surname} {$value.name}</a></h2>
            <div class="post-comment-bl-content post-comment-bl-content-js" id="body_{$value.id}">
                <div class="comment-content">{$value.body|nl2br}</div>
                <div class="comment-content-more">
                    <p>...</p>
                    <p><span class="more-comment-link more-comment-link-js">Развернуть комментарий</span></p>
                </div>
            </div>
            <div class="post-comment-bl-footer">
                <span class="post-comment-bl-time">{$value.date|date_format:"%d-%m-%y %T"}</span>
                <a href="#comment" class="post-comment-bl-retweet" data="{$value.id}">Ответить</a>
            </div>
        </div>
    </div>
    {/foreach}
    <a name="comment" ></a>
    <div class="post-addcomment">
        <div class="post-addcomment-title">Ваш комментарий:</div>
        <form action="" class="post-addcomment-body clearfix" method="POST">
            <div class="post-addcomment-ava left">
                <img src="{if $index_user_avatar!=''}/i/40/{$index_user_avatar}{else}/public/img/noavatar.gif{/if}" alt="" width="40px" class="post-addcomment-img">
            </div>
            <div class="post-addcomment-content">
                <textarea name="body" id="addcomment" class="field post-addcomment-area"></textarea>
                <div class="post-addcomment-button tar">
                    <button class="btn">Отправить</button>
                </div>
            </div>
        </form>
    </div>
</div>
</section>
<script type="text/javascript">
    {literal}
    $(function() {

    })
    {/literal}
</script>
{if $Concept_data.add_licke == 'y'}
<script type="text/javascript">
    {literal}
    $(function() {
        $(".post-comment-bl-retweet").click(function(){
            var data = $(this).attr('data');
            var body = '#body_' + data;
            var name = '#name_' + data;
            text = 'Пользователь: ' + $(name).text() + ' Писал: ' + $(body).text() + "\n===========\n";
            $("#addcomment").val(text);

        })
        $("#add_licke").click(function(){
            //  Передаем лайк
            $.post('/ajax/concept/likeadd/?id={/literal}{$Concept_data.id}{literal}', function(data){
                //console.log(data)
                location.href = location.href;
            })
            // ***
            var points = Number($(".post-rating").text());
            points = points +10;
            $(".post-rating").text(points);
            //  Добавляем в счетчик
            var like = Number($("#post_like").text());
            like = like +1;
            $("#post_like").text(like);
            //  Скрываем иконку
            $("#add_licke").hide();
            return false;
        })
    })
    {/literal}
</script>
{/if}
{if $index_user_role == 'moderator' ||  $index_user_role == 'admin'}
<script type="text/javascript">
    {literal}
    $(function() {
        $(".moderator_delete").click(function(){
            var id = $(this).attr("delete");
            var text_id = "#deleteArea_" + id;
            var text = $(text_id).val();
            var url = '/ajax/concept/deletecomment/?id={/literal}{$Concept_data.id}{literal}&comment_id=' + id;
            var post = 'text=' + text;
            $.post(url, post, function(data){
                location.href=location.href;
            })
            return false;
        })
    })
    {/literal}
</script>
{/if}
{if $index_user_role == 'sponsor' ||  $index_user_role == 'admin'}
{if $Concept_data.add_sponsor == 'y'}
<script type="text/javascript">
    {literal}
    $(function() {
        $("#add_sponsor").click(function(){
            //  Передаем лайк
            $.post('/ajax/concept/sponsoradd/?id={/literal}{$Concept_data.id}{literal}', function(data){
                //  Перезагружаем страницу когда пришел ответ...
                location.href = location.href;
                //console.log(data);
            })
            //  Скрываем иконку
            $("#add_sponsor").hide();
            return false;
        })
    })
    {/literal}
</script>
{/if}
{/if}