<?php

Class Connect{

	private $_pdo;
	
	function get_pdo(){
		return $this->_pdo; 
	}
	// Ajout d'arguments qui sont définis par défaut si on travaille plus souvent à un endroit
	function __construct($pass = '', $serveur = 'localhost', $dbname = 'lancoch', $user = 'root'){
		
		if($_SERVER['SERVER_NAME'] != 'localhost'){
			// Test de l'adresse IP pour redéfinir des données de connexion selon le serveur sur lequel on se trouve
			switch('REMOTE_ADDR'){

				case '120.0.0.0':
				$serveur = '';
				//...
				break;
			}
		}
		// Si l'on souhaite travailler sur deux localhost différents avec des user et pwd différents, il faudra alors instancier un nouvel objet avec les bonnes données de connexion

		$this->_pdo = new PDO('mysql:host='.$serveur.';dbname='.$dbname.';charset=UTF8',
						$user,
						$pass,
					    [
					    	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
					    ]);
	}
}