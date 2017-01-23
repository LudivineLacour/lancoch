<?php

require_once 'PHPMailer/PHPMailerAutoload.php';

Class SendEmail
{
	private $nom;
	private $prenom;
	private $email;
	private $telephone;
	private $couverts;
	private $date;
	private $heure;
	private $mailer;

	function __construct ($post)
	{
		foreach ($post as $key => $value) {
			$this->$key = $value;
		}
	}

	private function config()
	{
		$this->mailer = new PHPMailer;

		$this->mailer->isSMTP();                                      // Set mailer to use SMTP
		$this->mailer->Host = 'smtp.gmail.com';  						// Specify main and backup SMTP servers
		$this->mailer->SMTPAuth = true;                               // Enable SMTP authentication
		$this->mailer->Username = 'ludivine.test.email@gmail.com';      // SMTP username
		$this->mailer->Password = 'jeTesteMesEmails';                   // SMTP password
		$this->mailer->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$this->mailer->Port = 465;
	}

	public function sendEmailConfirmation()
	{
		$this->config();

		$this->mailer->setFrom('lancoch63@gmail.com', 'Auberge L\'ancoch');
		$this->mailer->addAddress($this->email);
		$this->mailer->Subject  = 'Votre table réservée à l\'auberge !';
		$this->mailer->Body     = 'Bonjour '.$this->prenom.', Nous vous confirmons votre réservation à l\'auberge l\'ancoch pour '.$this->couverts.' personnes, le '.$this->date.' à '.$this->heure.'. N\'hésitez pas à nous contacter en cas de changement.';
		if(!$this->mailer->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $this->mailer->ErrorInfo;
		}

		$this->mailer->setFrom('lancoch63@gmail.com', 'Auberge L\'ancoch site');
		$this->mailer->addAddress('lancoch63@gmail.com');
		$this->mailer->Subject  = 'Nouvelle réservation à l\'auberge !';
		$this->mailer->Body     = 'Bonjour Philippe, Nous avons une nouvelle réservation à l\'auberge : '.$this->couverts.' personnes, le '.$this->date.' à '.$this->heure.', au nom de '.$this->nom.' '.$this->prenom.'. Bonne journée !';
		if(!$this->mailer->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $this->mailer->ErrorInfo;
		}else
		{
			echo 'Message has been send';
		}
	}
}