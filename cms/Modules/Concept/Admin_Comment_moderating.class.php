<?php
	class ConceptAdminComment_moderating extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if(!isset($_GET['concept_id'])){$concept_id=0;}else{
				$concept_id=(int)$_GET['concept_id'];
			}
			//print_r($_GET); exit;
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
			//	Вот теперь можно модерировать....
			$user_info=\Tango::session()->get('userInfo');
			$user_id=$user_info['id'];
			$array=array();
			$array['moderating']='y';
			$array['moderating_data']=time();
			$array['moderating_id']=$user_id;
			\Tango::sql()->update('concept_comment', $array, 'id='.$id);
			if ($concept_id) {
				if (isset($_GET['new'])) {
					header("Location: /admin/concept/comment/new/");
				} else {
					header("Location: /admin/concept/comment/".$_GET['page'].".html?concept_id=".$concept_id);
				}
			} else {
				if (isset($_GET['new'])) {
					header("Location: /admin/concept/comment/new/");
				} else {
					header("Location: /admin/concept/comment/".$_GET['page'].".html");
				}
			}
		}
	}