<?php
	class LogoutFrontIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			\Tango::session()->delete('userInfo');
			header("Location: /"); exit;
		}
	}