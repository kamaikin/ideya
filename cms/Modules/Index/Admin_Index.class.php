<?php
	class IndexAdminIndex extends BaseController{
		public function __construct(){
			parent::__construct();
		}

		protected function IndexAction(){
			//Tango::plugins('user')->userId(1)->getId(); exit;
			//	Всего идей
			$query="SELECT count(`id`) as count FROM concept";
			$SQL=\Tango::sql()->select($query);
			$this->_view['data1']=$SQL[0]['count'];
			//	Идей за последние сутки
			$time=60*60*24;
			$time=time() - $time;
			$query="SELECT count(`id`) as count FROM concept WHERE `date` >?";
			$SQL=\Tango::sql()->select($query, array($time));
			$this->_view['data2']=$SQL[0]['count'];
			//	Всего комментариев
			$query="SELECT count(`id`) as count FROM concept_comment";
			$SQL=\Tango::sql()->select($query);
			$this->_view['data3']=$SQL[0]['count'];
			//	Комментариев за последние сутки
			$query="SELECT count(`id`) as count FROM concept_comment WHERE `date` >?";
			$SQL=\Tango::sql()->select($query, array($time));
			$this->_view['data4']=$SQL[0]['count'];
			//	Всего лайков
			$query="SELECT count(`id`) as count FROM concept_licke";
			$SQL=\Tango::sql()->select($query);
			$this->_view['data5']=$SQL[0]['count'];
			//	Лайков за последние сутки
			$query="SELECT count(`id`) as count FROM concept_licke WHERE datetime >?";
			$SQL=\Tango::sql()->select($query, array($time));
			$this->_view['data6']=$SQL[0]['count'];
			//	Всего пользователей
			$query="SELECT count(`id`) as count FROM user_data";
			$SQL=\Tango::sql()->select($query);
			$this->_view['data7']=$SQL[0]['count'];
			//	Пользователей за последние сутки
			$query="SELECT count(`id`) as count FROM user_data WHERE register_date >?";
			$SQL=\Tango::sql()->select($query, array($time));
			$this->_view['data8']=$SQL[0]['count'];
			$this->_view['includeFileName']='Index/index.tpl';
		}
	}