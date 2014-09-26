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
			if(isset($_GET['count'])){
				$_SESSION['user_count']=$_GET['count'];
				header("Location: /admin/user/page01.html");
			}
			$this->_view['IndexTitle']='Список пользователей';
			if (substr($_GET['url'], 0, 4)=='page') {
				$numberRecords=25;
				if(isset($_SESSION['user_count'])){
					$numberRecords=$_SESSION['user_count'];
				}
				$page=(int)substr($_GET['url'], 4);
				//	В переменной $page находится текущая страница списка.
				$start=$page*$numberRecords-$numberRecords;
				$query="SELECT * FROM user_data WHERE 1=1 LIMIT ".$start.", ".$numberRecords;
				$SQL=\Tango::sql()->select($query);
				$this->_view['includeFileName']='User/list.tpl';
				$this->_view['data']=$SQL;
				$query_count="SELECT count(`id`) as count FROM user_data";
				$SQL = \Tango::sql()->select($query_count);
				$count = $SQL[0]['count'];
				if ($count>$numberRecords) {
					$this->_view['paginator']=$this->_getPaginator('/admin/user/', $page, $count, $numberRecords);
				} else {
					$this->_view['paginator']='';
				}
			}
		}
	}