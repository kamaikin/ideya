<?php
	class TagsFrontIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//	Выводим все теги, что есть в базе.
			//	Смотрим, есть ли в базе данных актуальный набор
			//	Собираем заново 
			$query="SELECT * 
				FROM   (SELECT tags.name  AS title, 
			       tags.url  AS alias, 
			       COUNT(tags_to_concept.id) AS cnt 
				FROM   tags 
			       INNER JOIN tags_to_concept
			         ON ( tags_to_concept.tags_id = tags.id ) 
			GROUP  BY tags.id 
			ORDER  BY cnt DESC 
			LIMIT  200) AS subq
			ORDER  BY title";
			$SQL = \Tango::sql()->select($query);
			$text='';
			foreach ($SQL as $key => $value) {
				$text.='<li class="tags-widget-item"><a href="/tags/'.$value['alias'].'.html" class="tags-widget-link">'.$value['title'].'</a></li>';
			}
			$this->_view['tags'] = $text;
			$this->_view['mainTitle']='Все теги';
			$this->_view['includeFileName']='Tags/index.tpl';
			$this->_getRightSidebar();
		}

		protected function OneAction(){
			//	Ищем все записи по тегам с переданным урлом
			$this->_getRightSidebar();
			$user_info=\Tango::session()->get('userInfo');
			$user_id = $user_info['id'];
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
					FROM concept AS c JOIN user_data AS ud ON ud.user_id=c.user_id JOIN tags_to_concept ttc ON ttc.concept_id=c.id JOIN tags t ON t.id = ttc.tags_id";
			if (\Tango::config()->get('Moderating.user.posts')=='pre') {
				$query.=" WHERE (c.moderating='y' OR ud.user_id=".$user_id.") AND t.url = ? ORDER BY c.`date` DESC ";
			}else{
				$query.=" WHERE t.url = ? ORDER BY c.`date` DESC ";
			}
			$SQL = \Tango::sql()->select($query, array($_GET['url']));
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
			//	Получаем полное количество записей
			/*$SQL = \Tango::sql()->select($query_count);
			$count = $SQL[0]['count'];
			if ($count>$numberRecords) {
				$this->_view['paginator']=$this->_getPaginator('/', $page, $count, $numberRecords);
			} else {
				$this->_view['paginator']='';
			}*/
			$this->_view['mainTitle']='Идеи с тегом';
			$this->_view['includeFileName']='Index/index.tpl';
		}
	}