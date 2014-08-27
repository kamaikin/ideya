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
					}
				}
			}
			return 'ok';
			exit;
		}
	}