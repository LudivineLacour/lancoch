<?php

Class Autoloader{

	Static function charge_class($class){
	
	include_once("class/$class.class.php");
	}

	Static function autoloading(){
	
	spl_autoload_register([__CLASS__, 'charge_class']);
	}
}