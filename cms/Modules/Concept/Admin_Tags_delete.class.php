<?php
	class ConceptAdminTags_delete extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (!isset($_GET['id'])) {
				header("Location: /admin/concept/tags/");
			}
			if (!(int)$_GET['id']) {
				header("Location: /admin/concept/tags/");
			}
			$id = (int)$_GET['id'];
			if ((string)$id != (string)$_GET['id']) {
				header("Location: /admin/concept/tags/");
			}
			\Tango::sql()->delete('tags_to_concept', 'tags_id='.$id);
			\Tango::sql()->delete('tags', 'id='.$id);
			header("Location: /admin/concept/tags/");
		}
	}