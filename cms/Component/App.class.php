<?php
	namespace Cms;
	use Cms;
	class App{
		public function __construct(){
			//print_r(__METHOD__); echo'<hr>';
		}
		public function run(){
			$class = new AppKernel;
		}
	}