<?php
	class ConceptAjaxDeletecomment extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			if (isset($_GET['comment_id'])) {
				if ((int)$_GET['comment_id'] != 0) {
					if(isset($_POST['text'])){
						$user_info=\Tango::session()->get('userInfo');
						$info = '<div class="string-reason">Комментарий удалён модератором по причине: '.$_POST['text'].'</div>';
						$array=array();
						$array['body']=$info;
						\Tango::sql()->update('concept_comment', $array, 'id='.(int)$_GET['comment_id']);
					}
				}
			}
			return 'ok';
			exit;
		}
	}