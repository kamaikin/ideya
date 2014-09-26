<?php
	class ConceptFrontSelectvid extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if ($_GET['vid']=='blocks') {
				$_SESSION['view']='blocks';
			}
			if ($_GET['vid']=='lists') {
				$_SESSION['view']='lists';
			}
			if (isset($_GET['uri'])) {
				header("Location: ".$_GET['uri']);
			}else{
				header("Location: /");
			}
			
			exit;
		}
	}