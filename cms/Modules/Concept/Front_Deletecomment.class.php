<?php
	class ConceptFrontDeletecomment extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if(isset($_GET['id'])){
				if(isset($_GET['rid'])){
					$query="SELECT user_id FROM concept_comment WHERE id=? AND concept_id=?";
					$SQL = \Tango::sql()->select($query, array($_GET['id'], $_GET['rid']));
					if($SQL!=array()){
						$user_info=\Tango::session()->get('userInfo');
						if($SQL[0]['user_id']==$user_info['user_id']){
							\Tango::sql()->delete('concept_comment', 'id='.$_GET['id']);
							$query="SELECT count(id) as count FROM concept_comment WHERE concept_id=?";
							$SQL1=\Tango::sql()->select($query, array($_GET['rid']));
							$array=array();
							$array['comment_count']=$SQL1[0]['count'];
							\Tango::sql()->update('concept', $array, 'id='.$_GET['rid']);
						}
					}
					header("Location: /concept/".$_GET['rid'].".html");
				}else{
					header("Location: /");
				}
			}else{
				header("Location: /");
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