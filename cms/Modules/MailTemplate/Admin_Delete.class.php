<?php
	class MailTemplateAdminDelete extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (isset($_GET['id'])) {
				if((int)$_GET['id']){
					$id=(int)$_GET['id'];
					\Tango::sql()->delete('mail_templates', 'id='.$id);
					\Tango::sql()->delete('mail_template_values', 'template_id='.$id);
				}
			}
			header("Location: /admin/mailTemplate/");	exit;
		}
	}