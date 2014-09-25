<?php
	class FileAjaxImageViever extends BaseController{
		private $fileTypesImage = array();
		public function __construct(){
			$this->fileTypesImage = array('jpg','jpeg','gif','png');
			parent::__construct();
		}

		protected function IndexAction(){
			//print_r($_GET); exit;
			if(isset($_GET['size'])){$size=(int)$_GET['size'];}else{$size=0;}
			if (isset($_GET['name'])) {
				if (isset($_GET['ext'])) {
					if (in_array($_GET['ext'], $this->fileTypesImage)) {
						$file_name = $_GET['name'].'.'.$_GET['ext'];
						//print_r($file_name); exit;
						//	Проверяем есть ли в хранилище нужный файл
						if(\Tango::fileStorage()->testing($file_name)){
							//	Файл надо возвращать пользователю.
							if (!isset($_GET['data'])) {$data='w';}else{$data='h';}
							$source=DOCUMENT_ROOT.'/cms/FileStorage/'.substr($file_name, 0, 2).'/'.substr($file_name, 2, 2).'/'.$file_name;
							if ($data=='h') {
								$folder=DOCUMENT_ROOT.'/public/foto_cache/h_'.$size;
							}
							if ($data=='w') {
								$folder=DOCUMENT_ROOT.'/public/foto_cache/w_'.$size;
							}
							//print_r($folder); exit;
							if(!file_exists($folder)){mkdir($folder, 0777);}
							$folder=$folder.'/'.substr($file_name, 0, 2);
							if(!file_exists($folder)){mkdir($folder, 0777);}
							$folder=$folder.'/'.substr($file_name, 2, 2);
							if(!file_exists($folder)){mkdir($folder, 0777);}
							$patch=$folder.'/'.$file_name;
							//print_r($patch); exit;
							$url='/public/img/nophoto.jpg';
							if ($size==0) {
								\Tango::image($source)->imageResize(1024, 0, 'width')->imageSave($patch, $_GET['ext']);
								$url='/i/'.$size.'/'.$file_name;
							}else{
								if ($data=='w') {
									\Tango::image($source)->imageResize($size, 0, 'width')->imageSave($patch, $_GET['ext']);
									$url='/i/'.$size.'/'.$file_name;
								}
								if ($data=='h') {
									\Tango::image($source)->imageResize(0, $size, 'height')->imageSave($patch, $_GET['ext']);
									$url='/ih/'.$size.'/'.$file_name;
								}
							}
							//$url='/i/'.$size.'/'.$file_name;
							//print_r($url); exit;
							header("Location: ".$url); exit;
						}else{
							//	Файла нет в хранилище
							header("Location: /public/img/nophoto.jpg"); exit;	
						}
					}else{
						//	Не то расширение
						header("Location: /public/img/nophoto.jpg"); exit;	
					}
				}else{
					//	Не передано расширение
					header("Location: /public/img/nophoto.jpg"); exit;
				}
			}else{
				//	Не передано название
				header("Location: /public/img/nophoto.jpg"); exit;
			}
			$return=array();
			
			$this->_view=array();
			if (DEBUG) {exit;}
		}
	}