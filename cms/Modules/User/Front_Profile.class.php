<?php
	class UserFrontProfile extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			$user_info=\Tango::session()->get('userInfo');
			if ($_POST!=array()) {
				if(isset($_POST['form_type'])){
					$query="SELECT id FROM users_config WHERE user_id=?";
					$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
					$array=array();
					$array['comment']=1;
					$array['points']=1;
					$array['sponsors']=1;
					$array['user_id']=$user_info['user_id'];
					if($_POST['subscriptions-comment']=='выкл'){$array['comment']=0;}
					if($_POST['subscriptions-points']=='выкл'){$array['points']=0;}
					if($_POST['subscriptions-sponsors']=='выкл'){$array['sponsors']=0;}
					if ($SQL!=array()) {
						\Tango::sql()->update('users_config', $array, 'id='.$SQL[0]['id']);
					} else {
						\Tango::sql()->insert('users_config', $array);
					}
					
					header("Location: /user/profile/");
				}
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
				if (isset($_POST['avatar_name_null'])){$array['avatar']='';}
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
			$query = "SELECT c.name as name, c.foto as foto, cc.date as date, cc.body as body, c.id as id, cc.id as cid FROM concept_comment cc JOIN concept c ON c.id=cc.concept_id WHERE cc.user_id = ? ORDER BY c.date DESC LIMIT 0, 99";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['user_comment']=$SQL;
			foreach($this->_view['user_comment'] as $key=>$value){
				//	Выбираем спонсоров.
				$query="SELECT ud.avatar as avatar, ud.name as name, ud.surname as surname, ud.user_id as user_id FROM concept_sponsor cs JOIN user_data ud ON ud.user_id=cs.user_id WHERE cs.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($value['cid']));
				$this->_view['user_comment'][$key]['sponsors']=$SQL1;
			}
			//	Получить все мои идеи вместе со спонсорами...
			$sort='date';
			if(isset($_GET['sort'])){if ($_GET['sort']=='raiting') {$sort='points';}}
			$order='ASC';
			if(isset($_GET['order'])){if($_GET['order']=='desc'){$order='DESC';}}
			$query = "SELECT * FROM concept WHERE user_id = ? ORDER BY ".$sort.' '.$order." LIMIT 0, 99";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['user_concept']=$SQL;
			foreach($this->_view['user_concept'] as $key=>$value){
				//	Выбираем спонсоров.
				$query="SELECT ud.avatar as avatar, ud.name as name, ud.surname as surname, ud.user_id as user_id FROM concept_sponsor cs JOIN user_data ud ON ud.user_id=cs.user_id WHERE cs.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($value['id']));
				$this->_view['user_concept'][$key]['sponsors']=$SQL1;
			}
			if ($user_info['user_role']=='sponsor') {
				//	Я спонсирую
				$query="SELECT c.foto as foto, 
					c.points as points, 
					c.user_id as user_id, 
					c.post_like as post_like, 
					c.comment_count as comment_count, 
					c.name as name, c.date as `date`,
					ud.avatar as user_avatar,
					ud.name as user_name,
					ud.surname as user_surname, cs.datetime as datetime  FROM concept c JOIN concept_sponsor cs ON cs.concept_id = c.id JOIN user_data ud ON ud.user_id = c.user_id WHERE cs.user_id=? LIMIT 0, 99";
				$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
				$this->_view['ya_sponsor_concept']=$SQL;
			}
			//	Мне нравяться
			$query="SELECT c.id as id, c.foto as foto, 
				c.points as points, 
				c.post_like as post_like, 
				c.comment_count as comment_count, 
				c.name as name, c.date as `date`, cl.datetime as datetime FROM concept c JOIN concept_licke cl ON cl.concept_id = c.id WHERE cl.user_id = ? ORDER BY c.`date` DESC LIMIT 0, 99";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['my_lacke_concept']=$SQL;
			foreach($this->_view['my_lacke_concept'] as $key=>$value){
				//	Выбираем спонсоров.
				$query="SELECT ud.avatar as avatar, ud.name as name, ud.surname as surname, ud.user_id as user_id FROM concept_sponsor cs JOIN user_data ud ON ud.user_id=cs.user_id WHERE cs.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($value['id']));
				$this->_view['my_lacke_concept'][$key]['sponsors']=$SQL1;
			}
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
				ud.user_id as user_id  FROM concept c JOIN concept_sponsor cs ON cs.concept_id = c.id JOIN user_data ud ON ud.user_id = cs.user_id WHERE c.user_id=? LIMIT 0, 99";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['my_sponsor_concept']=$SQL;
			foreach($this->_view['my_sponsor_concept'] as $key=>$value){
				//	Выбираем спонсоров.
				$query="SELECT ud.avatar as avatar, ud.name as name, ud.surname as surname, ud.user_id as user_id FROM concept_sponsor cs JOIN user_data ud ON ud.user_id=cs.user_id WHERE cs.concept_id=?";
				$SQL1=\Tango::sql()->select($query, array($value['id']));
				$this->_view['my_sponsor_concept'][$key]['sponsors']=$SQL1;
			}
			$this->_view['includeFileName']='User/profile.tpl';
			//	Определяем, что изменилось с нашего последнего захода в профиль
			$query="SELECT time FROM user_profile_views WHERE profile_id=? AND user_id=? ORDER BY time DESC LIMIT 1";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id'], $user_info['user_id']));
			if ($SQL!=array()) {
				$time=$SQL[0]['time'];
			}else{
				$time=0;
			}
			$this->_view['notificare_time']=$time;
			//	Теперь отмечаем вход пользователя
			$array=array();
			$array['user_id']=$user_info['user_id'];
			$array['profile_id']=$user_info['user_id'];
			$array['time']=time();
			\Tango::sql()->insert('user_profile_views', $array);
			//	Мне нравяться
			$query="SELECT count(c.id) as count FROM concept c JOIN concept_licke cl ON cl.concept_id = c.id WHERE cl.user_id = ? AND cl.datetime>?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id'], $time));
			$this->_view['count_my_lacke_concept']=$SQL[0]['count'];
			//	Меня спонсируют
			$query="SELECT count(c.id) as count  FROM concept c JOIN concept_sponsor cs ON cs.concept_id = c.id JOIN user_data ud ON ud.user_id = cs.user_id WHERE c.user_id=? AND c.date>?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id'], $time));
			$this->_view['count_my_sponsor_concept']=$SQL[0]['count'];
			if ($user_info['user_role']=='sponsor') {
				//	Я спонсирую
				$query="SELECT count(c.id) as count  FROM concept c JOIN concept_sponsor cs ON cs.concept_id = c.id JOIN user_data ud ON ud.user_id = c.user_id WHERE cs.user_id=? AND cs.datetime=?";
				$SQL = \Tango::sql()->select($query, array($user_info['user_id'], $time));
				$this->_view['count_ya_sponsor_concept']=$SQL[0]['count'];
			}
			//	Получить все мои комментарии
			$query = "SELECT count(id) as count FROM concept_comment WHERE user_id = ?  AND `date`>?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id'], $time));
			$this->_view['count_user_comment']=$SQL[0]['count'];
			$query = "SELECT count(`id`) as count FROM concept WHERE user_id = ? AND `date`>?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id'], $time));
			$this->_view['count_user_concept']=$SQL[0]['count'];
			$query="SELECT * FROM users_config WHERE user_id=?";
			$SQL = \Tango::sql()->select($query, array($user_info['user_id']));
			$this->_view['users_config']=$SQL[0];
			//print_r($user_info['user_id']); exit;
			$this->_getRightSidebar();
		}
	}