<?php
	class ConceptAdminIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//Tango::plugins('user')->userId(1)->getId(); exit;
			//$this->_view['includeFileName']='Concept/index.tpl';
			header("Location: /admin/concept/page01.html");
			exit;
		}

		protected function OneAction(){
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