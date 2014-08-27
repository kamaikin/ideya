<?php
	class IndexAdminIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//Tango::plugins('user')->userId(1)->getId(); exit;
			$this->_view['includeFileName']='Index/index.tpl';
		}
	}