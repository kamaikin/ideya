<?php
namespace Cms;
use Cms;
/**
 * Статический класс Smarty
 */
class sSmarty {
  /**
   * Статическое хранилище для данных
   */
  protected static $store = array();
  protected static $smarty = FALSE;

  /**
   * Защита от создания экземпляров статического класса
   */
  protected function __construct() {}
  protected function __clone() {}


  public static function Init($tpl_folder){
    if (self::$smarty) {
      return self::$smarty;
    }else{
      self::_smarty_init($tpl_folder);
      return self::$smarty;
    }
  }

  private static function _smarty_init($folder='Front'){
      $folder = ucfirst($folder);
      define("SMARTY_DIR",DOCUMENT_ROOT.'/cms/Component/Smarty/');
      include_once DOCUMENT_ROOT.'/cms/Component/Smarty/Smarty.class.php';
      $skin = \Tango::config()->get('Template.skin_name');
      self::$smarty = new \Smarty;
      self::$smarty->caching = false;
      self::$smarty->cache_lifetime = 120;
      self::$smarty->template_dir = DOCUMENT_ROOT.'/cms/Template/'.$skin.'/'.$folder.'/';
      self::$smarty->compile_dir = DOCUMENT_ROOT.'/tmp/cache/templates_c/'.$folder.'/';
      self::$smarty->config_dir = DOCUMENT_ROOT.'/cms/Template/'.$skin.'/'.$folder.'/configs/';
      self::$smarty->cache_dir = DOCUMENT_ROOT.'/tmp/cache/smarty/';
      //print_r(self::$smarty->template_dir); exit;
    }
}
