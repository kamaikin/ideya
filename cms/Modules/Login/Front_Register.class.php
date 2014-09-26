<?php
	class LoginFrontRegister extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//print_r($_POST); //exit;
			if (isset($_POST['name'])) {if (trim($_POST['name'])=='') {unset($_POST['name']);}}
			if (isset($_POST['email'])) {if (trim($_POST['email'])=='') {unset($_POST['email']);}}
			if (isset($_POST['pass'])) {if (trim($_POST['pass'])=='') {unset($_POST['pass']);}}
			if (isset($_POST['request_uri'])) {if (trim($_POST['request_uri'])=='') {unset($_POST['request_uri']);}}
			if (isset($_POST['name']) || isset($_POST['pass']) || isset($_POST['email'])) {
				$identification=\Tango::plugins('identification')->registration($_POST['name'], $_POST['pass'], $_POST['email']);
				if($identification['error']==''){
					$identification=\Tango::plugins('identification')->login($_POST['email'], $_POST['pass']);
					$user_info = \Tango::plugins('user')->userId($identification['user_id'])->userInfoAll();
					\Tango::session()->set('userInfo', $user_info);
					//	Пишем письмо об успешной регистрации...
					//$template = DOCUMENT_ROOT.'/cms/Template/Mail/reg.tpl';
					$array1=array();
					$array2=array();
					$query="SELECT * FROM mail_templates WHERE name=?";
					$SQL=\Tango::sql()->select($query, array('registration'));
					if ($SQL!=array()) {
						$Body = $SQL[0]['body'];
						$Subject = $SQL[0]['subject'];
						$query="SELECT * FROM mail_template_values WHERE template_id=?";
						$SQL=\Tango::sql()->select($query, array($SQL[0]['id']));
						foreach ($SQL as $key => $value) {
							$array1[]='{'.$value['key'].'}';
							$array2[]=$value['value'];
						}
						//	Зарезервированные переменные
						$array1[]='{Pass}';
						$array2[]=$_POST['pass'];
						$array1[]='{Login}';
						$array2[]=$_POST['name'];
						$array1[]='{Email}';
						$array2[]=$_POST['email'];
						$Body = str_replace ($array1, $array2, $Body);
						$Subject = str_replace ($array1, $array2, $Subject);
						\Tango::plugins('phpmailer')->Subject = $Subject;
						\Tango::plugins('phpmailer')->Body = $Body;
						\Tango::plugins('phpmailer')->isHTML(true);
						\Tango::plugins('phpmailer')->AddAddress($_POST['email'], $_POST['name']);
						\Tango::plugins('phpmailer')->Send();
						\Tango::plugins('phpmailer')->ClearAddresses();
						\Tango::plugins('phpmailer')->ClearAttachments();
					}
					//	Перенаправить на исходную страницу..
					if (isset($_POST['request_uri'])) {
						//print_r($_POST['request_uri']);
						header("Location: ".$_POST['request_uri']);
					} else {
						header("Location: /");
					}
				}else{
					header("HTTP/1.0 404 Not Found");
					header("Location: /login/"); exit;
				}
			}else{
				header("HTTP/1.0 404 Not Found");
				header("Location: /login/"); exit;
			}
		}
	}