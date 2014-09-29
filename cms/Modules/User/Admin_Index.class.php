<?php
	class UserAdminIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//Tango::plugins('user')->userId(1)->getId(); exit;
			//$this->_view['includeFileName']='User/profile.tpl';
			header("Location: /admin/user/page01.html");
		}

		protected function OneAction(){
			$this->_view['IndexTitle']='Список пользователей';
			if (substr($_GET['url'], 0, 4)=='page') {
				$page=(int)substr($_GET['url'], 4);
				//	В переменной $page находится текущая страница списка.
				$start=$page*20-20;
				$query="SELECT * FROM user_data WHERE 1=1 LIMIT ".$start.", 20";
				$SQL=\Tango::sql()->select($query);
				$this->_view['includeFileName']='User/list.tpl';
				$this->_view['data']=$SQL;
			}
		}
	}