<?php
class Tango_user{
	private $_userInfo=array();
	public function __construct(){
		//echo __METHOD__.'';
	}
	public function userId($id=0){
		if (isset($this->_userInfo['id'])) {
			if ($this->_userInfo['id']!=$id) {
				if($id==0){
					//	Создать нового пользователя
					$this->_userCreate();
				}else{
					//	Загрузить пользователя из базы данных
					$this->_userLoad($id);
				}
			}
		} else {
			if($id==0){
				//	Создать нового пользователя
				$this->_userCreate();
			}else{
				//	Загрузить пользователя из базы данных
				$this->_userLoad($id);
			}
		}
		return $this;
	}

	//	Вернуть ВСЕ данные о пользователе которые на данный момент известны.
	public function userInfoAll(){
		return $this->_userInfo;
	}

	public function getId(){
		if (isset($this->_userInfo['id'])) {
			return $this->_userInfo['id'];
		} else {
			return 0;
		}
		
	}

	private function _userCreate(){
		//	Создание нового пользователя
	}

	private function _userLoad($id){
		//	Загрузить пользователя из базы данных
		$query="SELECT * FROM user_data WHERE user_id=?";
		$SQL=Tango::sql()->select($query, array($id));
		if ($SQL!=array()) {
			$this->_userInfo=$SQL[0];
		} else {
			$this->_userInfo=array();
		}
		
	}
}