"use strict";

/**********************************************/
/********************FONCTIONS*****************/
/**********************************************/
 var SaveBooking = function()
 {
 	this.$form 	= $('#booking_form');
 	this.$confirmation = $('#confirmation');
 	this.$loader = $('#loader');

 	this.$loader.hide();
 }


SaveBooking.prototype.sendData = function(event)
{
	//Blocage du submit
	event.preventDefault();

	//Affichage du loader
	this.$form.hide();
	this.$loader.show();

	//Configuration des données envoyées
	var data_form = $('#booking_form').serialize();
	var url ='model/formBooking.php';

	$.post(url, data_form, this.getMessage.bind(this));
}

SaveBooking.prototype.getMessage = function(retour) 
{
	this.$loader.hide();

	this.$confirmation.html('');
	this.$confirmation.html('<p><i class="fa fa-check-circle" aria-hidden="true"></i></br>Nous avons bien pris en compte votre réservation !</p>');

	setTimeout(this.hideConfirmation.bind(this), 4000);
}

SaveBooking.prototype.hideConfirmation = function()
{
	// Cache le message de confirmation
	this.$confirmation.hide();

	// Reset des champs
	this.$form[0].reset();
	// Reaffichage du formulaire
	this.$form.show();
}

 SaveBooking.prototype.run = function()
{
	$('#booking_form').submit(this.sendData.bind(this));	
}