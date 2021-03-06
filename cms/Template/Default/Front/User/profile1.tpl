<section role="section" class="main-section left">
    <h1 class="page-title">Мой профиль</h1>
    <div class="profilebox clearfix">
        <div class="profile-pic left">
            <div class="profile-avatar">
            	{if $user_info.avatar==''}
					<img src="/public/img/nophoto.jpg" alt="" class="profile-image"  id="img_avatar">
				{else}
					<img src="/i/150/{$user_info.avatar}" alt="" class="profile-image" id="img_avatar">
				{/if}
            </div>
            <ul class="profile-pic-bar tac">
                {*<li class="profile-pic-bar-item dib">
                    <span class="icon delete-pic-icon"></span>
                </li>*}
            </ul>
        </div>
        <div class="profile-infobox right">
            <div class="profile-points">
                <div class="profile-points-title">Баллы Пользователя</div>
                <div class="profile-points-num">
                    <span class="profile-points-num-line"></span>
                    <span class="profile-points-num-val">{$user_info.points}</span>
                </div>
                {*<div class="points-tooltip profile-points-tooltip points-tooltip-top">
                    Вы сейчас на 1 месте в рейтинге пользователей
                </div>*}
            </div>
            <div class="profile-info table">
                <div class="profile-info-cell cell">{$user_info.concept_count}</div>
                <div class="profile-info-cell cell"><i class="icon like-icon"></i> {$user_info.summ_post_like}</div>
                <div class="profile-info-cell cell"><i class="icon comment-icon"></i> {$user_info.comment_count}</div>
            </div>

        </div>
        <div class="profilebox-content profilebox-content-user">
            <div class="profile-form-row wrapper">
                <div class="profile-form-labelbox left">
                    <label for="name" class="profile-form-label">Имя</label>
                </div>
                <div class="profile-form-fieldbox">{$user_info.name}</div>
            </div>
            <div class="profile-form-row wrapper">
                <div class="profile-form-labelbox left">
                    <label for="surname" class="profile-form-label">Фамилия</label>
                </div>
                <div class="profile-form-fieldbox">{$user_info.surname}
                </div>
            </div>
            <div class="profile-form-row wrapper">
                <div class="profile-form-labelbox left">
                    <label for="email" class="profile-form-label"></label>
                </div>
                <div class="profile-form-fieldbox">
                </div>
            </div>
        </div>
    </div>
    </form>
    <br /><br />
    <!--tabs-->
    <div class="tabs-section tabs-section-js prifile-tab">
        <ul class="tabs tabs-js">
            <li class="tab tab-current"><div class="prifile-tab-box">Идеи{if $count_user_concept>0}<span class="notificare">{$count_user_concept}</span>{/if}</div></li>
            <li class="tab"><div class="prifile-tab-box"><i class="icon comment"></i> Комментарии{if $count_user_comment>0}<span class="notificare">{$count_user_comment}</span>{/if}</div></li>
        </ul>
        <div class="tab-content posts-lists tab-content-js tab-content-visible">
        	{*Мои идеи*}
            <ul class="sortbar">
                <li class="sortbar-item sortbar-title">Сортировать: </li>
                <li class="sortbar-item"><a href="/user/profile/{$smarty.get.url}.html?sort=date&order={if $smarty.get.order=='asc'}desc{else}asc{/if}" class="sort-link {if $smarty.get.order=='asc'}up{else}down{/if}">по дате <i class="icon sort-icon"></i></a></li>
                <li class="sortbar-item"><a href="/user/profile/{$smarty.get.url}.html?sort=raiting&order={if $smarty.get.order=='asc'}desc{else}asc{/if}" class="sort-link {if $smarty.get.order=='asc'}up{else}down{/if}">по рейтингу <i class="icon sort-icon"></i></a></li>
            </ul>
        	{foreach from=$user_concept item="value"}
            <article class="post{if $value.date > $notificare_time} notificare-post{/if}">
                <div class="post-thumbnail left">
                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<a href="/i/126/{$value.foto}" data-lightbox="{$value.foto}"><img src="/i/126/{$value.foto}" alt="{$value.foto}" class="post-thumbnail-img" /></a>{/if}
                </div>
                <div class="post-info right">
                    <div class="post-rating pink">{$value.points}</div>
                    <ul class="info-list tar">
                        <li class="info-list-item post-like">{$value.post_like}</li>
                        <li class="info-list-item post-comment">{$value.comment_count}</li>
                    </ul>
                </div>
                <div class="post-content">
                    <div class="post-title">
                        <a href="/concept/{$value.id}.html" class="post-title-link">{$value.name}</a>
                        {if $value.sponsors}<i class="icon money_orange-icon"></i>{/if}
                    </div>
                    <ul class="post-tags">
                        {*<li class="post-tag"><a href="#" class="post-tag-link">зима</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">тепло</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">необычное</a></li>*}
                    </ul>
                    <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
                    {if $value.sponsors}
                    <ul class="post-sponsors">
                        <li class="dib post-sponsors-title">Спонсоры:</li>
                        {foreach from=$value.sponsors item="value1"}
                        <li class="dib post-sponsors-item">
                            <a href="/user/profile/{$value1.user_id}.html"><img width="32" src="{if $value1.avatar==''}/public/img/noavatar.gif{else}/i/50/{$value1.avatar}{/if}" alt="" class="sponsors-tip-js" data-tip_message="{$value1.name} {$value1.surname}" data-tip_class="sponsors-tip"></a>
                        </li>
                        {/foreach}
                    </ul>
                    {/if}
                </div>
            </article>
            {/foreach}
        </div>
        <div class="tab-content posts-lists tab-content-js">
        {*Мои комментарии*}
        {foreach from=$user_comment item="value"}
        <article class="post{if $value.date > $notificare_time} notificare-post{/if}">
            <div class="post-thumbnail left">
            {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<a href="/i/126/{$value.foto}" data-lightbox="{$value.foto}"><img src="/i/126/{$value.foto}" alt="{$value.foto}" class="post-thumbnail-img" /></a>{/if}
            </div>
            <div class="post-content">
                <div class="post-title">
                    <a href="/concept/{$value.id}.html#comment{$value.cid}" class="post-title-link">{$value.name}</a>
                    {if $value.sponsors}<i class="icon money_orange-icon"></i>{/if}
                </div>
                <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
                {if $value.sponsors}
                <ul class="post-sponsors">
                    <li class="dib post-sponsors-title">Спонсоры:</li>
                    {foreach from=$value.sponsors item="value1"}
                    <li class="dib post-sponsors-item">
                        <a href="/user/profile/{$value1.user_id}.html"><img width="32" src="{if $value1.avatar==''}/public/img/noavatar.gif{else}/i/50/{$value1.avatar}{/if}" alt="" class="sponsors-tip-js" data-tip_message="{$value1.name} {$value1.surname}" data-tip_class="sponsors-tip"></a>
                    </li>
                    {/foreach}
                </ul>
                {/if}
                <div class="post-comment-body break">
                    {$value.body}
                </div>
            </div>
        </article>
        {/foreach}
        </div>
    </div>
    <!--end tabs-->
</section><!--end main-section-->