<?php
	namespace Cms;
	use Cms;
	class AppKernel extends Kernel{
		private $_admin_flag='front';
		public function __construct(){
			$this->loadClass();
			parent::__construct();
		}

		private function loadClass(){
			//print_r($_GET);
			include_once DOCUMENT_ROOT.'/cms/TangoPHP/Tango.php';
			\Tango::session();
			$config=DOCUMENT_ROOT.'/cms/Config/Config.db';
			\Tango::config($config);
			$this->configActivate($config);
			//	Определяем по пришедшему роутингу, какой именно класс надо запустить на выполнение
			$this->routing();
			//	Если мы сюда дошли значит файл был загружен))) Проверяем есть или нет в этом файл нужный класс.
			if (class_exists($this->className)) {
				//print_r($this->className); exit;
				//	Все хорошо, подключаем базу данных
				$dbData=\Tango::config()->get('Tangophp.db.mysql');
				$array=array('method'=>$dbData['method'],'sql_host'=>$dbData['sql_host'],'db_name'=>$dbData['db_name'],'db_user'=>$dbData['db_user'],'db_pass'=>$dbData['db_pass']);
				\Tango::sql(0, $array);
				//	Работаем дальше
				\Tango::registry('actionName', $this->actionName);
				$class = new $this->className();
				if ($class->getView()!=array()) {
					include_once DOCUMENT_ROOT.'/cms/Component/Smarty.class.php';
					//	Подключаем шаблон и выводим даные...
					foreach ($class->getView() as $key => $value) {
						$this->assign($key, $value);
					}
					$this->display($class->getLaout());
				}else{
					//	Вида нет, ничего не делаем....
				}
			}else{
				if (DEBUG) {
					//	Нужно создать сообщение для пользователя.
					$message="Не обнаружен класс приложения: $this->className";
					\Tango::HPre($message);
				}else{
					//	Однако 404!
					header("HTTP/1.0 404 Not Found");
					header("Location: /error/404"); exit;
				}
			}
		}

		private function routing(){
			$modules=$this->getIsset('modules', 'index');
			$controller=$this->getIsset('controller', 'index');
			$action=$this->getIsset('action', 'index');
			$admin_flag=$this->getIsset('admin_flag', 'Front');
			$this->_admin_flag=$admin_flag;
			$acl_resourse=$admin_flag.'_'.$modules.'_'.$controller.'_'.$action;
			\Tango::registry('acl_resourse', $acl_resourse);
			$file_1=DOCUMENT_ROOT.'/cms/Modules/'.ucfirst($modules).'/'.ucfirst($admin_flag).'_'.ucfirst($controller).'.class.php';
			if (file_exists($file_1)) {
				include_once $file_1;
				$this->className=ucfirst($modules).ucfirst($admin_flag).ucfirst($controller);
				$this->actionName=ucfirst($action);
			} else {
				//	Файла нет в модулях, надо посмотреть его в контроллерах...
				$file_2=DOCUMENT_ROOT.'/cms/Controllers/'.ucfirst($modules).'_'.ucfirst($controller).'.class.php';
				if (file_exists($file_2)) {
					include_once $file_2;
					$this->className=ucfirst($modules).ucfirst($controller);
					$this->actionName=ucfirst($action);
				} else {
					if (DEBUG) {
						//	Нужно создать сообщение для пользователя.
						$message="Не обнаружены файлы контроллеров приложения по путям:\n$file_1\n$file_2";
						\Tango::HPre($message);
					}else{
						//	Однако 404!
						header("HTTP/1.0 404 Not Found");
						header("Location: /error/404"); exit;
					}
				}
			}
		}

		private function configActivate($config){
			//	Инициализируем файл конфигурации приложения.
			if (DEV_MODE) {
				$array = parse_ini_file(DOCUMENT_ROOT.'/cms/Config/Config.ini');
				foreach ($array as $key => $value) {
					\Tango::config()->set($key, $value);
				}
				$array = parse_ini_file(DOCUMENT_ROOT.'/cms/Config/Dev_config.ini');
				foreach ($array as $key => $value) {
					\Tango::config()->set($key, $value);
				}
				\Tango::config()->save();
			}else{
				if (!file_exists($config)) {
					$array = parse_ini_file(DOCUMENT_ROOT.'/cms/Config/Config.ini');
					foreach ($array as $key => $value) {
						\Tango::config()->set($key, $value);
					}
					\Tango::config()->save();
				}
			}
		}

		private function display($tpl_name='main.tpl'){
			sSmarty::Init($this->_admin_flag)->display($tpl_name);
		}

		private function assign($name, $value){
			sSmarty::Init($this->_admin_flag)->assign($name, $value);
		}
	}