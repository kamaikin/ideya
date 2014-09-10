<?php
	class ConceptAjaxEditcomment extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//print_r($_GET);
			if (isset($_GET['id'])) {
				if ((int)$_GET['id'] != 0) {
					if (isset($_GET['text'])) {
						$_GET['text']=urldecode($_GET['text']);
						//print_r($_GET['text']);
						$user_info=\Tango::session()->get('userInfo');
						//	Проверяем принадлежит ли такой комментарий этому пользователю.
						$query="SELECT `date` FROM concept_comment WHERE user_id=? AND id=?";
						$SQL=\Tango::sql()->select($query, array($user_info['id'], (int)$_GET['id']));
						if($SQL!=array()){
							$time=time()-300;
							if($time < $SQL[0]['date']){
								//	Редактируем
								$array=array();
								$array['body']=$_POST['text'];
								\Tango::sql()->update('concept_comment', $array, 'id='.(int)$_GET['id']);
								echo '1';
							}else{
								echo '1';
							}
						}else{
							echo '1';
						}
					}
					exit;
					/*$query="SELECT id, user_id FROM concept_licke WHERE user_id=? AND concept_id=?";
					$SQL=\Tango::sql()->select($query, array($user_info['id'], (int)$_GET['id']));
					if($SQL==array()){
						$array=array();
						$array['user_id']=$user_info['user_id'];
						$array['concept_id']=(int)$_GET['id'];
						$array['datetime']=time();
						\Tango::sql()->insert('concept_licke', $array);
						$query="SELECT count(`id`) as count FROM concept_licke WHERE concept_id=?";
						$SQL1=\Tango::sql()->select($query, array((int)$_GET['id']));
						if($SQL1!=array()){
							$array=array();
							$array['post_like']=$SQL1[0]['count'];
							\Tango::sql()->update('concept', $array, 'id='.(int)$_GET['id']);
						}
						if ($user_info['user_id']!=$SQL[0]['user_id']) {
							//	Баллы нужно начислить автору идеи
							$query="SELECT id, user_id FROM concept WHERE id=?";
							$SQL=\Tango::sql()->select($query, array((int)$_GET['id']));
							$query="SELECT Credits FROM users_events WHERE `key`='evaluation_ideas_other_users'";
							$SQL1=\Tango::sql()->select($query);
							$query="UPDATE user_data SET points = points + ".$SQL1[0]['Credits']." WHERE user_id = ".$SQL[0]['user_id'];
							\Tango::sql()->update($query);
							//	Теперь нужно начислить буллы тому кто оценил
							$query="SELECT Credits FROM users_events WHERE `key`='уvaluation_others_ideas'";
							$SQL1=\Tango::sql()->select($query);
							$query="UPDATE user_data SET points = points + ".$SQL1[0]['Credits']." WHERE user_id = ".$user_info['user_id'];
							\Tango::sql()->update($query);
						}
						//	И начислить баллы идее
						$query="SELECT Credits FROM concept_events WHERE `key`='ocenka_drugimi_polsovatelyami'";
						$SQL=\Tango::sql()->select($query);
						$query="UPDATE concept SET points = points + ".$SQL[0]['Credits']." WHERE id = ".(int)$_GET['id'];
						\Tango::sql()->update($query);
						//	Смотрим на до ли отправлять автору письмо...
						$query="SELECT comment FROM users_config WHERE user_id=?";
						$SQL1 = \Tango::sql()->select($query, array($SQL[0]['user_id']));
						$send=TRUE;
						if ($SQL1!=array()) {if ($SQL1[0]['comment']==0) {$send=FALSE;}}
						if ($send) {
							$query="SELECT * FROM user_data WHERE user_id=?";
							$SQL = \Tango::sql()->select($query, array($SQL[0]['user_id']));
							$user_info1=$SQL[0];
							//	Отправить письмо автору идеи, что его идею прокомментировали
							$name= $user_info1['name'].' '.$user_info1['surname'];
							$this->_sendEmail('ideya_like', array('url_id'=>(int)$_GET['id'], 'user_name'=>$name), $user_info1['email'], $name);
						}
					}*/
				}
			}
			return 'ok';
			exit;
		}
	}