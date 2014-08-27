$(function() {
    $('a.poplight[href^=#]').click(function() {
        var popID = $(this).attr('rel'); //Get Popup Name
        var popURL = $(this).attr('href'); //Получить Popup HREF и определить размер
        var parent_id = $(this).attr('parent_id');
        $("#comment_parent_id").val(parent_id);
        //Запрос и  Переменные от HREF URL
        var query= popURL.split('?');
        var dim= query[1].split('&');
        var popWidth = dim[0].split('=')[1]; //Возвращает первое значение строки запроса
        // Добавить кнопку "Закрыть" в наше окно, прописываете прямой путь к картинке
        $('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="/public/Style/Default/Front/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');
        $('.close').click(function(){
             $('#fade , .popup_block').fadeOut(function() {
                $('#fade, a.close').remove();  //fade them both out
            });
            return false;
        });
        //Определяет запас на выравнивание по центру (по вертикали по горизонтали)мы добавим 80px к высоте / ширине, значение полей вокруг содержимого (padding) и ширину границы устанавливаем в CSS
        var popMargTop = ($('#' + popID).height() + 80) / 2;
        var popMargLeft = ($('#' + popID).width() + 80) / 2;
        //Устанавливает величину отступа на Popup
        $('#' + popID).css({
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });
       //Fade in Background
        $('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
        $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Постепенное исчезание слоя - .css({'filter' : 'alpha(opacity=80)'}) используется для фиксации в IE , фильтр для устранения бага тупого IE 
        return false;
    });
    $(".count_count").keypress(function(){
      var id = $(this).attr('id');
      var max_count = $(this).attr('max_count');
      var new_id = '#count_' + id;
      var count = $(this).val().length;
      var result = (max_count - count)-1;
      if (result<1) {
        result = '<span style="color: #F00;">Много!</span>'
      };
      $(new_id).html(result);
    })
 })
function FileUploader(ioptions, files, id){
  // Позиция, с которой будем загружать файл
  var position=0;
  // Ассоциативный массив опций
  var options=ioptions;
  // Если не определена опция uploadscript, то возвращаем null. Нельзя
  // продолжать, если эта опция не определена.
  if (options['uploadscript']==undefined){
    return null;
  }else{
    Upload(files, position, options, id)
  }
}
function FileUploader(ioptions, files, id){
  // Позиция, с которой будем загружать файл
  var position=0;
  // Ассоциативный массив опций
  var options=ioptions;
  // Если не определена опция uploadscript, то возвращаем null. Нельзя
  // продолжать, если эта опция не определена.
  if (options['uploadscript']==undefined){
    return null;
  }else{
    Upload(files, position, options, id)
  }
}
function Upload(files, position, options, id){
  // Размер загружаемого файла
    var filesize = files.size;
    var file_name = files.name;
    var start_position = position;
    var stop_position = position + options['portion'];
    var reader = new FileReader();
    reader.onload = function(event) {
      //console.log(event.target.result)
      var form = new FormData();
      var xhr = new XMLHttpRequest();
      form.append("session_id", options['session_id']);
      form.append("start_position", start_position);
      form.append("file_name", file_name);
      form.append("md5_key", options['md5']);
      if (options['param1']) {
        form.append("other_param", options['param1']);
      };
      form.append("data", base64encode(event.target.result));
      if (filesize<=stop_position) {
        form.append("done", "done");
        xhr.onload = function() {
          //console.log("Отправка завершена!!!!!!!!!!!!!!!!");
          prrogress_bar(filesize, start_position, options['portion'], options['progres_barr_id'])
          position = position + options['portion'];
      };
      xhr.onreadystatechange=function(){
        if (xhr.readyState==4){
          //console.log(xhr.responseText)
          var myObject = eval('(' + xhr.responseText + ')');
          console.log(myObject)
          if (options['param1']=='foto1') {
            var src = '/i/150/' + myObject.file_name
            $("#avatar_name").val(myObject.file_name);
            //alert($("#img_foto").attr("src"));
            $("#img_avatar").attr("src", src);
            $("#avatar_progress").hide();
          }
          if (options['param1']=='foto') {
            var src = '/i/150/' + myObject.file_name
            $("#concept_foto").val(myObject.file_name);
            //alert($("#img_foto").attr("src"));
            $("#img_foto").attr("src", src);
            $("#img_foto").show();
            $("#img_foto_text").hide();
            $("#concept_foto_add").show();
            $("#concept_file_progress").hide();
          }
          if (options['param1']=='file') {
            $("#file_upload").show();
            $("#file_upload_progress").hide();
            $("#file_upload_progress_barr").val(0)
            //  Нужно в "Диве" - file_list разместить информацию, о том, что файл загружен...
            //  Для начала проверяем сколько уже записей в диве
            if($(".file_line_info").length < 3){
              var file_div_id = 0
              if (!$("#file_div_1").length) {file_div_id=1};
              if(file_div_id==0){
                if (!$("#file_div_2").length) {file_div_id=2};
              }
              if(file_div_id==0){
                if (!$("#file_div_3").length) {file_div_id=3};
              }
              if(file_div_id!=0){
                //  меньше можно дальше добавлять)))
                //var text = '<div id="file_div_' + file_div_id + '" class="file_line_info">'
                //text = text + '<input type="hidden" value="' + myObject.file_user_name + '" name="file_' + file_div_id + '_user_name" id="file_' + file_div_id + '_user_name">'
                //text = text + '<input type="hidden" value="' + myObject.file_name + '" name="file_' + file_div_id + '_server_name" id="file_' + file_div_id + '_server_name">'
                //text = text + myObject.file_user_name + '<a href="#" id="delete_file_div_' + file_div_id + '"><img src="/public/img/cancel.png" /></a></div>';
                var text = '<span id="file_div_' + file_div_id + '" class="popupper-add-filebox-item">';
                text = text + '<input type="hidden" value="' + myObject.file_user_name + '" name="file_' + file_div_id + '_user_name" id="file_' + file_div_id + '_user_name">';
                text = text + '<input type="hidden" value="' + myObject.file_name + '" name="file_' + file_div_id + '_server_name" id="file_' + file_div_id + '_server_name">'
                text = text + myObject.file_user_name + ' <i class="icon add-file-delete-icon" id="delete_file_div_' + file_div_id + '"></i></span>;'
                $("#file_list").append(text);
                var id = '#file_div_' + file_div_id
                var delete_id = '#delete_file_div_' + file_div_id
                $(delete_id).click(function(){
                  $(id).remove()
                  if($(".file_line_info").length > 2){
                    //  Скрываем ссылку загрузить файл
                    $("#file_upload").hide();
                  }else{
                    $("#file_upload").show();
                  }
                  return false;
                })
                if($(".file_line_info").length > 2){
                  //  Скрываем ссылку загрузить файл
                  $("#file_upload").hide();
                }
              }
            }else{
              //  Скрываем ссылку загрузить файл
              $("#file_upload").hide();
            }
          }
        }
      }
      xhr.open("post", options['uploadscript'], true);
      xhr.send(form);
      }else{
        //  Не последня отправка.... будет еще много!))))
        xhr.onload = function() {
        //console.log("Отправка проиходит.......");
        prrogress_bar(filesize, start_position, options['portion'], options['progres_barr_id'])
        position = position + options['portion'];
        Upload(files, position, options, id)
      };
      xhr.open("post", options['uploadscript'], true);
      xhr.onreadystatechange=function(){
          if (xhr.readyState==4){
            //console.log(xhr.responseText)
          }
        }
      xhr.send(form);
      }
    }
    reader.onerror = function(event) {
      //console.error("Файл не может быть прочитан! код " + event.target.error.code);
      alert("Файл не может быть прочитан! код " + event.target.error.code)
    };
  blob = loadBlob(files, position, options['portion']);
  reader.readAsBinaryString(blob);  
}
function loadBlob(files, position, portion){
  ////////////////////////////////////////////////////////////////////////////
  var reader = new FileReader();
  var data = '';
    // Считаем порцию в объект Blob. Три условия для трех возможных определений Blob.[.*]slice().
    if (files.slice){ 
      blob=files.slice(position,position+portion);
  } else {
        if (files.webkitSlice) {
          blob=files.webkitSlice(position,position+portion);
      } else {
            if (files.mozSlice) {
              blob=files.mozSlice(position,position+portion);
            }
        }
    }
    return blob;
    ////////////////////////////////////////////////////////////////////////////
}
function prrogress_bar(fileSise, start_position, portion, id){
  //console.log(id);
  // Посчитаем количество закаченного в процентах (с точность до 0.1)
  var procent1 = Math.round(fileSise / 1000);
  var procent = Math.round((start_position+portion)/procent1);
  procent = procent / 10;
  if (procent>100) {procent=100;};
  var jid = "#" + id;
  $(jid).val(procent);
}
// Функция кодирования строки в base64 
  function base64encode(str) {
      // Символы для base64-преобразования 
      var b64chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefg'+ 
                     'hijklmnopqrstuvwxyz0123456789+/='; 
      var b64encoded = ''; 
      var chr1, chr2, chr3; 
      var enc1, enc2, enc3, enc4; 
    
      for (var i=0; i<str.length;) { 
          chr1 = str.charCodeAt(i++); 
          chr2 = str.charCodeAt(i++); 
          chr3 = str.charCodeAt(i++); 
    
          enc1 = chr1 >> 2; 
          enc2 = ((chr1 & 3) << 4) | (chr2 >> 4); 
    
          enc3 = isNaN(chr2) ? 64:(((chr2 & 15) << 2) | (chr3 >> 6)); 
          enc4 = isNaN(chr3) ? 64:(chr3 & 63); 
    
          b64encoded += b64chars.charAt(enc1) + b64chars.charAt(enc2) + 
                        b64chars.charAt(enc3) + b64chars.charAt(enc4); 
      } 
      return b64encoded; 
  }