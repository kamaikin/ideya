<?php
	class ConceptAdminTags extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//	Выводим список тегов
			$this->_view['IndexTitle']='Список Тегов';
			$this->_view['includeFileName']='Concept/Tag_list.tpl';
			$query="SELECT * FROM tags t JOIN tags_to_concept ttc ON ttc.tags_id=t.id";
			$SQL=\Tango::sql()->select($query);
			$tags=array();
			foreach ($SQL as $key => $value) {
				$tags[$value['tags_id']]=$value['name'];
			}
			$data=array();
			foreach ($SQL as $key => $value) {
				if(isset($data[$value['tags_id']])){
					$data[$value['tags_id']]=$data[$value['tags_id']]+1;
				}else{
					$data[$value['tags_id']]=1;
				}
			}
			//print_r($data); exit;
			$this->_view['data']=$data;
			$this->_view['tags']=$tags;
		}

		protected function _OneAction(){
			if (substr($_GET['url'], 0, 4)=='page') {
				$this->_view['IndexTitle']='Список Идей';
				$page=(int)substr($_GET['url'], 4);
				//	В переменной $page находится текущая страница списка.
				$start=$page*20-20;
				$query="SELECT  c.id as id, 
					c.name as name, 
					c.comment_count as comment_count, 
					c.foto as foto, 
					c.anonimus as anonimus,
					ud.nick_name as nick_name,
					c.moderating as moderating,
					c.`date` as `date`
					FROM concept AS c 
					JOIN user_data AS ud ON ud.user_id=c.user_id 
					WHERE 1=1 
					ORDER BY c.`date` DESC 
					LIMIT ".$start.", 20";
				$SQL=\Tango::sql()->select($query);
				$this->_view['includeFileName']='Concept/Concept_list.tpl';
				$this->_view['data']=$SQL;
			}
		}
	}