<?php
	class UserAdminDelete extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (isset($_GET['id'])) {
				$id=(int)$_GET['id'];
				\Tango::sql()->delete('user_data', 'user_id='.$id);
				\Tango::sql()->update('users_login', 'id='.$id);
				header("Location: /admin/user/page01.html");
			}else{
				header("Location: /admin/user/page01.html");
			}
		}
	}