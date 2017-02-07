<?php


Class SaveBooking 
{
	private $pdo;
	private $nom;
	private $prenom;
	private $email;
	private $telephone;
	private $couverts;
	private $date;
	private $heure;

	function __construct ($pdo, $post)
	{
		$this->pdo = $pdo;

		foreach ($post as $key => $value) {
			$this->$key = $value;
		}
	}

	public function checkExistUser()
	{
		$requete = "SELECT * FROM clients WHERE email = ?";
		// Préparation requête
		$query = $this->pdo->prepare($requete);
		$query->execute(array($this->email));

		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		if (count($result) == 0)
		{
			$requete2 = "INSERT INTO clients(nom, prenom, email, telephone) VALUES (?, ?, ?, ?)";
			$query2 = $this->pdo->prepare($requete2);
			$query2->execute(array($this->nom, $this->prenom, $this->email, $this->telephone));
		}
	}
	
	public function saveBookingDb()
	{
		// Enregistrement du client dans la base si inexistant
		$this->checkExistUser();

		// Formatage de la dat epour enregistrement en base
		$dateformat = new DateTime($this->date);
		$date = $dateformat->format('Y-m-d');

		$requete = "
					INSERT INTO booking(`heure`,`date_booking`,`couverts`,`id_user`)
					SELECT ?, ?, ?, id 
					FROM clients WHERE email = ?";
		$query = $this->pdo->prepare($requete);
		$query->execute([$this->heure, $date, $this->couverts, $this->email]);
	}
}