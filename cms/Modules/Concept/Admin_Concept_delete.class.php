<?php
	class ConceptAdminConcept_delete extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
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
			\Tango::sql()->delete('concept_comment', 'concept_id='.$id);
			\Tango::sql()->delete('concept', 'id='.$id);
			header("Location: /admin/concept/page01.html");
		}
	}