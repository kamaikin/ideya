<?php
	class SearchFrontIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (isset($_GET['search'])) {
				$this->_getPagesList($_GET['search']);
			} else {
				header("Location: /");
			}
			
		}

		protected function _getPagesList($search, $page=1){
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
				$query.=" WHERE c.moderating='y' OR ud.user_id=".$user_id." AND (c.name LIKE '%".$search."%' OR c.problem LIKE '%".$search."%' OR c.solution LIKE '%".$search."%' OR c.result LIKE '%".$search."%') ORDER BY c.`date` DESC LIMIT ".$start.", ".$numberRecords;
				$query_count.=" WHERE c.moderating='y' OR ud.user_id=".$user_id." AND (name LIKE '%".$search."%' OR problem LIKE '%".$search."%' OR solution LIKE '%".$search."%' OR result LIKE '%".$search."%')";
			}else{
				$query.=" WHERE (c.name LIKE '%".$search."%' OR c.problem LIKE '%".$search."%' OR c.solution LIKE '%".$search."%' OR c.result LIKE '%".$search."%') ORDER BY c.`date` DESC LIMIT ".$start.", ".$numberRecords;
				$query_count.=" WHERE (name LIKE '%".$search."%' OR problem LIKE '%".$search."%' OR solution LIKE '%".$search."%' OR result LIKE '%".$search."%')";
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
					$this->_view['data'][$key]['sponsors']='y';
				} else {
					$this->_view['data'][$key]['sponsors']='n';
				}
			}
			//print_r($this->_view['data']); echo'<hr>';
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