<?php
	/**
	 *	Класс добавления нового пользователя в систему (С отправкой приглашения)
	 */
	class UserAdminEdit extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['IndexTitle']='Редактирование данных пользователя';
			if (isset($_GET['id'])) {
				$id=(int)$_GET['id'];
			}else{
				header("Location: /admin/user/page01.html");
			}
			if($_POST!=array()){
				if (isset($_POST['email'])) {if (trim($_POST['email'])=='') {unset($_POST['email']);}else{$email=$_POST['email'];}}
				if (isset($_POST['surname'])) {if (trim($_POST['surname'])=='') {unset($_POST['surname']);}else{$surname=$_POST['surname'];}}
				if (isset($_POST['name'])) {if (trim($_POST['name'])=='') {unset($_POST['name']);}else{$name=$_POST['name'];}}
				if (isset($_POST['patronymic'])) {if (trim($_POST['patronymic'])=='') {unset($_POST['patronymic']);}else{$patronymic=$_POST['patronymic'];}}
				if (isset($_POST['role'])) {if (trim($_POST['role'])=='') {unset($_POST['role']);}else{$role=$_POST['role'];}}
				//	Регистрируем пользователя
				$array=array();
				if(isset($email)){$array['email']=md5($email);}
				if(isset($surname)){$array['login']=md5($surname);}
				\Tango::sql()->update('users_login', $array, 'id='.$id);
				//	Можно заносить данные в таблицу
				$array=array();
				if(isset($email)){$array['email']=$email;}
				if(isset($surname)){$array['nick_name']=$surname;}
				if(isset($surname)){$array['surname']=$surname;}
				if(isset($name)){$array['name']=$name;}
				if(isset($patronymic)){$array['patronymic']=$patronymic;}
				if(isset($role)){$array['user_role']=$role;}
				\Tango::sql()->update('user_data', $array, 'user_id='.$id);
				header("Location: /admin/user/page01.html");
			}else{
				$query="SELECT * FROM user_data WHERE user_id=?";
				$SQL=\Tango::sql()->select($query, array($id));
				$_POST=$SQL[0];
				$this->_view['includeFileName']='User/user_add.tpl';
			}
		}
	}