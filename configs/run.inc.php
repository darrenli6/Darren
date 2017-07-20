<?php
session_start();
//error level
error_reporting(E_ALL);
//ROOT_PATH is reality path
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));
//set charset
header('Content-Type:text/html;charset=utf-8');
//set timezone
date_default_timezone_set('Asia/Shanghai');
//config file
require ROOT_PATH.'/configs/profile.inc.php';
//smarty engine file
require ROOT_PATH.'/smarty/Smarty.class.php';
//auto load class
function __autoload($_className) {
	if (substr($_className, -6) == 'Action') {
		require ROOT_PATH.'/controller/'.$_className.'.class.php';
	} elseif (substr($_className, -5) == 'Model') {
		require ROOT_PATH.'/model/'.$_className.'.class.php';
	} elseif (substr($_className, -5) == 'Check') {
		require ROOT_PATH.'/check/'.$_className.'.class.php';
	} else {
		require ROOT_PATH.'/public/'.$_className.'.class.php';
	}
}

//single model entrance
Factory::setAction()->run();
?>