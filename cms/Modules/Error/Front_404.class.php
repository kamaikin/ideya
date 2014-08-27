<?php
	class ErrorFront404 extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['includeFileName']='Error/404.tpl';
		}
	}