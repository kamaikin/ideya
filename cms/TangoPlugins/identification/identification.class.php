<?php
class Tango_identification{
	public function __construct(){
		//echo __METHOD__.'';
	}
	public function login($login, $pass){
		$column_name = Tango::config()->get('Acl.identification.column.name');
		$query="SELECT id, salt FROM users_login WHERE ".$column_name."=?";
		//print_r($query); exit;
		$SQL=Tango::sql()->select($query, array(md5($login)));
		if ($SQL!=array()) {
			$pass=md5($SQL[0]['salt'].$pass.md5($pass).$SQL[0]['salt']);
			$query="SELECT id FROM users_login WHERE id=? AND pass=?";
			$SQL=Tango::sql()->select($query, array($SQL[0]['id'], $pass));
			if ($SQL!=array()) {
				return array('error' =>'','error_id'=>0, 'user_id'=>$SQL[0]['id']);
			} else {
				return array('error' =>'Неверный пароль','error_id'=>2, 'user_id'=>0);
			}
			
		} else {
			return array('error' =>'Нет такого пользователя','error_id'=>1, 'user_id'=>0);
		}
	}

	public function registration($login, $pass, $email){
		//	Проверить может такой пользователь уже есть)))
		$query="SELECT id FROM users_login WHERE login=?";
		$SQL=\Tango::sql()->select($query, array(md5($login)));
		if($SQL==array()){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$query="SELECT id FROM users_login WHERE email=?";
				$SQL=\Tango::sql()->select($query, array(md5($email)));
				if($SQL==array()){
					//	Получаем соль
					$salt=md5($login.$email.time());
					//	Получаем пароль
					$pass=md5($salt.$pass.md5($pass).$salt);
					//	записываем в таблицу логинов
					$array=array();
					$array['login']=md5($login);
					$array['pass']=$pass;
					$array['salt']=$salt;
					$array['email']=md5($email);
					$id=\Tango::sql()->insert('users_login', $array);
					$id=\Tango::sql()->lastInsertId();
					//	Пишем данные
					$array=array();
					$array['user_id']=$id;
					$array['nick_name']=$login;
					$array['register_date']=time();
					$array['email']=$email;
					$array['last_visit_date']=time();
					$array['user_role']='user';
					\Tango::sql()->insert('user_data', $array);
					return array('error' =>'','error_id'=>0, 'user_id'=>$id);
				}else{
					return array('error' =>'Пользователь с таким ящиком электронной почты уже есть','error_id'=>3, 'user_id'=>0);
				}
			}else{
				return array('error' =>'Электронный адрес не является электронным адресом.','error_id'=>2, 'user_id'=>0);
			}
		}else{
			return array('error' =>'Пользователь с таким логином уже есть','error_id'=>1, 'user_id'=>0);
		}
	}
}