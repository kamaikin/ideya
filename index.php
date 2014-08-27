<?php
	if(!defined("DOCUMENT_ROOT")){define("DOCUMENT_ROOT", __DIR__);}
	if(!defined("DEBUG")){define("DEBUG", TRUE);}
	if(!defined("DEV_MODE")){define("DEV_MODE", TRUE);}
	if (DEBUG) {
		$start_memory=memory_get_usage();
		$start = microtime(true);
	}
	//	Запускаем приложение
	include DOCUMENT_ROOT.'/cms/Autoload.php';
	$application = new Cms\App;
	$application->run();
	//	Приложение отработало, немного статистики и все.
	if (DEBUG) {
		echo'<hr>';
		echo "Память старт скрипта: ".Tango::other()->file_size($start_memory)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "Память окончаниие работы: ".Tango::other()->file_size(memory_get_usage())."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "Память максимум: ".Tango::other()->file_size(memory_get_peak_usage())."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$time = microtime(true) - $start;
		printf('Скрипт выполнялся %.4F сек.', $time);
	}