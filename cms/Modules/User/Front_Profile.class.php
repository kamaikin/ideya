<?php
	class UserFrontProfile extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$user_info=\Tango::session()->get('userInfo');
			if ($_POST!=array()) {
				//	Логика, если нас чем то не устраивает, то рпосто игнарируем параметр)))
				if (isset($_POST['avatar_name'])) {if (trim($_POST['avatar_name'])=='') {$avatar_name='';}else{$avatar_name=htmlspecialchars($_POST['avatar_name'], ENT_QUOTES);}}else{$avatar_name='';}
				if (isset($_POST['name'])) {if (trim($_POST['name'])=='') {$name='';}else{$name=htmlspecialchars($_POST['name'], ENT_QUOTES);}}else{$name='';}
				if (isset($_POST['surname'])) {if (trim($_POST['surname'])=='') {$surname='';}else{$surname=htmlspecialchars($_POST['surname'], ENT_QUOTES);}}else{$surname='';}
				if (isset($_POST['email'])) {if (trim($_POST['email'])=='') {$email='';}else{$email=htmlspecialchars($_POST['email'], ENT_QUOTES);}}else{$email='';}
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$email=''; 
					$this->_view['email_error']='Не правильный адрес электронной почты';
				}else{
					$query="SELECT id FROM users_login WHERE email=? AND id!=?";
					$SQL=\Tango::sql()->select($query, array(md5($email), $user_info['user_id']));
					if($SQL!=array()){
						$email='';
						$this->_view['email_error']='Такой адрес электронной почты уже есть в системе.';
					}
				}
				$array=array();
				if ($avatar_name!='') {$array['avatar']=$avatar_name;}
				if ($name!='') {$array['nick_name']=$name;	$array['name']=$name;}
				if ($surname!='') {$array['surname']=$surname;}
				if ($email!='') {$array['email']=$email;}
				if ($array!=array()) {
					\Tango::sql()->update('user_data', $array, 'user_id='.$user_info['user_id']);
					$user_info=\Tango::plugins('user')->userId($user_info['user_id'])->userInfoAll();
					\Tango::session()->set('userInfo', $user_info);
					if ($email!=''){
						$array=array();
						$array['email']=md5($email);
						\Tango::sql()->update('users_login', $array, 'user_id='.$user_info['user_id']);
					}
				}
				$user_info = \Tango::plugins('user')->userId($user_info['user_id'])->userInfoAll();
				\Tango::session()->set('userInfo', $user_info);
				$this->_view['index_user_login']=$user_info['surname'].' '.$user_info['name'];
				$this->_view['index_user_avatar']=$avatar_name;
				if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					exit;
				}
			}
			//	Количество моих комментариев
			$this->_view['user_info']=$user_info;
			$query = "SELECT count(`id`) as count FROM concept_comment WHERE user_id = ?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['user_info']['comment_count']=$SQL[0]['count'];
			//	Количество моих идей
			$query = "SELECT count(`id`) as count, sum(`post_like`) as post_like FROM concept WHERE user_id = ?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['user_info']['concept_count']=$SQL[0]['count'];
			$this->_view['user_info']['summ_post_like']=$SQL[0]['post_like'];
			//	Получить все мои комментарии
			$query = "SELECT * FROM concept_comment WHERE user_id = ? ORDER BY `date` DESC";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['user_comment']=$SQL;
			//	Получить все мои идеи
			$query = "SELECT * FROM concept WHERE user_id = ? ORDER BY `date` DESC";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['user_concept']=$SQL;
			if ($user_info['user_role']=='sponsor') {
				//	Я спонсирую
				$query="SELECT c.foto as foto, 
					c.points as points, 
					c.post_like as post_like, 
					c.comment_count as comment_count, 
					c.name as name, c.date as `date`,
					ud.avatar as user_avatar,
					ud.name as user_name,
					ud.surname as user_surname  FROM concept c JOIN concept_sponsor cs ON cs.concept_id = c.id JOIN user_data ud ON ud.user_id = c.user_id WHERE cs.user_id=?";
				$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
				$this->_view['ya_sponsor_concept']=$SQL;
			}
			//	Мне нравяться
			$query="SELECT c.foto as foto, 
				c.points as points, 
				c.post_like as post_like, 
				c.comment_count as comment_count, 
				c.name as name, c.date as `date` FROM concept c JOIN concept_licke cl ON cl.concept_id = c.id WHERE cl.user_id = ? ORDER BY c.`date` DESC";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['my_lacke_concept']=$SQL;
			//	Меня спонсируют
			//	Получить мои идеи и данные спонсоров...
			$query="SELECT c.id as id,
				c.foto as foto, 
				c.points as points, 
				c.post_like as post_like, 
				c.comment_count as comment_count, 
				c.name as name, c.date as `date`,
				ud.avatar as user_avatar,
				ud.name as user_name,
				ud.surname as user_surname,
				ud.user_id as user_id  FROM concept c JOIN concept_sponsor cs ON cs.concept_id = c.id JOIN user_data ud ON ud.user_id = cs.user_id WHERE c.user_id=?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['my_sponsor_concept']=$SQL;
			$this->_view['includeFileName']='User/profile.tpl';
			$this->_getRightSidebar();
		}
	}