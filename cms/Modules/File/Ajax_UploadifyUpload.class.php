<?php
	class FileAjaxUploadifyUpload extends BaseController{
		private $fileTypes = array();
		private $fileTypesImage = array();
		private $fileTypesFile = array();
		public function __construct(){
			$this->fileTypes = array('zip','jpg','jpeg','gif','png','xls', 'pdf', 'doc', 'xlsx', 'docx', 'ppt');
			$this->fileTypesImage = array('jpg','jpeg','gif','png');
			$this->fileTypesFile = array('zip','xls', 'pdf', 'doc', 'xlsx', 'docx', 'ppt');
			parent::__construct();
		}

		protected function IndexAction(){
			//print_r($_POST); echo "\n";
			//print_r($_FILES); exit;
			$fileTypes = array('jpg','jpeg','gif','png');
			$ext = preg_replace('/(?:.*)(\.{1}[a-zA-Z]{3,4})$/','$1', $_FILES['Filedata']['name']);
			$ext = strtolower(substr($ext, 1));
			$return=array();
			if (in_array($ext, $this->fileTypes)) {
				$fileTypes=$this->fileTypes;
				//if (isset($_POST['other_param'])) {
					/*if ($_POST['other_param']=='foto') {
						$fileTypes=$this->fileTypesImage;
					}
					if ($_POST['other_param']=='file') {
						$fileTypes=$this->fileTypesFile;
					}*/
					if (in_array($ext, $this->fileTypes)) {
						//	Файл полностью загружен на сервер.
						//	Пришедший кусочек был последним))))
						//	Надо файл оприходовать))))
						$targetPath = DOCUMENT_ROOT . '/tmp/upload/'.$_POST['session_id'].'.'.$ext;
						move_uploaded_file($_FILES['Filedata']['tmp_name'], $targetPath);
						$file=\Tango::fileStorage()->put($targetPath);
						$return['error']=0;
						$return['ok']='ok';
						$return['file_name']=$file;
						$return['file_type']=$ext;
						$return['file_user_name']=$_FILES['Filedata']['name'];
						//unlink($file_name);
					}else{
						$return['error']='error_4';
						$return['message']='Не допустимое расширение файла - '.$ext.' Допустимы - '.implode(",", $fileTypes);
					}
				//}
			}else{
				$return['error']='error_1';
				$return['message']='отстутсвует $_POST[md5_key]';
			}
			echo json_encode($return);
			$this->_view=array();
			if (DEBUG) {exit;}
			
			/*if (isset($_POST['md5_key'])) {
				if (isset($_POST['file_name'])) {
					if (isset($_POST['data'])) {
						$ext = preg_replace('/(?:.*)(\.{1}[a-zA-Z]{3,4})$/','$1', $_POST['file_name']);
						$ext = strtolower(substr($ext, 1));
						$fileTypes=$this->fileTypes;
						if (isset($_POST['other_param'])) {
							if ($_POST['other_param']=='foto') {
								$fileTypes=$this->fileTypesImage;
							}
							if ($_POST['other_param']=='file') {
								$fileTypes=$this->fileTypesFile;
							}
						}
						if (in_array($ext, $fileTypes)) {
							$targetPath = DOCUMENT_ROOT . '/tmp/upload/';
							$file_name=$targetPath.$_POST['md5_key'].'.'.$ext;
							file_put_contents($file_name, base64_decode($_POST['data']), FILE_APPEND);
							if (DEBUG) {
								//sleep(1);
							}
							if (isset($_POST['done'])) {
								//	Файл полностью загружен на сервер.
								//	Пришедший кусочек был последним))))
								//	Надо файл оприходовать))))
								$file=\Tango::fileStorage()->put($file_name);
								$return['error']=0;
								$return['ok']='ok';
								$return['file_name']=$file;
								$return['file_type']=$ext;
								$return['file_user_name']=$_POST['file_name'];
								//unlink($file_name);
							}else{
								$return['error']=0;
								$return['ok']='ok';
							}
						}else{
							$return['error']='error_4';
							$return['message']='Не допустимое расширение файла - '.$ext.' Допустимы - '.implode(",", $fileTypes);
						}
					}else{
						$return['error']='error_3';
						$return['message']='отстутсвует $_POST[data]';
					}
				}else{
					$return['error']='error_2';
					$return['message']='отстутсвует $_POST[file_name]';
				}
			}else{
				$return['error']='error_1';
				$return['message']='отстутсвует $_POST[md5_key]';
			}
			echo json_encode($return);
			$this->_view=array();
			if (DEBUG) {exit;}*/
		}
	}