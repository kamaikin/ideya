<div  id="concept" class="popup_block">
    <form action="/concept/add/" method="POST">
    <input type="hidden" id="concept_foto" name="concept_foto" />
    <input type="hidden" name="request_url" value="{$smarty.server.REQUEST_URI}" />
    <table>
        <tr>
            <td rowspan="3" width="170px" align="center"><img src="/public/img/nophoto.jpg" style="width: 150px; height: 100px;" id="img_foto" /><br>
              <input type="file" style="display: none;" name="file" id="concept_foto_add_input" />
              <a href="#" id="concept_foto_add">Загрузить изображение</a>
              <div id="concept_file_progress" style="display:none;">
                <progress max="100" value="0" id="concept_file_progress_barr"></progress>
              </div>
            </td>
            <td width="20px"></td>
            <td><input type="text" name="concept_name" id="concept_name"  placeholder="Название" style="width: 350px;" class="count_count" max_count="70" /></td>
            <td width="50px"><span id="count_concept_name">70</span></td>
        </tr>
        <tr>
            <td width="20px"></td>
            <td><input type="text" name="concept_problem" id="concept_problem"  placeholder="Опишите проблему" style="width: 350px;" class="count_count" max_count="70" /></td>
            <td width="50px"><span id="count_concept_problem">70</span></td>
        </tr>
        <tr>
            <td width="20px"></td>
            <td><input type="text" name="concept_decision" id="concept_decision"  placeholder="Опишите решение" style="width: 350px;" class="count_count" max_count="70" /></td>
            <td width="50px"><span id="count_concept_decision">70</span></td>
        </tr>
        <tr>
            <td align="center"><input type="checkbox" name="concept_anonimus" /> Анонимно</td>
            <td width="20px"></td>
            <td><input type="text" name="concept_result" id="concept_result"  placeholder="Опишите результат" style="width: 350px;" class="count_count" max_count="70" /></td>
            <td width="50px"><span id="count_concept_result">70</span></td>
        </tr>
        <tr>
            <td></td>
            <td width="20px"></td>
            <td><div id="file_list"></div><input type="file" style="display: none;" name="file1" id="file_upload_input" /><a href="#" id="file_upload">Прикрепить файл</a>
            <div id="file_upload_progress" style="display:none;">
                <progress max="100" value="0" id="file_upload_progress_barr"></progress>
              </div>
            </td>
            <td width="50px"></td>
        </tr>
        <tr>
            <td colspan="4" align="center"><input type="submit" value="Опубликовать"></td>
        </tr>
    </table>
    </form>
</div>