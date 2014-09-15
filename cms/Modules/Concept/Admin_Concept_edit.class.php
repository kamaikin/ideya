<?php
	class ConceptAdminConcept_edit extends BaseController{
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
			if($_POST!=array()){
				//	Сохраняем в базу данных изменения
				//print_r($_POST); exit;
				$array=array();
				$array['name']=$_POST['name'];
				$array['problem']=$_POST['problem'];
				$array['solution']=$_POST['solution'];
				$array['result']=$_POST['result'];
				\Tango::sql()->update('concept', $array, 'id='.$id);
				header("Location: /admin/concept/page01.html");
			}else{
				//	Получаем из базы данных данные
				$query="SELECT * FROM concept WHERE id=?";
				$SQL=\Tango::sql()->select($query, array($id));
				$this->_view['includeFileName']='Concept/Concept_edit.tpl';
				$this->_view['data']=$SQL[0];
			}
			/*if ($concept_id) {
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
			}*/
		}
	}