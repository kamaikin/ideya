<!-- <div class="grid"></div> -->
<section role="section" class="main-section left">
    <ul class="visualbar tac">
        <a href="/concept/selectvid/?vid=lists&uri={$smarty.server.REQUEST_URI}"><li class="dib visualbar-item lists{if $smarty.session.view|default:'lists' == 'lists'} active{/if}"></li></a>
        <a href="/concept/selectvid/?vid=blocks&uri={$smarty.server.REQUEST_URI}"><li class="dib visualbar-item blocks{if $smarty.session.view|default:'lists' == 'blocks'} active{/if}"></li></a>
    </ul>
    {if $smarty.session.view|default:'lists' == 'lists'}
    <div class="posts posts-lists">
        {foreach from=$data item="value"}
        <article class="post">
            <div class="post-thumbnail left">
                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<img src="/i/126/{$value.foto}" alt="" class="post-thumbnail-img" />{/if}
            </div>
            <div class="post-info right">
                <div class="post-rating pink">{$value.points}</div>
                <ul class="info-list tar">
                    <li class="info-list-item post-like">{$value.postLike}</li>
                    <li class="info-list-item post-comment">{$value.comment_count}</li>
                </ul>
            </div>
            <div class="post-content">
                <div class="post-title">
                    <a href="/concept/{$value.id}.html" class="post-title-link">{$value.name}</a>
                    {if $value.implemented == "y"}<a href="#" class="icon ok_green-icon"></a>{/if}
                    {if $value.sponsors=='y'}
                    <a href="#" class="icon money_orange-icon"></a>
                    {/if}
                    {if $value.file_1}<a href="/d/{$value.file_1}" class="icon clip_green-icon tip-js" data-tip_message="{if $value.file_1}<a herf='/d/{$value.file_1}'>{$value.file_1_name}</a><br>{/if}{if $value.file_2}<a herf='/d/{$value.file_2}'>{$value.file_2_name}</a><br>{/if}{if $value.file_3}<a herf='/d/{$value.file_3}'>{$value.file_3_name}</a><br>{/if}" data-tip_class="tip"></a>{/if}
                </div>
                <ul class="post-tags">
                    {foreach from=$value.tags item="item"}
                    <li class="post-tag"><a href="/tags/{$item.url}.html" class="post-tag-link">{$item.name}</a></li>
                    {/foreach}
                </ul>
                <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
            </div>
        </article>
        {foreachelse}
        <article class="post">
        Ничего не найдено.
        </article>
        {/foreach}
    </div>
    {/if}
    {if $smarty.session.view|default:'lists' == 'blocks'}
    <div class="posts posts-blocks">
        {foreach from=$data item="value"}
        <article class="post">
            <div class="post-thumbnail left">
                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<img src="/i/126/{$value.foto}" alt="" class="post-thumbnail-img" />{/if}
            </div>
            <div class="post-content">
                <div class="post-title">
                    <a href="/concept/{$value.id}.html" class="post-title-link">{$value.name}</a>
                    {if $value.implemented == "y"}<a href="#" class="icon ok_green-icon"></a>{/if}
                    {if $value.sponsors=='y'}
                    <a href="#" class="icon money_orange-icon"></a>
                    {/if}
                    {if $value.file_1}<a href="/d/{$value.file_1}" class="icon clip_green-icon tip-js" data-tip_message="{if $value.file_1}<a herf='/d/{$value.file_1}'>{$value.file_1_name}</a><br>{/if}{if $value.file_2}<a herf='/d/{$value.file_2}'>{$value.file_2_name}</a><br>{/if}{if $value.file_3}<a herf='/d/{$value.file_3}'>{$value.file_3_name}</a><br>{/if}" data-tip_class="tip"></a>{/if}
                </div>
                <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
            </div>
            <ul class="post-tags">
                {foreach from=$value.tags item="item"}
                    <li class="post-tag"><a href="/tags/{$item.url}.html" class="post-tag-link">{$item.name}</a></li>
                {/foreach}
            </ul>
            <div class="post-info">
                <div class="post-rating pink">{$value.points}</div>
                <ul class="info-list tar">
                    <li class="info-list-item post-like">{$value.postLike}</li>
                    <li class="info-list-item post-comment">{$value.comment_count}</li>
                </ul>
            </div>
        </article>
        {foreachelse}
        <article class="post">
        Ничего не найдено.
        </article>
        {/foreach}
    </div>
    {/if}
    <div class="pagenavi">
        {$paginator}
    </div><!--end pagenavi-->
</section><!--end main-section-->