<?php
	class ConceptFrontAdd extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//Tango::plugins('user')->userId(1)->getId(); exit;
			//$this->_view['includeFileName']='Concept/index.tpl';
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

			if (isset($_POST['concept_name']) || isset($_POST['concept_problem']) || isset($_POST['concept_decision']) || isset($_POST['concept_result'])) {
				//print_r($_POST); exit;
				//	Все есть можно добавлять
				$user_info=\Tango::session()->get('userInfo');
				$user_id=$user_info['id'];
				$array=array();
				$array['user_id']=$user_id;
				$array['name']=$concept_name;
				$array['problem']=$concept_problem;
				$array['solution']=$concept_decision;
				$array['result']=$concept_result;
				$array['foto']=$concept_foto;
				$array['anonimus']=$concept_anonimus;
				$array['date']=time();
				$array['moderating']='n';
				$array['file_1_name']=$file_1_user_name;
				$array['file_1']=$file_1_server_name;
				$array['file_2_name']=$file_2_user_name;
				$array['file_2']=$file_2_server_name;
				$array['file_3_name']=$file_3_user_name;
				$array['file_3']=$file_3_server_name;
				$id=\Tango::sql()->insert('concept', $array)->lastInsertId();
				//	Обрабатываем теги
				if(isset($_POST['tags'])){
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
				//	Поставить пользователю который добавил идею в рейтинг
				$query="SELECT Credits FROM users_events WHERE `key`='publication'";
				$SQL=\Tango::sql()->select($query);
				$query="UPDATE user_data SET points = points + ".$SQL[0]['Credits']." WHERE user_id = ".$user_id;
				\Tango::sql()->update($query);
				//	Добавляем идее рейтинг за добавление фото и файлов
				if($concept_foto!=''){
					$query="SELECT Credits FROM concept_events WHERE `key`='add_image'";
					$SQL=\Tango::sql()->select($query);
					$query="UPDATE concept SET points = points + ".$SQL[0]['Credits']." WHERE id = ".$id;
					\Tango::sql()->update($query);
				}
				$query="SELECT Credits FROM concept_events WHERE `key`='ad_file'";
				$SQL=\Tango::sql()->select($query);
				if ($file_1_server_name!='') {
					$query="UPDATE concept SET points = points + ".$SQL[0]['Credits']." WHERE id = ".$id;
					\Tango::sql()->update($query);
				}
				if ($file_2_server_name!='') {
					$query="UPDATE concept SET points = points + ".$SQL[0]['Credits']." WHERE id = ".$id;
					\Tango::sql()->update($query);
				}
				if ($file_3_server_name!='') {
					$query="UPDATE concept SET points = points + ".$SQL[0]['Credits']." WHERE id = ".$id;
					\Tango::sql()->update($query);
				}
			}
			//print_r($_POST); exit;
			if (isset($_POST['request_url'])) {
				header("Location: ".$_POST['request_url']); exit;
			}
			header("Location: /concept/new/"); exit;
		}
	}