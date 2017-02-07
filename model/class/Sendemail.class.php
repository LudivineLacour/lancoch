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
		$this->mailer->Host = 'SSL0.OVH.NET';  						// Specify main and backup SMTP servers
		$this->mailer->SMTPAuth = true;                               // Enable SMTP authentication
		$this->mailer->Username = 'contact@lancoch.fr';      		// SMTP username
		$this->mailer->Password = 'Phil08012017';                   // SMTP password
		$this->mailer->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$this->mailer->Port = 465;
		$this->mailer->CharSet = "utf-8";
	}

	public function sendEmailConfirmation()
	{
		$this->config();

		$this->mailer->setFrom('contact@lancoch.fr', 'Auberge L\'ancoch');
		$this->mailer->addAddress($this->email);
		/*copie cachée : $this->mailer->AddBCC()*/
		$this->mailer->Subject  = 'Votre table réservée à l\'auberge !';
		/*Chargement du fichier*/
		$sign = file_get_contents('signature.html', FILE_USE_INCLUDE_PATH);
		$this->mailer->MsgHTML('<p>Bonjour '.$this->prenom.',</p><p>Nous vous confirmons votre réservation à l\'auberge L\'an coch pour <strong>'.$this->couverts.' personnes</strong>, le <strong>'.$this->date.'</strong> à <strong>'.$this->heure.'</strong>.</p><p>N\'hésitez pas à nous contacter si vous souhaitez changer votre réservation.</p><p>Chaleureusement,</p>'.$sign);
		$this->mailer->AltBody = 'Bonjour '.$this->prenom.', Nous vous confirmons votre réservation à l\'auberge l\'ancoch pour '.$this->couverts.' personnes, le '.$this->date.' à '.$this->heure.'. N\'hésitez pas à nous contacter en cas de changement.';
		/*$this->mailer->Body = 'Bonjour '.$this->prenom.', Nous vous confirmons votre réservation à l\'auberge l\'ancoch pour '.$this->couverts.' personnes, le '.$this->date.' à '.$this->heure.'. N\'hésitez pas à nous contacter en cas de changement.';*/
		if(!$this->mailer->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $this->mailer->ErrorInfo;
		}else
		{
			echo 'Message has been send';
		}
	}

	public function sendEmailNotification()
	{
		$this->config();

		$this->mailer->setFrom('contact@lancoch.fr', 'Auberge L\'ancoch site');
		$this->mailer->addAddress('contact@lancoch.fr');
		$this->mailer->AddReplyTo($this->email, $this->prenom.' '.$this->nom);
		$this->mailer->Subject  = 'Nouvelle réservation à l\'auberge !';
		//Message HTMl
		$this->mailer->MsgHTML('<p>Bonjour Philippe,</p><p>Nous avons une nouvelle réservation à l\'auberge : <strong>'.$this->couverts.' personnes</strong>, le <strong>'.$this->date.'</strong> à <strong>'.$this->heure.'</strong>.</p><p>Nom de la réservation : <strong>'.$this->nom.' '.$this->prenom.'.</p><p>Contacter la personne : par email à <strong>'.$this->email.'</strong> ou par téléphone au <strong>'.$this->telephone.'</strong>.</p><p>Bonne journée Chef !</p>');
		// Alternative message si boite email ne lis pas le HTML
		$this->mailer->AltBody = 'Bonjour Philippe, Nous avons une nouvelle réservation à l\'auberge : '.$this->couverts.' personnes, le '.$this->date.' à '.$this->heure.', au nom de '.$this->nom.' '.$this->prenom.'. Contacter la personne : par email à '.$this->email.' ou par téléphone au '.$this->telephone.'. Bonne journée !';
		if(!$this->mailer->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $this->mailer->ErrorInfo;
		}else
		{
			echo 'Message has been send';
		}
	}
}