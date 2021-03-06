<?php
	class LoginFrontCheck extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//print_r($_GET); exit;
			if (DEBUG) {
		        $log = DOCUMENT_ROOT.'/tmp/Log.html';
		        file_put_contents($log, date('d.m.Y H:i:s').'║ Login ║'.' Login - '.$_POST['login'].' Pass - '.$_POST['pass']."\n", FILE_APPEND);
		    }
			if (isset($_POST['login'])) {
				if (trim($_POST['login'])=='') {
					unset($_POST['login']);
					\Tango::session()->setFlash('error','Не введен адрес электронной почты');
					\Tango::session()->setFlash('error_id',1);
				}
			}else{
				\Tango::session()->setFlash('error','Не введен адрес электронной почты');
				\Tango::session()->setFlash('error_id',1);
			}
			if (isset($_POST['pass'])) {
				if (trim($_POST['pass'])=='') {unset($_POST['pass']);
					\Tango::session()->setFlash('error','Не введен пароль');
					\Tango::session()->setFlash('error_id',2);
				}
			}else{
				\Tango::session()->setFlash('error','Не введен пароль');
				\Tango::session()->setFlash('error_id',2);
			}
			//print_r($_SESSION); echo'<hr>';
			//print_r($_POST); exit;
			if (isset($_POST['request_uri'])) {if (trim($_POST['request_uri'])=='') {unset($_POST['request_uri']);}}
			if (isset($_POST['login']) || isset($_POST['pass'])) {
				if (isset($_GET['url'])) {
					//	Это первый вход данного пользователя....
					$query="SELECT id FROM users_login WHERE email=?";
					$SQL = \Tango::sql()->select($query, array($_GET['url']));
					if ($SQL!=array()) {
						$user_id=$SQL[0]['id'];
						//	Создаем соль
						$salt = md5($_GET['url'].time().$_POST['pass']);
						$pass=md5($salt.$_POST['pass'].md5($_POST['pass']).$salt);
						$array=array();
						$array['salt']=$salt;
						$array['pass']=$pass;
						\Tango::sql()->update('users_login', $array, 'id='.$user_id);
						//	Нужно отправить пользователю письмо с доступом к сайту.
						$this->_sendEmail('access_information', array('Login'=>$_POST['login'], 'Pass'=>$_POST['pass']), $_POST['login']);
					}else{
						//	Что то пошло не так....
						\Tango::session()->setFlash('error','Ошибочное значение ключа идентификации');
						\Tango::session()->setFlash('error_id',3);
						header("Location: /login/"); exit;
					}
				}
				$identification=\Tango::plugins('identification')->login($_POST['login'], $_POST['pass']);
				//print_r($identification); exit;
				if($identification['error']==''){
					//	Залогинились
					//	Обновляем дату входа
					$array=array();
					$array['last_visit_date']=time();
					\Tango::sql()->update('user_data', $array, 'user_id='.$identification['user_id']);
					//	Теперь вызываем из друго го плагина данные о пользователе.
					$user_info = \Tango::plugins('user')->userId($identification['user_id'])->userInfoAll();
					\Tango::session()->set('userInfo', $user_info);
					//	Перенаправить на исходную страницу..
					if (DEBUG) {
				        $log = DOCUMENT_ROOT.'/tmp/Log.html';
				        file_put_contents($log, date('d.m.Y H:i:s').'║ Login ║'.' Login Успех! - '.$_POST['login'].' Pass - '.$_POST['pass']."\n", FILE_APPEND);
				    }
				    header("Location: /");
					/*if (isset($_POST['request_uri'])) {
						if ($_POST['request_uri']=='/login/logout/') {
							header("Location: /");
						}elseif ($_POST['request_uri']=='/logout/') {
							header("Location: /");
						} else {
							header("Location: ".$_POST['request_uri']);
						}
					} else {
						header("Location: /");
					}*/
				}else{
					\Tango::session()->setFlash('error',$identification['error']);
					if ($identification['error_id']==1) {
						\Tango::session()->setFlash('error_id',1);
					}
					if ($identification['error_id']==2) {
						\Tango::session()->setFlash('error_id',2);
					}
					if (DEBUG) {
				        $log = DOCUMENT_ROOT.'/tmp/Log.html';
				        file_put_contents($log, date('d.m.Y H:i:s').'║ Login ║'.' Login error - '.$identification['error_id']."\n", FILE_APPEND);
				    }
					//	ошибка ввода логина и пароля.
					header("Location: /login/"); exit;
				}
			} else {
				header("HTTP/1.0 404 Not Found");
				header("Location: /login/"); exit;
			}
		}
	}