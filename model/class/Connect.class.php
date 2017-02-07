<?php

Class Connect{

	private $_pdo;
	
	function get_pdo(){
		return $this->_pdo; 
	}
	// Ajout d'arguments qui sont définis par défaut si on travaille plus souvent à un endroit
	function __construct($pass = 'Phil08012017', $serveur = 'lancochfbxphil.mysql.db', $dbname = 'lancochfbxphil', $user = 'lancochfbxphil'){

		$this->_pdo = new PDO('mysql:host='.$serveur.';dbname='.$dbname.';charset=UTF8',
						$user,
						$pass,
					    [
					    	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
					    ]);
	}
}