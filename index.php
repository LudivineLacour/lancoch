<?php
// Autoload des classes
include_once('model/class/Autoloader.class.php');
Autoloader::autoloading();

// Récupération des infos de page
$page = isset($_GET['page'])?$_GET['page']:null;

switch ($page) {
	case 'legal':
		$page = 'legal';
		break;
	
	default:
		$page = 'home';
		break;
}
include_once("controller/$page"."Controller.php");