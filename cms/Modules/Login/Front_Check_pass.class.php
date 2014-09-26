<?php
	class LoginFrontCheck_pass extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (isset($_POST['login1'])) {
				if (trim($_POST['login1'])=='') {
					unset($_POST['login1']);
					\Tango::session()->setFlash('error','Не введен адрес электронной почты');
					\Tango::session()->setFlash('error_id',1);
				}
			}else{
				\Tango::session()->setFlash('error','Не введен адрес электронной почты');
				\Tango::session()->setFlash('error_id',1);
			}
			//	Проверяем есть такой адрес в базе или нет
			$query="SELECT id FROM users_login WHERE email=?";
			$SQL = \Tango::sql()->select($query, array(md5($_POST['login1'])));
			
			if ($SQL!=array()) {
				//	все есть)
				//	Создаем новый пароль
				// Символы, которые будут использоваться в пароле. 
				$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
				// Количество символов в пароле. 
				$max=10; 
				// Определяем количество символов в $chars 
				$size=StrLen($chars)-1; 
				// Определяем пустую переменную, в которую и будем записывать символы. 
				$password=null; 
				// Создаём пароль. 
			    while($max--){
				    $password.=$chars[rand(0,$size)]; 
			    }
			    $user_id=$SQL[0]['id'];
				//	Создаем соль
				$salt = md5($password.time().$password);
				$pass=md5($salt.$password.md5($password).$salt);
				$array=array();
				$array['salt']=$salt;
				$array['pass']=$pass;
				\Tango::sql()->update('users_login', $array, 'id='.$user_id);
				//	Нужно отправить пользователю письмо с доступом к сайту.
				$query="SELECT email FROM user_data WHERE user_id=?";
				$SQL = \Tango::sql()->select($query, array($user_id));
				$this->_sendEmail('access_information', array('Login'=>$SQL[0]['email'], 'Pass'=>$password), $SQL[0]['email']);
			} else {
				\Tango::session()->setFlash('error','Пользователя с таким адресом электронной почты не существует.');
				\Tango::session()->setFlash('error_id',1);
			}
			header("Location: /login/"); exit;
		}
	}