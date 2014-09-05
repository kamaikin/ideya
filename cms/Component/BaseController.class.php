<?php
	class BaseController{
		protected $_view=array();
		protected $_laout='main.tpl';
		
		public function __construct(){
			$action=Tango::registry('actionName').'Action';
			//	Получаем роль пользователя
			$user_info=\Tango::session()->get('userInfo');
			$user_info = \Tango::plugins('user')->userId($user_info['user_id'])->userInfoAll();
			\Tango::session()->set('userInfo', $user_info);
			if ($user_info){
				$role=$user_info['user_role']; 
				$this->_view['index_autorize']=TRUE;
				$this->_view['index_user_login']=$user_info['surname'].' '.$user_info['name'];
				$this->_view['index_user_avatar']=$user_info['avatar'];
				$this->_view['index_user_id']=$user_info['user_id'];
				$this->_view['index_md5_key']=md5(time());
				$this->_view['index_user_role']=$user_info['user_role'];
				//	Посчитать  процент заполнения....
				$start=round($user_info['points']/100)*100;
				$stop = $start + 200;
				for ($i=$start; $i < $stop;) { 
					if ($user_info['points'] < $i) {
						$this->_view['index_points'] = $user_info['points'];
						$this->_view['index_points_max'] = $i;
						$p = $i / 100;
						$p = round($user_info['points']/$p);
						$this->_view['index_points_procent'] = $p;
						break;
					}
					$i = $i + 50;
				}
			}else{
				$role=\Tango::config()->get('Acl.role.default'); 
				$this->_view['index_autorize']=FALSE;
			}
			$acl_resourse = \Tango::registry('acl_resourse');
			$this->_acl();
			//print_r($acl_resourse); echo'<hr>';
			if(Tango::plugins('acl')->isAllowed($role, $acl_resourse, 'view')) {
				if (\Tango::session()->get('REQUEST_URI')) {
					\Tango::registry('REQUEST_URI', \Tango::session()->get('REQUEST_URI'));
				}
				\Tango::session()->set('REQUEST_URI', $_SERVER['REQUEST_URI']);
		    	//\Tango::HPre('Доступ открыт');
		    }else{
		    	if ($user_info) {
		    		\Tango::session()->setFlash('error','Не достаточно прав пользователя');
					\Tango::session()->setFlash('error_id',3);
		    	}
		    	//print_r($acl_resourse); exit;
		    	header("Location: /login"); exit;
		    }
			if (method_exists($this, $action)) {
				$this->$action();
			} else {
				if (DEBUG) {
					$message='В классе: '.get_class($this).' Не обнаружен метод: '.$action;
					\Tango::HPre($message);
				}else{
					header("HTTP/1.0 404 Not Found");
					header("Location: /error/404"); exit;
				}
			}
			//print_r(__METHOD__); echo'<hr>';
		}

		public function getView(){
			return $this->_view;
		}

		public function getLaout(){
			return $this->_laout;
		}

		private function _acl(){
			//	Получаем текущий ресурс
			$acl_resourse = \Tango::registry('acl_resourse');
			//	Его стоит занести в базу данных, что бы потом администратор мог проставить разрешения.
			
			//	Добавляем возможные роли
			Tango::plugins('acl')
				->addRole('guest')
				->addRole('user','guest')
				->addRole('sponsor','user')
				->addRole('moderator','user')
				->addRole('admin',array('moderator', 'sponsor'));
			// Создаём ресурс page («страница»)
			$query="SELECT * FROM acl_resourse";
			$SQL=\Tango::sql()->select($query);
			$flag=TRUE;
			//print_r($acl_resourse); exit;
			foreach ($SQL as $key => $value) {
				if($acl_resourse==$value['resourse']){
					$flag=FALSE;
				}
				//print_r($value['resourse']); echo'<hr>';
				\Tango::plugins('acl')->addResourse($value['resourse']);
				\Tango::plugins('acl')->allow($value['group'], $value['resourse'], 'view');
			}
			//print_r($value['resourse']); exit;
			if ($flag) {
				$array=array('resourse'=>$acl_resourse, 'group'=>'admin');
				\Tango::sql()->insert('acl_resourse', $array);
				\Tango::plugins('acl')->addResourse($acl_resourse);
				\Tango::plugins('acl')->allow('admin', $acl_resourse, 'view');
			}
		    // Администратор не наследует ничего, но обладает всеми привилегиями
		    \Tango::plugins('acl')->allow('admin');
		    //`Попытка передать в шаблон разрешения на доступ, и екущий ресурс..
		    $this->_view['index_acl']=\Tango::plugins('acl');
		    $this->_view['index_acl_resourse']=$acl_resourse;
		}

		/*
		 *	$url - Исходный урл к которому добавляем пагинацию
		 *	$page - Текущая страница
		 *	$count - сколько всего записей
		 *	$numberRecords - Количество записей на странице
		 */
		protected function _getPaginator($url, $page, $count, $numberRecords){
			$text = '';
			if($page>1){
				$pref_page = $page -1;
				if($pref_page==1){
					$text.= '<a href="'.$url.'" class="previouspostslink"></a>';
				}else{
					if($pref_page<10){$pref_page='0'.$pref_page;}
					$text.= '<a href="'.$url.'page'.$pref_page.'.html" class="previouspostslink"></a>';
				}
			}
			//	Ссылка на следующую страницу
			$max_page = $count / $numberRecords;
			$max_page = floor($max_page) +1;
			if ($page < $max_page) {
				$nex_page = $page + 1;
				if($nex_page<10){$nex_page='0'.$nex_page;}
				$text.= '<a href="'.$url.'page'.$nex_page.'.html" class="nextpostslink"></a>';
			}
			$text.='<ul class="pagenavi-body">';
			for ($i=0; $i < $max_page ; $i++) {
				$n=$i+1;
				if($n == $page){
					$text.='<li class="dib pagenavi-item"><span class="pagenavi-current">'.$n.'</span></li>';
				}else{
					if($n1<10){$n1='0'.$n;}else{$n1=$n;}
					$text.='<li class="dib pagenavi-item"><a href="'.$url.'page'.$n1.'.html" class="pagenavi-link">'.$n.'</a></li>';
				}
			}
			$text.='</ul>';
        	return $text;
		}

		protected function _getRightSidebar(){
			//	Найти три идеи с максимальной популярностью
			$query="SELECT id, name FROM concept c";
			if (\Tango::config()->get('Moderating.user.posts')=='pre') {
				$query.=" WHERE c.moderating='y' ORDER BY c.`points` DESC LIMIT 0, ".\Tango::config()->get('Concept.right.sidebar');
			}else{
				$query.=" WHERE 1=1 ORDER BY c.`points` DESC LIMIT 0, ".\Tango::config()->get('Concept.right.sidebar');
			}
			$SQL = \Tango::sql()->select($query);
			$this->_view['RightSidebarIdea'] = $SQL;
			$this->_view['RightSidebarIdea_array'] = array('first', 'second', 'third');
			//	Вывести облако тегов
			//	Смотрим, есть ли в базе данных актуальный набор
			$query="SELECT value FROM temp WHERE `key`='tags_cloud' AND datetime>".time();
			$SQL = \Tango::sql()->select($query);
			if ($SQL==array()) {
				//	Собираем заново 
				$query="SELECT * 
					FROM   (SELECT tags.name  AS title, 
				       tags.url  AS alias, 
				       COUNT(tags_to_concept.id) AS cnt 
					FROM   tags 
				       INNER JOIN tags_to_concept
				         ON ( tags_to_concept.tags_id = tags.id ) 
				GROUP  BY tags.id 
				ORDER  BY cnt DESC 
				LIMIT  20) AS subq
				ORDER  BY title";
				$SQL = \Tango::sql()->select($query);
				$text='';
				foreach ($SQL as $key => $value) {
					$text.='<li class="tags-widget-item"><a href="/tags/'.$value['alias'].'.html" class="tags-widget-link">'.$value['title'].'</a></li>';
				}
				$array=array();
				$array['key']='tags_cloud';
				$array['value']=$text;
				$array['datetime']=time() + \Tango::config()->get('Tags.compile.save.time');
				\Tango::sql()->update('temp', $array, "`key`='tags_cloud'");
				$this->_view['tags'] = $text;
			} else {
				//	Выводим результат
				$this->_view['tags'] = $SQL[0]['value'];
			}
		}

		/**
		 *  Метод переводит из кирилицы в латиницу. Транслитерирует. Откуда утащил 
		 *  схемку уже не помню, но транслит получается вполне читаемый... Пробел 
		 *  заменяется на подчеркивание.
		 *
		 *  @param string $string
		 *  @return string $string
		 */
		protected function translit($string){
			$trans = array("а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e", 
			"ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", 
			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t", 
			"у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh",
			"ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya","А"=>"a","Б"=>"b","В"=>"v",
			"Г"=>"g","Д"=>"d","Е"=>"e", "Ё"=>"yo","Ж"=>"j","З"=>"z","И"=>"i",
			"Й"=>"i","К"=>"k", "Л"=>"l","М"=>"m","Н"=>"n","О"=>"o","П"=>"p", 
			"Р"=>"r","С"=>"s","Т"=>"t","У"=>"y","Ф"=>"f", "Х"=>"h","Ц"=>"c",
			"Ч"=>"ch","Ш"=>"sh","Щ"=>"sh", "Ы"=>"i","Э"=>"e","Ю"=>"u","Я"=>"ya",
			"ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"","-"=>"_"," "=>"_",","=>"","."=>"");
			$string=strtr($string, $trans);
			return $string;
		}

		protected function _sendEmail($mailKey, $data, $emailAddress, $name=''){
			//	В переменной $key лежит ключ для запроса письма из базы данных.
			//	Вот его и запрашиваеем)
			$arr_key=array();
			$arr_value=array();
			foreach ($data as $key => $value) {
				$arr_key[]='{'.$key.'}';
				$arr_value[]=$value;
			}
			$query="SELECT * FROM mail_templates WHERE name=?";
			$Tmail=\Tango::sql()->select($query, array($mailKey));
			if($Tmail!=array()){
				$query="SELECT * FROM mail_template_values WHERE template_id=?";
				$SQL=\Tango::sql()->select($query, array($Tmail[0]['id']));
				foreach ($SQL as $key => $value) {
					$arr_key[]='{'.$value['key'].'}';
					$arr_value[]=$value['value'];
				}
				$Body = str_replace ($arr_key, $arr_value, $Tmail[0]['body']);
				$Subject = str_replace ($arr_key, $arr_value, $Tmail[0]['subject']);
				\Tango::plugins('phpmailer')->Subject = $Subject;
				\Tango::plugins('phpmailer')->Body = $Body;
				\Tango::plugins('phpmailer')->isHTML(true);
				if ($name=='') {
					\Tango::plugins('phpmailer')->AddAddress($emailAddress);
				} else {
					\Tango::plugins('phpmailer')->AddAddress($emailAddress, $name);
				}
				\Tango::plugins('phpmailer')->Send();
				\Tango::plugins('phpmailer')->ClearAddresses();
				\Tango::plugins('phpmailer')->ClearAttachments();
			}
		}
	}