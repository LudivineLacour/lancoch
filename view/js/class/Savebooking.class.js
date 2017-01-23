"use strict";

/**********************************************/
/********************FONCTIONS*****************/
/**********************************************/
 var SaveBooking = function()
 {
 	this.$form 	= $('#booking_form');
 	this.$confirmation = $('#confirmation');
 }


SaveBooking.prototype.sendData = function(event)
{
	//Blocage du submit
	event.preventDefault();

	//Configuration des données envoyées
	var data_form = $('#booking_form').serialize();
	var url ='model/formBooking.php';

	console.log(data_form);

	$.post(url, data_form, this.getMessage.bind(this), 'html');
}

SaveBooking.prototype.getMessage = function() 
{
	this.$form.hide();

	this.$confirmation.html('');
	this.$confirmation.html('<p>Nous avons bien pris en compte votre réservation !</p>');

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