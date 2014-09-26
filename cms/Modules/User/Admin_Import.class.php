<?php
	class UserAdminImport extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['IndexTitle']='Импортировать пользователей';
			$this->_view['includeFileName']='User/import.tpl';
			if ($_FILES!=array()) {
				//	Проверяем загруженный файл
				$ext = preg_replace('/(?:.*)(\.{1}[a-zA-Z]{3,4})$/','$1', $_FILES['userfile']['name']);
				$ext = strtolower(substr($ext, 1));
				if (in_array($ext, array('txt', 'csv', 'xls'))) {
					//	Копируем файл во временную папку
					$uploaddir = DOCUMENT_ROOT.'/tmp/upload/'.time().'.'.$ext;
					if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir)) {
						$data = \Tango::plugins('exel')->read($uploaddir);
						$view=array();
						foreach ($data[0]['cells'] as $key => $value) {
							//	Проверяем наличие пользователя в базе
							$email=md5($value[1]);
							$query="SELECT id FROM users_login WHERE email=?";
							$SQL=\Tango::sql()->select($query, array($email));
							if ($SQL==array()) {
								//	Регистрируем пользователя
								$array=array();
								$array['email']=md5($value[1]);
								$array['login']=md5($value[2]);
								$id=\Tango::sql()->insert('users_login', $array)->lastInsertId();
								//	Можно заносить данные в таблицу
								$array=array();
								$array['email']=$value[1];
								$array['nick_name']=$value[2];
								$array['surname']=$value[2];
								$array['name']=$value[3];
								$array['patronymic']=$value[4];
								$array['user_role']=$value[5];
								$array['user_id']=$id;
								\Tango::sql()->insert('user_data', $array);
								//	Сформировать и отправить письмо...
								$name = $value[2].' '.$value[3].' '.$value[4];
								$this->_sendEmail('invitation', array('url'=>md5($value[1])), $value[1], $name);
								if(\Tango::plugins('phpmailer')->Send()){
									$view[]='Электронная почта - '.$value[1].' Пользователь - '.$value[2].' '.$value[3].' '.$value[4].' <b>Письмо с приглашением успешно отправлено.</b>';
								}else{
									$view[]='Электронная почта - '.$value[1].' Пользователь - '.$value[2].' '.$value[3].' '.$value[4].' <span style="color: #F00;"><b>При отправке письма произошла ошибка.</b></span>';
								}
								\Tango::plugins('phpmailer')->ClearAddresses();
								\Tango::plugins('phpmailer')->ClearAttachments();
							}else{
								$view[]='Электронная почта - '.$value[1].' Пользователь - '.$value[2].' '.$value[3].' '.$value[4].' <span style="color: #F00;"><b>Такой пользователь уже есть в базе.</b></span>';
							}
							
						}
						$this->_view['data']=$view;
					    $this->_view['formView']='result';
					} else {
					    $this->_view['info']='Ошибка при копировании файла '.$_FILES['userfile']['name'];
						$this->_view['formView']='error';
					}
				}else{
					$this->_view['info']='Не верный формат файла. Расширение <b>.'.$ext.'</b> Не корректно!';
					$this->_view['formView']='error';
				}
			}else{
				$this->_view['formView']='form';
			}
		}
	}