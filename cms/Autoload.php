<?php
function autoloadClass($file){
    $file=$file = str_replace('\\', '/', $file);
    $file=explode("/", $file);
    $file=$file[count($file)-1].'.class.php';
    $dir=DOCUMENT_ROOT.'/cms';
    $filepath=DOCUMENT_ROOT.'/cms/'.$file;
    if (file_exists($filepath)){
        AutoloadLog('Загрузили - '.$filepath);
        require_once($filepath);
    }else{
        AutoloadLog('Начинаем рекурсивный поиск по каталогам');
        recursiveAutoload($dir, $file);
    }
}

function AutoloadLog($message){
    if (DEBUG) {
        $log = DOCUMENT_ROOT.'/tmp/Log.html';
        file_put_contents($log, date('d.m.Y H:i:s').'║'.' '.$message."\n", FILE_APPEND);
    }
}

function recursiveAutoload($dir, $file){
    $array=scandir($dir);
    $Flag=TRUE;
    foreach ($array as $key => $value) {
      if ($Flag) {
        if($value!='.' && $value!='..'){
          $dir1=$dir.'/'.$value;
          if (is_dir($dir1)) {
            if ($value!='Template' && $value!='Config' && $value!='Smarty' && $value!='TangoPHP' && $value!='TangoPlugins' && $value!='Modules' && $value!='Controllers') {
              AutoloadLog('Ищем - '.$dir1);
              $filepath=$dir1.'/'.$file;
              if (file_exists($filepath)){
                  AutoloadLog('Загрузили - '.$filepath);
                  require_once($filepath);
                  $Flag=FALSE;
              }else{
                  AutoloadLog('Не обнаружено - '.$dir1);
                  $Flag=recursiveAutoload($dir1, $file);
              }
            }
          }
        }
      }
    }
    return $Flag;
}
spl_autoload_register('autoloadClass');