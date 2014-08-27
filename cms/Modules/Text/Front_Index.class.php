<?php
	class TextFrontIndex extends BaseController{
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
			$data1=$_GET['url'];
			$data2=(int)$_GET['url'];
			if ((string)$data2==(string)$data1) {
				//	Запросили страницу
				$this->_getConcept($_GET['url']);
			}else{
				$data=substr($_GET['url'], 0, 4);
				if ($data=='page') {
					$page=(int)substr($_GET['url'], 4);
					$this->_getPagesList($page);
				}else{
					//	Страница не найдена
					header("HTTP/1.0 404 Not Found");
					header("Location: /error/404"); exit;
				}
			}
		}

		protected function _getPagesList($page){
			$this->_getRightSidebar();
			$numberRecords=\Tango::config()->get('Main.number.records');
			$user_info=\Tango::session()->get('userInfo');
			$user_id = $user_info['id'];
			$start=$page*$numberRecords-$numberRecords;
			$query_count="SELECT count(`id`) as count FROM concept ";
			$query="SELECT c.id as id, 
					c.name as name, 
					c.comment_count as comment_count, 
					c.foto as foto, 
					c.date as date, 
					c.post_like as postLike,
					c.points as points,
					c.anonimus as anonimus,
					c.implemented as implemented,
					c.file_1_name as file_1_name,
					c.file_1 as file_1,
					c.file_2_name as file_2_name,
					c.file_2 as file_2,
					c.file_3_name as file_3_name,
					c.file_3 as file_3 
					FROM concept AS c JOIN user_data AS ud ON ud.user_id=c.user_id ";
			if (\Tango::config()->get('Moderating.user.posts')=='pre') {
				$query.=" WHERE c.moderating='y' OR ud.user_id=".$user_id." ORDER BY c.`date` DESC LIMIT ".$start.", ".$numberRecords;
				$query_count.=" WHERE c.moderating='y' OR ud.user_id=".$user_id;
			}else{
				$query.=" WHERE 1=1 ORDER BY c.`date` DESC LIMIT ".$start.", ".$numberRecords;
				$query_count.=" WHERE 1=1";
			}
			$SQL = \Tango::sql()->select($query);
			$this->_view['data']=$SQL;
			foreach($this->_view['data'] as $key=>$value){
				//	Получаем теги
				$query="SELECT * FROM tags_to_concept ttc JOIN tags t ON t.id=ttc.tags_id WHERE ttc.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($value['id']));
				$this->_view['data'][$key]['tags']=$SQL1;
				//	Смотрим есть ли спонсоры
				$query="SELECT ud.avatar as avatar, ud.name as name, ud.surname as surname FROM concept_sponsor cs JOIN user_data ud ON ud.user_id=cs.user_id WHERE cs.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($value['id']));
				if ($SQL1!=array()) {
					$this->_view['data']['sponsors']='y';
				} else {
					$this->_view['data']['sponsors']='n';
				}
			}
			//	Получаем полное количество записей
			$SQL = \Tango::sql()->select($query_count);
			$count = $SQL[0]['count'];
			if ($count>$numberRecords) {
				$this->_view['paginator']=$this->_getPaginator('/', $page, $count, $numberRecords);
			} else {
				$this->_view['paginator']='';
			}
			$this->_view['mainTitle']='Новые идеи';
			$this->_view['includeFileName']='Index/index.tpl';
		}
	}