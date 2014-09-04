<?php
	class ConceptFrontDeletecomment extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if(isset($_GET['id'])){
				if(isset($_GET['rid'])){
					$query="SELECT user_id, `date` FROM concept_comment WHERE id=? AND concept_id=?";
					$SQL = \Tango::sql()->select($query, array($_GET['id'], $_GET['rid']));
					if($SQL!=array()){
						$user_info=\Tango::session()->get('userInfo');
						if($SQL[0]['user_id']==$user_info['user_id']){
							$time = time() - 300;
							if($SQL[0]['date']>$time){
								\Tango::sql()->delete('concept_comment', 'id='.$_GET['id']);
								$query="SELECT count(id) as count FROM concept_comment WHERE concept_id=?";
								$SQL1=\Tango::sql()->select($query, array($_GET['rid']));
								$array=array();
								$array['comment_count']=$SQL1[0]['count'];
								\Tango::sql()->update('concept', $array, 'id='.$_GET['rid']);
							}
						}
					}
					header("Location: /concept/".$_GET['rid'].".html");
				}else{
					header("Location: /");
				}
			}else{
				header("Location: /");
			}
		}
	}