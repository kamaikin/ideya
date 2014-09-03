<?php
	class ConceptFrontIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//Tango::plugins('user')->userId(1)->getId(); exit;
			//$this->_view['includeFileName']='Concept/index.tpl';
			header("Location: /");
			exit;
		}

		protected function OneAction(){
			//print_r($_GET);
			$data1=$_GET['url'];
			$data2=(int)$_GET['url'];
			if ((string)$data2==(string)$data1) {
				//	Запросили страницу
				$this->_getConcept($_GET['url']);
			}else{
				$data=substr($_GET['url'], 0, 4);
				if ($data=='page') {
					$page=(int)substr($_GET['url'], 4);
					header("Location: /"); exit;
				}else{
					//	Страница не найдена
					header("HTTP/1.0 404 Not Found");
					header("Location: /error/404"); exit;
				}
			}
		}

		protected function _getConcept($id){
			$this->_getRightSidebar();
			$query="SELECT c.id as id, 
			ud.name as name, 
			ud.surname as surname, 
			ud.user_id as user_id,
			ud.avatar as user_avatar,
			c.comment_count as comment_count, 
			c.foto as foto, 
			c.anonimus as anonimus, 
			c.points as points, 
			c.post_like as post_like, 
			c.date as `date`,
			c.name as concept_name,
			c.implemented as implemented, 
			c.problem as concept_problem,
			c.solution as concept_solution,
			c.result as concept_result,
			c.file_1_name as file_1_name,
			c.file_1 as file_1,
			c.file_2_name as file_2_name,
			c.file_2 as file_2,
			c.file_3_name as file_3_name,
			c.file_3 as file_3 
			FROM concept AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE c.id=?";
			$SQL=\Tango::sql()->select($query, array($id));
			//print_r($SQL[0]); exit;
			$user_info=\Tango::session()->get('userInfo');
			if ($SQL!=array()) {
				$this->_view['mainTitle']=$SQL[0]['concept_name'];
				$this->_view['title']=$SQL[0]['concept_name'];
				$this->_view['includeFileName']='Concept/one.tpl';
				$this->_view['Concept_id']=$id;
				//	Если есть добавляем комментарии
				if ($_POST!=array()) {
					if (isset($_POST['body'])) {if (trim($_POST['body'])=='') {unset($_POST['body']);}else{$body=htmlspecialchars($_POST['body'], ENT_QUOTES);}}
					if (isset($_POST['body'])){
						$user_id=$user_info['id'];
						$array=array();
						$array['user_id']=$user_id;
						$array['body']=$body;
						$array['concept_id']=$id;
						$array['date']=time();
						$array['moderating']='n';
						\Tango::sql()->insert('concept_comment', $array);
						//	Считаем количество комментриев
						$query="SELECT count(id) as count FROM concept_comment WHERE concept_id=?";
						$SQL1=\Tango::sql()->select($query, array($id));
						$array=array();
						$array['comment_count']=$SQL1[0]['count'];
						$SQL[0]['comment_count']=$SQL1[0]['count'];
						\Tango::sql()->update('concept', $array, 'id='.$id);
						if ($SQL[0]['user_id']!=$user_id) {
							//	Поставить пользователю который добавил идею в рейтинг
							$query="SELECT Credits FROM users_events WHERE `key`='comments'";
							$SQL1=\Tango::sql()->select($query);
							$query="UPDATE user_data SET points = points + ".$SQL1[0]['Credits']." WHERE user_id = ".$user_id;
							\Tango::sql()->update($query);
							//	Добавить рейтинг идее
							$query="SELECT Credits FROM concept_events WHERE `key`='comments'";
							$SQL1=\Tango::sql()->select($query);
							$query="UPDATE concept SET points = points + ".$SQL1[0]['Credits']." WHERE id = ".$id;
							\Tango::sql()->update($query);
							$SQL[0]['points']=$SQL[0]['points']+$SQL1[0]['Credits'];
						}
						header("Location: /concept/".$id.".html"); exit;
					}
				}
				//print_r($SQL[0]); exit;
				$this->_view['Concept_data']=$SQL[0];
				//	Получаем комментарии...
				if (\Tango::config()->get('Moderating.user.comments')=='pre') {
					$query="SELECT c.id as id, ud.user_id as user_id, c.body as body, ud.avatar as avatar, ud.name as name, ud.surname as surname, c.date as `date` FROM concept_comment AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE c.moderating='y' AND c.concept_id = ? ORDER BY c.date";
				}else{
					$query="SELECT c.id as id, ud.user_id as user_id, c.body as body, ud.avatar as avatar, ud.name as name, ud.surname as surname, c.date as `date` FROM concept_comment AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE c.concept_id = ? ORDER BY c.date";
				}
				$SQL1=\Tango::sql()->select($query, array($id));
				$this->_view['Concept_comment']=$SQL1;
				//	Получаем теги
				$query="SELECT * FROM tags_to_concept ttc JOIN tags t ON t.id=ttc.tags_id WHERE ttc.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($SQL[0]['id']));
				//print_r($SQL1);
				$this->_view['Concept_data']['tags']=$SQL1;
				//	Получаем спонсоров
				$query="SELECT ud.avatar as avatar, ud.name as name, ud.surname as surname, ud.user_id as user_id FROM concept_sponsor cs JOIN user_data ud ON ud.user_id=cs.user_id WHERE cs.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($SQL[0]['id']));
				$this->_view['Concept_data']['sponsors']=$SQL1;
				//	Лайкал этот пользователь эту идею или нет?
				$query="SELECT `id` FROM concept_licke WHERE user_id=? AND concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($user_info['id'], $SQL[0]['id']));
				if ($SQL1!=array()) {
					$this->_view['Concept_data']['add_licke']='n';
				}else{
					$this->_view['Concept_data']['add_licke']='y';
				}
				//	Спонсировал этот пользователь эту идею или нет?
				$query="SELECT `id` FROM concept_sponsor WHERE user_id=? AND concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($user_info['id'], $SQL[0]['id']));
				if ($SQL1!=array()) {
					$this->_view['Concept_data']['add_sponsor']='n';
				}else{
					$this->_view['Concept_data']['add_sponsor']='y';
				}
				$this->_view['main_page_class'] = 'idea-page';
				$timemetka=time() - 300;
				$this->_view['timemetka'] = $timemetka;
			} else {
				header("HTTP/1.0 404 Not Found");
				header("Location: /error/404"); exit;
			}
			
		}
	}