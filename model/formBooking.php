<?php
/**
* 
*/
include_once('class/Autoloader.class.php');
Autoloader::autoloading();

// Instanciation de la connexion à la base de données
$pdo = new Connect();


// Instanciation de la class pour enregistrer en base
$saveBooking = new SaveBooking($pdo->get_pdo(), $_POST);
$saveBooking->saveBookingDb();
		

// Instanciation de la class pour envoyer l'email
$sendConfirmation = new SendEmail($_POST);
$sendConfirmation->sendEmailConfirmation();
$sendConfirmation->sendEmailNotification();

?>