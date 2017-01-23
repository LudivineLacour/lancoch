'use strict';

/////////////////////////////////////////////////////////////////////////////////////////
// FONCTIONS                                                                           //
/////////////////////////////////////////////////////////////////////////////////////////
var FormValidator = function()
{
	this.totalErrors 	= null;
	this.$form 			= $('#booking_form');
	this.$blockMessage 	= $('#message');
}


FormValidator.prototype.checkEmail = function(){

	//Tableau contenant les erreurs de la fonction
	var error = new Array();

	// Mise en place d'une regex qui vérifie l'email
	var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	var email = $('#email').val();

	// Si condition réalisée, stockage du message dans le tableau
   if(!regex.test(email))
   {
 		 error.push(
            {
                fieldName : 'email',
                message   : 'est incorrect'
            });
   }

	// Copie des erreurs trouvées dans le tableau général des erreurs.
    $.merge(this.totalErrors, error);
}


FormValidator.prototype.checkFields = function(){

	//Tableau contenant les erreurs de la fonction
	var error = new Array();

	//Vérification des champs obligatoires
	this.$form.find('[data-required]').each(function()
    {
        var value;

        // Récupération de la valeur du champ du formulaire (sans les espaces).
        value = $(this).val().trim();

        // Si les champs sont vides, affichage des erreurs
        if(value.length == 0)
        {
            error.push(
            {
                fieldName : $(this).data('name'),
                message   : 'est requis'
            });
        }
    });

    // Copie des erreurs trouvées dans le tableau général des erreurs.
    $.merge(this.totalErrors, error);

}


FormValidator.prototype.checkPhone =function(){

	//Tableau contenant les erreurs de la fonction
	var error = new Array();

	var phone = $('#telephone').val().trim();

	if (phone.length < 10 || isNaN(phone)){

		error.push(
		{
		    fieldName : 'téléphone',
		    message   : 'doit comporter 10 chiffres'
		});
	}

	// Copie des erreurs trouvées dans le tableau général des erreurs.
    $.merge(this.totalErrors, error);
}


FormValidator.prototype.checkAll = function(event){
	// Remise à zero du tableau par défaut
	this.totalErrors = [];
	// Execution des méthodes qui stockeront les erreurs dans le tableu si les conditions sont executées
	this.checkEmail();
	this.checkFields();
	this.checkPhone();

	// Si le tableau contient plus d'une erreur, affichage des erreurs
	if(this.totalErrors.length > 0)
	{
		event.preventDefault();
		
		// Générer les messages contenus dans le tableau au bon endroit
		var $errorMessage = this.$blockMessage.children('p');
		$errorMessage.empty();


		// Parcours du tableau contenant les erreurs
		this.totalErrors.forEach(function(error)
    	{
			var message;

            // Construction du message d'erreur final.
            message =
                '<em>Le champ <strong>' + error.fieldName +
                '</strong> ' + error.message + '.</em><br>';

        	$errorMessage.append(message);
		});
	}else
	{
		return true;
	}
		
}


FormValidator.prototype.run = function()
{
	$('#submit').on('click',this.checkAll.bind(this));
}