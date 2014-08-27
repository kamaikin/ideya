<?php
	class ConceptAdminComment_delete extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if(!isset($_GET['concept_id'])){$concept_id=0;}else{
				$concept_id=(int)$_GET['concept_id'];
			}
			if (!isset($_GET['page'])) {
				$_GET['page']='page01';
			}else{
				if (trim($_GET['page'])=='') {
					$_GET['page']='page01';
				}
			}
			if (!isset($_GET['id'])) {
				header("Location: /admin/concept/");
			}
			if (!(int)$_GET['id']) {
				header("Location: /admin/concept/");
			}
			$id = (int)$_GET['id'];
			if ((string)$id != (string)$_GET['id']) {
				header("Location: /admin/concept/");
			}
			\Tango::sql()->delete('concept_comment', 'id='.$id);
			if ($concept_id) {
				header("Location: /admin/concept/comment/".$_GET['page'].".html?concept_id=".$concept_id);
			} else {
				header("Location: /admin/concept/comment/".$_GET['page'].".html");
			}
		}
	}