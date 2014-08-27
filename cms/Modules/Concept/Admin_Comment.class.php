<?php
	class ConceptAdminComment extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if(!isset($_GET['concept_id'])){$_GET['concept_id']=0;}
			//Tango::plugins('user')->userId(1)->getId(); exit;
			//$this->_view['includeFileName']='Concept/index.tpl';
			header("Location: /admin/concept/comment/page01.html?concept_id=".$_GET['concept_id']);
			exit;
		}

		protected function OneAction(){
			if(!isset($_GET['concept_id'])){$concept_id=0;}else{
				$concept_id=(int)$_GET['concept_id'];
			}
			$_GET['concept_id']=$concept_id;
			if (substr($_GET['url'], 0, 4)=='page') {
				if ($concept_id) {
					$this->_view['IndexTitle']='Список комментариев идея id-'.$concept_id;
				} else {
					$this->_view['IndexTitle']='Список комментариев все идеи';
				}
				
				$page=(int)substr($_GET['url'], 4);
				//	В переменной $page находится текущая страница списка.
				$start=$page*20-20;
				if ($concept_id) {
				$query="SELECT c.id as id, 
					c.body as body,
					ud.nick_name as nick_name,
					c.moderating as moderating,
					c.`date` as `date`
					FROM concept_comment AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE c.concept_id = ? ORDER BY c.date DESC 
					LIMIT ".$start.", 20";
					$SQL=\Tango::sql()->select($query, array($concept_id));
				}else{
					$query="SELECT c.id as id, 
					c.body as body,
					ud.nick_name as nick_name,
					c.moderating as moderating,
					c.`date` as `date`
					FROM concept_comment AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE 1=1 ORDER BY c.date DESC 
					LIMIT ".$start.", 20";
					$SQL=\Tango::sql()->select($query);
				}
				
				$this->_view['includeFileName']='Concept/Comment_list.tpl';
				$this->_view['data']=$SQL;
			}
		}
	}