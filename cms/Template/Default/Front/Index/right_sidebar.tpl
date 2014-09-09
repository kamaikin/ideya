<aside role="complementary" class="sidebar right">
    <div class="widget subscriptions-widget">
        <h2 class="widgettitle tac">Управление подписками</h2>
        <form action="#" class="subscriptions-form">
            <div class="subscriptions-row clearfix">
                <div class="trigger off subscriptions-trigger left subscriptions-trigger-js">
                    <span class="trigger-text">выкл</span>
                    <span class="trigger-pic"></span>
                    <input type="hidden" name="subscriptions-comment" value="выкл">
                </div>
                <div class="subscriptions-text">получать уведомления о комментариях</div>
            </div>
            <div class="subscriptions-row clearfix">
                <div class="trigger off subscriptions-trigger left subscriptions-trigger-js">
                    <span class="trigger-text">выкл</span>
                    <span class="trigger-pic"></span>
                    <input type="hidden" name="subscriptions-points" value="выкл">
                </div>
                <div class="subscriptions-text">получать уведомления о оценках</div>
            </div>
            <div class="subscriptions-row clearfix">
                <div class="trigger off subscriptions-trigger left subscriptions-trigger-js">
                    <span class="trigger-text">выкл</span>
                    <span class="trigger-pic"></span>
                    <input type="hidden" name="subscriptions-sponsors" value="выкл">
                </div>
                <div class="subscriptions-text">получать уведомления о спонсорах</div>
            </div>
            <p class="subscriptions-button tac">
                <button class="btn">Отправить</button>
            </p>
        </form>
    </div><!--end subscriptions-widget-->
    <div class="widget hall_of_fame-widget">
        <h2 class="widgettitle tac">Рейтинг идей</h2>
        <ul class="hall_of_fame-list">
        {foreach from=$RightSidebarIdea item="value" key="key"}
            <li class="hall_of_fame-item {$RightSidebarIdea_array[$key]}"><a href="/concept/{$value.id}.html" class="post-title-link" title="{$value.name}">{$value.name}</a></li>
        {/foreach}
        </ul>
        <div class="more-ideas tac">
            <a href="/" class="more-idea-link">Еще идеи</a>
        </div>
    </div><!--end hall_of_fame-widget-->
    <div class="widget tags-widget">
        <h2 class="widgettitle">Теги</h2>
        <ul class="tags-widget-list">
            {$tags}
        </ul>
        <div class="more-ideas tac">
            <a href="/tags/" class="more-idea-link">Еще теги</a>
        </div>
    </div><!--end tags-widget-->
</aside><!--end sidebar-->