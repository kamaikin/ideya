<?php
	if(!defined("DOCUMENT_ROOT")){define("DOCUMENT_ROOT", __DIR__);}
	include_once DOCUMENT_ROOT.'/cms/TangoPHP/Tango.php';
	\Tango::session();
	$config=DOCUMENT_ROOT.'/cms/Config/Config.db';
	\Tango::config($config);
	//	Пытаемся отправить письмо
	\Tango::plugins('phpmailer')->Subject = 'Это тест';
	\Tango::plugins('phpmailer')->Body = '<html>
<head>
<title>My HTML Email</title>
</head>
<body>
<img src="http://www.phpfreaks.com/images/phpfreaks_logo.jpg" alt="PHP Freaks" />

<h2>PHP Freaks Rules!</h2>
<p>We invite you to visit <a href="http://www.phpfreaks.com" title="PHP Freaks">PHP Freaks.com</a>
for a loving community of PHP Developers who enjoy helping each other learn the language!</p>
<p>Sincerely,<br />
PHP Freaks Staff</p></body></html>';
	\Tango::plugins('phpmailer')->isHTML(true);
	\Tango::plugins('phpmailer')->AddAddress('foo@host.com', 'Eric Rosebrock');
	if(!\Tango::plugins('phpmailer')->Send())
{
  echo 'Не могу отослать письмо!';
}
else
{
  echo 'Письмо отослано!';
}
	\Tango::plugins('phpmailer')->ClearAddresses();
	\Tango::plugins('phpmailer')->ClearAttachments();