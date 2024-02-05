<?php

// sukuriame užklausų klasės objektą
$servicesObj = new services();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
	
	// rodome ataskaitos parametrų įvedimo formą
	include "templates/{$module}/{$module}_services_form.tpl.php";
} else {
	$formSubmitted = true;
	
	// nustatome laukų validatorių tipus
	$validations = array (
			'dataNuo' => 'date',
			'dataIki' => 'date');
	
	// sukuriame validatoriaus objektą
	$validator = new validator($validations);
	

	if($validator->validate($_POST)) {
		// išrenkame ataskaitos duomenis
		$servicesData = $servicesObj->getOrderedServices($_POST['dataNuo'], $_POST['dataIki']);
		$servicesStats = $servicesObj->getStatsOfOrderedServices($_POST['dataNuo'], $_POST['dataIki']);
		
		// rodome ataskaitą
		include "templates/{$module}/{$module}_services_show.tpl.php";
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;
		
		// rodome ataskaitos parametrų įvedimo formą su klaidomis ir sustabdome scenarijaus vykdym1
		include "templates/{$module}/{$module}_services_form.tpl.php";
	}
}

