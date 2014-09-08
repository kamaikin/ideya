<?php
	class ConceptAjaxLikeadd extends BaseController{
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
					}
				}
			}
			return 'ok';
			exit;
		}
	}