<?php

include_once 'controller/homeController.php';
include_once 'controller/legalController.php';


if(isset($_GET['page']))
{
	switch ($_GET['page']) {
		case 'legal':
			$legal = new legalController();
			$legal->getRequest();
			break;
		
		default:
			$home = new homeController();
			$home->getRequest();
			break;
	}

}
else
{
	$home = new homeController();
	$home->getRequest();
}

