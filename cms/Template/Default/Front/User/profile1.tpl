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
            <li class="tab tab-current">Идеи{if $count_user_concept>0}<span class="notificare">{$count_user_concept}</span>{/if}</li>
            {*<li class="tab"><i class="icon like"></i> Нравится{if $count_my_lacke_concept>0}<span class="notificare">{$count_my_lacke_concept}</span>{/if}</li>
            {if $user_info.user_role == 'sponsor'}
            <li class="tab"><i class="icon sponsor"></i> Спонсоры{if $count_my_sponsor_concept>0}<span class="notificare">{$count_my_sponsor_concept}</span>{/if}</li>
            {/if}
            <li class="tab"><i class="icon money"></i> Спонсирует{if $count_ya_sponsor_concept>0}<span class="notificare">{$count_ya_sponsor_concept}</span>{/if}</li>*}
            <li class="tab"><i class="icon comment"></i> Комментарии{if $count_user_comment>0}<span class="notificare">{$count_user_comment}</span>{/if}</li>
        </ul>
        <div class="tab-content posts-lists tab-content-js tab-content-visible">
        	{*Мои идеи*}
        	{foreach from=$user_concept item="value"}
            <article class="post{if $value.date > $notificare_time} notificare-post{/if}">
                <div class="post-thumbnail left">
                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<img src="/i/126/{$value.foto}" alt="" class="post-thumbnail-img" />{/if}
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
                    </div>
                    <ul class="post-tags">
                        {*<li class="post-tag"><a href="#" class="post-tag-link">зима</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">тепло</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">необычное</a></li>*}
                    </ul>
                    <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
                </div>
            </article>
            {/foreach}
        </div>
        <div class="tab-content posts-lists tab-content-js">
        	{*Мне нравяться*}
        	{foreach from=$my_lacke_concept item="value"}
            <article class="post{if $value.datetime > $notificare_time} notificare-post{/if}">
                <div class="post-thumbnail left">
                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<img src="/i/126/{$value.foto}" alt="" class="post-thumbnail-img" />{/if}
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
                    </div>
                    <ul class="post-tags">
                        {*<li class="post-tag"><a href="#" class="post-tag-link">зима</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">тепло</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">необычное</a></li>*}
                    </ul>
                    <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
                </div>
            </article>
            {/foreach}
        </div>
        {*$index_acl->isAllowed($user_info.user_role, $index_acl_resourse, 'sponsor')*}
        {if $user_info.user_role == 'sponsor'}
        {*Я спонсирую*}
        <div class="tab-content posts-lists tab-content-js">
        {foreach from=$ya_sponsor_concept item="value"}
        	<article class="post{if $value.datetime > $notificare_time} notificare-post{/if}">
                <div class="post-thumbnail left">
	                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<img src="/i/126/{$value.foto}" alt="" class="post-thumbnail-img" />{/if}
	                <div class="post-author tac">
	                    <div class="post-author-pic">
	                        <img src="{if $value.user_avatar==''}/public/img/nophoto.jpg{else}/i/50/{$value.user_avatar}{/if}" alt="" class="post-author-ava">
	                    </div>
	                    <a href="#" class="post-author-link">{$value.user_name} {$value.user_surname}</a>
	                </div>
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
                    </div>
                    <ul class="post-tags">
                        {*<li class="post-tag"><a href="#" class="post-tag-link">зима</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">тепло</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">необычное</a></li>*}
                    </ul>
                    <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
                </div>
            </article>
        	{/foreach}
        </div>
        {/if}
        <div class="tab-content posts-lists tab-content-js">
        {*Меня спонсируют*}
        	{foreach from=$my_sponsor_concept item="value"}
        	<article class="post{if $value.date > $notificare_time} notificare-post{/if}">
                <div class="post-thumbnail left">
	                {if $value.foto==''}<img src="/public/img/nophoto.jpg"  alt="" class="post-thumbnail-img" />{else}<img src="/i/126/{$value.foto}" alt="" class="post-thumbnail-img" />{/if}
	                <div class="post-author tac">
	                    <div class="post-author-pic">
	                        <img src="{if $value.user_avatar==''}/public/img/nophoto.jpg{else}/i/50/{$value.user_avatar}{/if}" alt="" class="post-author-ava">
	                    </div>
	                    <a href="#" class="post-author-link">{$value.user_name} {$value.user_surname}</a>
	                </div>
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
                    </div>
                    <ul class="post-tags">
                        {*<li class="post-tag"><a href="#" class="post-tag-link">зима</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">тепло</a></li>
                        <li class="post-tag"><a href="#" class="post-tag-link">необычное</a></li>*}
                    </ul>
                    <div class="post-date">Дата публикации: {$value.date|date_format:"%d.%m.%y"}</div>
                </div>
            </article>
        	{/foreach}
        </div>
        <div class="tab-content tab-content-js">
        {*Мои комментарии*}
        {foreach from=$user_comment item="value"}
        <article class="post{if $value.date > $notificare_time} notificare-post{/if}">
        	<div class="post-content">
	            <div class="post-title">
	                <a href="/concept/{$value.concept_id}.html#comment{$value.id}" class="post-title-link">{$value.body}</a>
	            </div>
            </div>
        </article>
        {/foreach}
        </div>
    </div>
    <!--end tabs-->
</section><!--end main-section-->