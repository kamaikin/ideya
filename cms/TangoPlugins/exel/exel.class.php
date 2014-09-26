<?php
require_once(DOCUMENT_ROOT.'/cms/TangoPlugins/exel/reader.php');
class Tango_exel{
    private $data;
    public function __construct(){
      $this->data = new Spreadsheet_Excel_Reader();
      $this->data->setOutputEncoding('UTF-8');
    }

    public function read($file){
      $this->data->read($file);
      return $this->data->sheets;
    }
}