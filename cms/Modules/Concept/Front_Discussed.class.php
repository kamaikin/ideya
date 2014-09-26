<?php
	class ConceptFrontDiscussed extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$this->_view['mainTitle']='Обсуждаемые идеи';
			$this->_view['title']='Список обсуждаемых идей';
			$this->_view['includeFileName']='Concept/index.tpl';
			if (\Tango::config()->get('Moderating.user.posts')=='pre') {
				$query="SELECT c.id as id, c.name as name, c.comment_count as comment_count, c.foto as foto, c.anonimus as anonimus FROM concept AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE c.moderating='y' ORDER BY c.comment_count DESC LIMIT 0, 10";
			} else {
				$query="SELECT c.id as id, c.name as name, c.comment_count as comment_count, c.foto as foto, c.anonimus as anonimus FROM concept AS c JOIN user_data AS ud ON ud.user_id=c.user_id WHERE 1=1 ORDER BY c.comment_count DESC LIMIT 0, 10";
			}
			$SQL = \Tango::sql()->select($query);
			$this->_view['data']=$SQL;
		}
	}