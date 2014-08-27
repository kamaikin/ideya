<?php
//	http://php.russofile.ru/ru/translate/mail/phpmailer/ - Инструкция
require_once(DOCUMENT_ROOT.'/cms/TangoPlugins/phpmailer/lib/class.phpmailer.php');
class Tango_phpmailer extends PHPMailer{
	public function __construct(){
		if(\Tango::config()->get('Phpmailer.smtp_mode') == 'enabled'){
	        $this->Host = \Tango::config()->get('Phpmailer.smtp_host');
	        $this->Port = \Tango::config()->get('Phpmailer.smtp_port');
        	if(\Tango::config()->get('Phpmailer.smtp_username') != ''){
		        $this->SMTPAuth  = true;
		        $this->Username  = \Tango::config()->get('Phpmailer.smtp_username');
		        $this->Password  = \Tango::config()->get('Phpmailer.smtp_password');
        	}
        	$this->Mailer = "smtp";
      	}
      	if(!$this->From){
        	$this->From = \Tango::config()->get('Phpmailer.from_email');
      	}
      	if(!$this->FromName){
        	$this->FromName = \Tango::config()->get('Phpmailer.from_name');
      	}
      	if(!$this->Sender){
        	$this->Sender = \Tango::config()->get('Phpmailer.from_email');
      	}
      	$this->Priority = $this->priority;
	}
}