<section role="section" class="main-section left">
    <h1 class="page-title">Мой профиль</h1>
    <form method="POST" actopn="">
	<input type="hidden" id="avatar_name" name="avatar_name" value="{if $user_info.avatar!=''}{$user_info.avatar}{/if}" />
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
                <li class="profile-pic-bar-item fileload dib">
                    <input type="file" name="file1" value="" class="file-input" id="avatar_upload_input">
                    <div id="avatar_progress" style="display:none;">
		            	<progress max="100" value="0" id="avatar_progress_barr" style="width: 100px;"></progress>
		        	</div>
                    <span class="icon fileload-icon fileload-icon-js" id="avatar_upload"></span>
                </li>
                {*<li class="profile-pic-bar-item dib">
                    <span class="icon delete-pic-icon"></span>
                </li>*}
            </ul>
        </div>
        <div class="profile-infobox right">
            <div class="profile-points">
                <div class="profile-points-title">Мои баллы</div>
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
        <div class="profilebox-content">
            <div class="profile-form-row">
                <div class="profile-form-labelbox left">
                    <label for="name" class="profile-form-label">Имя</label>
                </div>
                <div class="profile-form-fieldbox">
                    <input type="text" name="name" id="name" class="field" autocomplete="off" tabindex="1" value="{$user_info.name}">
                </div>
            </div>
            <div class="profile-form-row">
                <div class="profile-form-labelbox left">
                    <label for="surname" class="profile-form-label">Фамилия</label>
                </div>
                <div class="profile-form-fieldbox">
                    <input type="text" name="surname" id="surname" class="field" autocomplete="off" tabindex="2" value="{$user_info.surname}">
                </div>
            </div>
            <div class="profile-form-row">
                <div class="profile-form-labelbox left">
                    <label for="email" class="profile-form-label">e-mail</label>
                </div>
                <div class="profile-form-fieldbox">
                    <input type="email" name="email" id="email" class="field" autocomplete="off" tabindex="1" value="{$user_info.email}">
                </div>
            </div>
            <div class="profile-form-row">
            	<div class="profile-form-labelbox left"></div>
                <div class="profile-form-fieldbox">
            		<button class="btn popupper-add-f-btn right">Сохранить</button>
            	</div>
            </div>
        </div>
    </div>
    </form>
    <br /><br />
    <!--tabs-->
    <div class="tabs-section tabs-section-js prifile-tab">
        <ul class="tabs tabs-js">
            <li class="tab tab-current">Мои идеи</li>
            <li class="tab"><i class="icon like"></i> мне нравится</li>
            {if $user_info.user_role == 'sponsor'}
            <li class="tab"><i class="icon sponsor"></i> я спонсирую</li>
            {/if}
            <li class="tab"><i class="icon money"></i> Меня спонсируют</li>
            <li class="tab"><i class="icon comment"></i> Мои комментарии</li>
        </ul>
        <div class="tab-content posts-lists tab-content-js tab-content-visible">
        	{*Мои идеи*}
        	{foreach from=$user_concept item="value"}
            <article class="post">
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
        <div class="tab-content tab-content-js">
        	{*Мне нравяться*}
        	{foreach from=$my_lacke_concept item="value"}
            <article class="post">
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
        <div class="tab-content tab-content-js">
        {foreach from=$ya_sponsor_concept item="value"}
        	<article class="post">
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
        <div class="tab-content tab-content-js">
        {*Меня спонсируют*}
        	{foreach from=$my_sponsor_concept item="value"}
        	<article class="post">
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
        <article class="post">
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
<script type="text/javascript">
	{literal}
	$(function() {
		$("#avatar_upload").click(function(){
			$("#avatar_upload_input").trigger('click');
			$("#avatar_upload_input").change(function () {
				var t_file_name = $("#avatar_upload_input").val();
				if (t_file_name!='') {
					files = this.files
					$("#avatar_progress").show();
					var rand = Math.floor(Math.random() * (10000 - 1 + 1)) + 1
					var rand_1 = '{/literal}{$index_md5_key}{literal}_' + rand
					FileUploader({
						session_id: '{/literal}{$index_md5_key}{literal}',
						md5: rand_1,
						message_error: 'Ошибка при загрузке файла', 
						uploadid: '123456789',
						uploadscript: '/ajax/file/upload/',
						progres_barr_id: 'avatar_progress_barr',
						param1: 'foto1',
						portion: 1024*20  //  Размер кусочка для загрузки... 20 килобайт (1024*1024*2 - 2 мегобайта)
					}, files[0]);
				}
			})
			return false;
		})
	})
	{/literal}
</script>
{*<article class="article clearfix">
<div class="col_100">
<h1>Профиль пользователя</h1>
<form method="POST" actopn="">
<input type="hidden" id="avatar_name" name="avatar_name" value="{if $user_info.avatar!=''}{$user_info.avatar}{/if}" />
<table width="100%">
	<tr>
		<td rowspan="4" style="text-align: center; width: 160px;">
			<a href="#" id="avatar_upload">
				{if $user_info.avatar==''}
					<img src="/public/img/noavatar.gif" id="img_avatar" style="width: 150px; height: 100px; " />
				{else}
					<img src="/i/150/{$user_info.avatar}" id="img_avatar" />
				{/if}
			</a>
			<input type="file" style="display: none;" name="file1" id="avatar_upload_input" />
			<div id="avatar_progress" style="display:none;">
            	<progress max="100" value="0" id="avatar_progress_barr"></progress>
        	</div>
		</td>
		<td width="20px"></td>
		<td style="text-align: center; padding: 10px 20px;"><input type="text" placeholder="Имя" name="name" value="{$user_info.name}" style="width: 100%" /></td>
		<td width="20px"></td>
		<td rowspan="4" style="text-align: center; width: 160px;"><h1>Мои баллы</h1><h1>{$user_info.points}</h1></td>
	</tr>
	<tr>
		<td width="20px"></td>
		<td style="text-align: center; padding: 10px 20px;"><input type="text" placeholder="Фамилия" name="surname" value="{$user_info.surname}" style="width: 100%" /></td>
		<td width="20px"></td>
	</tr>
	<tr>
		<td width="20px"></td>
		<td style="text-align: center; padding: 10px 20px;">{if $email_error}<b>{$email_error}</b><br>{/if}<input type="text" placeholder="Email" name="email" value="{$user_info.email}" style="width: 100%" /></td>
		<td width="20px"></td>
	</tr>
	<tr>
		<td width="20px"></td>
		<td style="text-align: center; padding: 10px 20px;"><input type="submit" value="Сохранить изменения" style="width: 100%" /></td>
		<td width="20px"></td>
	</tr>
</table>
</form>
</div>
</article>

*}