<?php
	class MailTemplateAdminEdit extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['IndexTitle']='Редактировать шаблон письма';
			if ($_POST!=array()) {
				if (isset($_POST['title'])) {if (trim($_POST['title'])=='') {unset($_POST['title']);}else{$title=$_POST['title'];}}
				if (isset($_POST['description'])) {if (trim($_POST['description'])=='') {unset($_POST['description']);}else{$description=$_POST['description'];}}
				if (isset($_POST['name'])) {if (trim($_POST['name'])=='') {unset($_POST['name']);}else{$name=$_POST['name'];}}
				if (isset($_POST['info'])) {if (trim($_POST['info'])=='') {unset($_POST['info']);}else{$info=$_POST['info'];}}
				if (isset($_POST['subject'])) {if (trim($_POST['subject'])=='') {unset($_POST['subject']);}else{$subject=$_POST['subject'];}}
				if (isset($_POST['body'])) {if (trim($_POST['body'])=='') {unset($_POST['body']);}else{$body=$_POST['body'];}}
				$array=array();
				if(isset($title)){$array['title']=$title;}
				if(isset($description)){$array['description']=$description;}
				if(isset($name)){$array['name']=$name;}
				if(isset($info)){$array['info']=$info;}
				if(isset($subject)){$array['subject']=$subject;}
				if(isset($body)){$array['body']=$body;}
				if (isset($_GET['id'])) {
					if((int)$_GET['id']){
						$id=(int)$_GET['id'];
						\Tango::sql()->update('mail_templates', $array, 'id='.$id);
					}
				}else{
					$id=\Tango::sql()->insert('mail_templates', $array)->lastInsertId();
				}
				if(isset($id)){
					//	На всякий случай затираем имеющиеся в таблице ключи
					\Tango::sql()->delete('mail_template_values', 'template_id='.$id);
					foreach($_POST['tkey'] as $key=>$value){
						if (trim($value)!='') {
							$array=array();
							$array['key']=$value;
							$array['value']=$_POST['tvalue'][$key];
							$array['template_id']=$id;
							\Tango::sql()->insert('mail_template_values', $array);
						}
					}
				}
				header("Location: /admin/mailTemplate/");	exit;
			}
			// Редактируем шаблон или создаем новый
			if (isset($_GET['id'])) {
				if((int)$_GET['id']){
					//	Добываем из базы данных информацию
					$query="SELECT * FROM mail_templates WHERE id=?";
					$SQL=\Tango::sql()->select($query, array($_GET['id']));
					$this->_view['data']=$SQL[0];
					$query="SELECT * FROM mail_template_values WHERE template_id=?";
					$SQL=\Tango::sql()->select($query, array($SQL[0]['id']));
					//print_r($SQL); exit;
					$this->_view['sub_data']=$SQL;
				}else{
					header("Location: /admin/mailTemplate/");	exit;
				}
			} else {
				//	Просто выводим форму на редактирование
			}
			$this->_view['includeFileName']='MailTemplate/Template_form.tpl';
		}
	}