<?php
	/**
	 *	Класс добавления нового пользователя в систему (С отправкой приглашения)
	 */
	class UserAdminNew extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['IndexTitle']='Новый пользователь';
			if (isset($_POST['email'])) {if (trim($_POST['email'])=='') {unset($_POST['email']);}else{$email=$_POST['email'];}}
			if (isset($_POST['surname'])) {if (trim($_POST['surname'])=='') {unset($_POST['surname']);}else{$surname=$_POST['surname'];}}
			if (isset($_POST['name'])) {if (trim($_POST['name'])=='') {unset($_POST['name']);}else{$name=$_POST['name'];}}
			if (isset($_POST['patronymic'])) {if (trim($_POST['patronymic'])=='') {unset($_POST['patronymic']);}else{$patronymic=$_POST['patronymic'];}}
			if (isset($_POST['role'])) {if (trim($_POST['role'])=='') {unset($_POST['role']);}else{$role=$_POST['role'];}}
			if (isset($email) || isset($surname) || isset($name) || isset($patronymic) || isset($role)) {
				$email1=md5($email);
				$query="SELECT id FROM users_login WHERE email=?";
				$SQL=\Tango::sql()->select($query, array($email1));
				if ($SQL==array()) {
					//	Регистрируем пользователя
					$array=array();
					$array['email']=md5($email);
					$array['login']=md5($surname);
					$id=\Tango::sql()->insert('users_login', $array)->lastInsertId();
					//	Можно заносить данные в таблицу
					$array=array();
					$array['email']=$email;
					$array['nick_name']=$surname;
					$array['surname']=$surname;
					$array['name']=$name;
					$array['patronymic']=$patronymic;
					$array['user_role']=$role;
					$array['user_id']=$id;
					\Tango::sql()->insert('user_data', $array);
					//	Получаем текст письма
					$query="SELECT * FROM mail_templates WHERE name=?";
					$Tmail=\Tango::sql()->select($query, array('invitation'));
					$query="SELECT * FROM mail_template_values WHERE template_id=?";
					$SQL=\Tango::sql()->select($query, array($Tmail[0]['id']));
					$arr_key=array();
					$arr_value=array();
					foreach ($SQL as $key => $value) {
						$arr_key[]='{'.$value['key'].'}';
						$arr_value[]=$value['value'];
					}
					//	Сформировать и отправить письмо...
					$Body = $Tmail[0]['body'];
					$Subject = $Tmail[0]['subject'];
					$array1=array();
					$array2=array();
					$array1=$arr_key;
					$array2=$arr_value;
					$array1[]='{url}';
					$array2[]=md5($email);
					$Body = str_replace ($array1, $array2, $Body);
					$Subject = str_replace ($array1, $array2, $Subject);
					//print_r($Subject); exit;
					\Tango::plugins('phpmailer')->Subject = $Subject;
					\Tango::plugins('phpmailer')->Body = $Body;
					\Tango::plugins('phpmailer')->isHTML(true);
					\Tango::plugins('phpmailer')->AddAddress($email, $surname.' '.$name.' '.$patronymic);
					\Tango::plugins('phpmailer')->Send();
					\Tango::plugins('phpmailer')->ClearAddresses();
					\Tango::plugins('phpmailer')->ClearAttachments();
					header("Location: /admin/user/page01.html");
				}else{
					$this->_view['error']='Такой пользователь уже есть в базе данных';
				}
			}
			$this->_view['includeFileName']='User/user_add.tpl';
		}
	}