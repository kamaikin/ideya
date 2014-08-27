<?php
	class UserAdminProgressidea extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if ($_POST!=array()) {
				if (isset($_POST['data'])) {
					foreach ($_POST['data'] as $key => $value) {
						$array=array();
						$array['Credits']=$value;
						\Tango::sql()->update('concept_events', $array, 'id='.$key);
					}
				}
				if (trim($_POST['key']) || trim($_POST['name']) || trim($_POST['credits'])) {
					$array=array();
					$array['key']=$_POST['key'];
					$array['name']=$_POST['name'];
					$array['Credits']=$_POST['credits'];
					\Tango::sql()->insert('concept_events', $array);
				}
				header("Location: /admin/user/progressidea/");
			}
			$this->_view['IndexTitle']='События идеи';
			$query="SELECT * FROM concept_events";
			$SQL=\Tango::sql()->select($query);
			$this->_view['includeFileName']='User/Progressuser.tpl';
			$this->_view['data']=$SQL;
			$this->_view['post_url']='/admin/user/progressidea/';
		}
	}