<?php
	class LoginFrontIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['login_error']='';
			$this->_laout='login_form.tpl';
			if (isset($_GET['url'])) {
				$query="SELECT id FROM users_login WHERE email=?";
				$SQL = \Tango::sql()->select($query, array($_GET['url']));
				//print_r($SQL); exit;
				if ($SQL!=array()) {
					$query="SELECT email FROM user_data WHERE user_id=?";
					$SQL = \Tango::sql()->select($query, array($SQL[0]['id']));
					$this->_view['login_email']=$SQL[0]['email'];
				}
			}
			$this->_view['request_uri']=\Tango::registry('REQUEST_URI');
			if (\Tango::session()->getFlash('error')) {
				$this->_view['request_uri']=\Tango::session()->getFlash('request_uri');
				$this->_view['login_error']=\Tango::session()->getFlash('error');
				$this->_view['login_error_id']=\Tango::session()->getFlash('error_id');
			}
			
		}
	}