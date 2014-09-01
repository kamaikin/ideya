<aside role="complementary" class="sidebar right">
    <div class="widget hall_of_fame-widget">
        <h2 class="widgettitle tac">Зал славы</h2>
        <ul class="hall_of_fame-list">
        {foreach from=$RightSidebarIdea item="value" key="key"}
            <li class="hall_of_fame-item {$RightSidebarIdea_array[$key]}"><a href="/concept/{$value.id}.html" class="post-title-link">{$value.name}</a></li>
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
    </div><!--end tags-widget-->
</aside><!--end sidebar-->