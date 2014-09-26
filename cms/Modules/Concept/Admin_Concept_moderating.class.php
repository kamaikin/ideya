<?php
	class ConceptAdminConcept_moderating extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
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
			$array['implemented']='y';
			$array['moderating_data']=time();
			$array['moderating_id']=$user_id;
			\Tango::sql()->update('concept', $array, 'id='.$id);
			header("Location: /admin/concept/".$_GET['page'].".html");
		}
	}