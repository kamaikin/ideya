<?php
	class ConceptFrontEdit extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (!isset($_GET['id'])) {
				header("Location: /"); exit;
			}
			if (!(int)$_GET['id']) {
				header("Location: /"); exit;
			}
			$id = (int)$_GET['id'];
			$user_info=\Tango::session()->get('userInfo');
			$user_id=$user_info['id'];
			$query="SELECT * FROM concept WHERE id=? AND user_id=?";
			$SQL=\Tango::sql()->select($query, array($id, $user_id));
			if ($SQL!=array()) {
				if($_POST!=array()){
					if (isset($_POST['concept_name'])) {if (trim($_POST['concept_name'])=='') {unset($_POST['concept_name']);}else{$concept_name=htmlspecialchars($_POST['concept_name'], ENT_QUOTES);}}
					if (isset($_POST['concept_problem'])) {if (trim($_POST['concept_problem'])=='') {unset($_POST['concept_problem']);}else{$concept_problem=htmlspecialchars($_POST['concept_problem'], ENT_QUOTES);}}
					if (isset($_POST['concept_decision'])) {if (trim($_POST['concept_decision'])=='') {unset($_POST['concept_decision']);}else{$concept_decision=htmlspecialchars($_POST['concept_decision'], ENT_QUOTES);}}
					if (isset($_POST['concept_result'])) {if (trim($_POST['concept_result'])=='') {unset($_POST['concept_result']);}else{$concept_result=htmlspecialchars($_POST['concept_result'], ENT_QUOTES);}}
					if (isset($_POST['concept_foto'])) {if (trim($_POST['concept_foto'])=='') {unset($_POST['concept_foto']); $concept_foto='';}else{$concept_foto=htmlspecialchars($_POST['concept_foto'], ENT_QUOTES);}}else{$concept_foto='';}
					if (isset($_POST['concept_anonimus'])) {$concept_anonimus='y';}else{$concept_anonimus='n';}
					if (isset($_POST['concept_foto'])) {$concept_foto=$_POST['concept_foto'];}else{$concept_foto='';}
					if (isset($_POST['file_1_user_name'])) {$file_1_user_name=$_POST['file_1_user_name'];}else{$file_1_user_name='';}
					if (isset($_POST['file_1_server_name'])) {$file_1_server_name=$_POST['file_1_server_name'];}else{$file_1_server_name='';}
					if (isset($_POST['file_2_user_name'])) {$file_2_user_name=$_POST['file_2_user_name'];}else{$file_2_user_name='';}
					if (isset($_POST['file_2_server_name'])) {$file_2_server_name=$_POST['file_2_server_name'];}else{$file_2_server_name='';}
					if (isset($_POST['file_3_user_name'])) {$file_3_user_name=$_POST['file_3_user_name'];}else{$file_3_user_name='';}
					if (isset($_POST['file_3_server_name'])) {$file_3_server_name=$_POST['file_3_server_name'];}else{$file_3_server_name='';}
					$array=array();
					if($concept_name!=''){$array['name']=$concept_name;}
					if($concept_decision!=''){$array['solution']=$concept_decision;}
					if($concept_result!=''){$array['result']=$concept_result;}
					$array['foto']=$concept_foto;
					$array['anonimus']=$concept_anonimus;
					$array['file_1_name']=$file_1_user_name;
					$array['file_1']=$file_1_server_name;
					$array['file_2_name']=$file_2_user_name;
					$array['file_2']=$file_2_server_name;
					$array['file_3_name']=$file_3_user_name;
					$array['file_3']=$file_3_server_name;
					\Tango::sql()->update('concept', $array, 'id='.$id);
					if(isset($_POST['tags'])){
						\Tango::sql()->delete('tags_to_concept', 'concept_id='.$id);
						foreach ($_POST['tags'] as $key => $value) {
							//print_r($value); echo'<hr>';
							$url = $this->translit($value);
							//print_r($url); echo'<hr>';
							$query="SELECT id FROM tags WHERE url=?";
							$SQL=\Tango::sql()->select($query, array($url));
							//print_r($SQL); echo'<hr>';
							if ($SQL!=array()) {
								$array=array();
								$array['tags_id']=$SQL[0]['id'];
								$array['concept_id']=$id;
								\Tango::sql()->insert('tags_to_concept', $array);
							} else {
								$array=array();
								$array['url']=$url;
								$array['name']=$value;
								//print_r($array); echo'<hr>';
								$tags_id=\Tango::sql()->insert('tags', $array)->lastInsertId();
								$array=array();
								$array['tags_id']=$tags_id;
								$array['concept_id']=$id;
								//print_r($array); echo'<hr>';
								\Tango::sql()->insert('tags_to_concept', $array);
							}
							
						}
					}
					header("Location: /concept/".$id.".html"); exit;
				}
				$this->_view['data']=$SQL[0];
				//	Получаем теги
				$query="SELECT * FROM tags_to_concept ttc JOIN tags t ON t.id=ttc.tags_id WHERE ttc.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($SQL[0]['id']));
				//print_r($SQL1);
				$this->_view['data']['tags']=$SQL1;
				$this->_view['includeFileName']='Concept/ConceptFrontEdit.tpl';
			} else {
				header("Location: /"); exit;
			}
		}
	}