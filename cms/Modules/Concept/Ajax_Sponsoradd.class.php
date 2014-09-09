<?php
	class ConceptAjaxSponsoradd extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (isset($_GET['id'])) {
				if ((int)$_GET['id'] != 0) {
					$user_info=\Tango::session()->get('userInfo');
					$query="SELECT id, user_id FROM concept_sponsor WHERE user_id=? AND concept_id=?";
					$SQL=\Tango::sql()->select($query, array($user_info['id'], (int)$_GET['id']));
					if($SQL==array()){
						$array=array();
						$array['user_id']=$user_info['user_id'];
						$array['concept_id']=(int)$_GET['id'];
						$array['datetime']=time();
						\Tango::sql()->insert('concept_sponsor', $array);
						//	Идею поддержал спонсор, нужно начислить ей...
						$query="SELECT Credits FROM concept_events WHERE `key`='idea_supported_sponsor'";
						$SQL1=\Tango::sql()->select($query);
						$query="UPDATE concept SET points = points + ".$SQL1[0]['Credits']." WHERE id = ".(int)$_GET['id'];
						\Tango::sql()->update($query);
						//	Теперь себе за то, что поддержал идею
						$query="SELECT Credits FROM users_events WHERE `key`='become_sponsor_ideas'";
						$SQL1=\Tango::sql()->select($query);
						$query="UPDATE user_data SET points = points + ".$SQL1[0]['Credits']." WHERE user_id = ".$user_info['user_id'];
						\Tango::sql()->update($query);
						//	Теперь владельцу идеи
						$query="SELECT id, user_id FROM concept WHERE id=?";
						$SQL=\Tango::sql()->select($query, array((int)$_GET['id']));
						$query="SELECT Credits FROM users_events WHERE `key`='idea_supported_sponsor'";
						$SQL1=\Tango::sql()->select($query);
						$query="UPDATE user_data SET points = points + ".$SQL1[0]['Credits']." WHERE user_id = ".$SQL[0]['user_id'];
						\Tango::sql()->update($query);
						$name= $user_info['name'].' '.$user_info['surname'];
						$this->_sendEmail('ideya_sponsor', array('url_id'=>$_GET['id'], 'user_name'=>$name), $user_info['email'], $name);
						//	Смотрим на до ли отправлять автору письмо...
						$query="SELECT comment FROM users_config WHERE user_id=?";
						$SQL1 = \Tango::sql()->select($query, array($SQL[0]['user_id']));
						$send=TRUE;
						if ($SQL1!=array()) {if ($SQL1[0]['comment']==0) {$send=FALSE;}}
						if ($send) {
							//	Отправить письмо автору идеи, что его идею прокомментировали
							$query="SELECT * FROM user_data WHERE user_id=?";
							$SQL = \Tango::sql()->select($query, array($SQL[0]['user_id']));
							$user_info1=$SQL[0];
							//	Отправить письмо автору идеи, что его идею прокомментировали
							$name= $user_info1['name'].' '.$user_info1['surname'];
							$this->_sendEmail('ideya_sponsor', array('url_id'=>$id, 'user_name'=>$name), $user_info1['email'], $name);
						}
					}
				}
			}
			return 'ok';
			exit;
		}
	}