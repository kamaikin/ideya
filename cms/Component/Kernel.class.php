<?php
	//	Низкоуровневое ядро приложения.
	namespace Cms;
	use Cms;
	class Kernel{
		public function __construct(){
			//print_r(__METHOD__); echo'<hr>';
		}

		protected function getIsset($name, $default=''){
			if (isset($_GET[$name])) {
				return $_GET[$name];
			} else {
				return $default;
			}
			
		}
	}