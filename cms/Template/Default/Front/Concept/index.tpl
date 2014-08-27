<article class="article clearfix">
  <div class="col_100">
    <h2>{$title}</h2>
    {foreach from=$data item="value"}
    <div>
    	<table width="100%">
    		<tr>
    			<td rowspan="3" width="150px;">{if $value.foto==''}<img src="/public/img/nophoto.jpg" style="width: 150px; height: 100px; " />{else}<img src="/i/150/{$value.foto}" />{/if}</td>
    			<td width="20px"></td>
    			<td width="250px"><b>{$value.name}</b></td>
    			<td></td>
    			<td width="200px">Поддерживают</td>
    		</tr>
    		<tr>
    			<td width="20px"></td>
    			<td></td>
    			<td width="50%"></td>
    			<td></td>
    		</tr>
    		<tr>
    			<td width="20px"></td>
    			<td>Рейтинг</td>
    			<td></td>
    			<td><a href="/concept/{$value.id}.html">{$value.comment_count} Комментариев</a></td>
    		</tr>
    	</table>
    	<hr />
    </div>
    {/foreach}
  </div>
  <div class="clearfix"></div>
</article>