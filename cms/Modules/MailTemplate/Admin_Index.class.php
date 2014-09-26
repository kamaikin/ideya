<?php
	class MailTemplateAdminIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['IndexTitle']='Шаблоны писем';
			// Вывести список всех шаблонов почтовых сообщений
			$this->_view['includeFileName']='MailTemplate/Template_list.tpl';
			$query="SELECT * FROM mail_templates";
			$SQL=\Tango::sql()->select($query);
			$this->_view['data']=$SQL;
		}
	}