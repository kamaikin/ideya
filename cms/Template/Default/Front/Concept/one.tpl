<section role="section" class="main-section left">
<article class="post clearfix">
    {if $index_user_role == 'sponsor' ||  $index_user_role == 'moderator' ||  $index_user_role == 'admin'}
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
            <a href="#" class="icon ok_green-icon"></a>
            <span class="icon clip_grey-icon"></span>
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
        <ul class="post-sponsors">
            <li class="dib post-sponsors-title">Спонсоры:</li>
            {foreach from=$Concept_data.sponsors item="value"}
            <li class="dib post-sponsors-item">
                <a href="/user/profile/{$value.user_id}.html"><img src="{if $value.avatar==''}/public/img/noavatar.gif{else}/i/50/{$value.avatar}{/if}" alt="" class="sponsors-tip-js" data-tip_message="{$value.name} {$value.surname}" data-tip_class="sponsors-tip"></a>
            </li>
            {/foreach}
        </ul>
    </div>
</article>
<div class="post-comments">
    {foreach from=$Concept_comment item="value"}
    <div class="post-comment-bl clearfix"><a name="comment{$value.id}" />
        {if $value.user_id==$index_user_id}<a href="/concept/deletecomment?id={$value.id}&rid={$Concept_data.id}" class="post-comment-bl-delete"></a>{/if}
        <div class="post-comment-bl-ava left">
            <img src="{if $value.avatar==''}/public/img/noavatar.gif{else}/i/50/{$value.avatar}{/if}" alt="" width="50px" class="post-comment-bl-img">
        </div>
        <div class="post-comment-bl-body">
            <h2 class="post-comment-bl-name"><a href="#" class="post-comment-bl-name-link">{$value.surname}{$value.name}</a></h2>
            <div class="post-comment-bl-content">
                {$value.body}
            </div>
            <div class="post-comment-bl-footer">
                <span class="post-comment-bl-time">{$value.date|date_format:"%d-%m-%y %T"}</span>
                <a href="#comment" class="post-comment-bl-retweet">Ответить</a>
            </div>
        </div>
    </div>
    {/foreach}
    <a name="comment" />
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
{if $Concept_data.add_licke == 'y'}
<script type="text/javascript">
    {literal}
    $(function() {
        $("#add_licke").click(function(){
            //  Передаем лайк
            $.post('/ajax/concept/likeadd/?id={/literal}{$Concept_data.id}{literal}', function(data){
                //console.log(data)
            })
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
{if $index_user_role == 'sponsor' ||  $index_user_role == 'moderator' ||  $index_user_role == 'admin'}
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