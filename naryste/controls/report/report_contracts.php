<?php

// sukuriame užklausų klasės objektą
$contractsObj = new sutartis();

$formErrors = null;
$fields = array();

$data = array();
if(empty($_POST['submit'])) {
	// rodome ataskaitos parametrų įvedimo formą
	include "templates/{$module}/{$module}_contracts_form.tpl.php";
} else {
	// nustatome laukų validatorių tipus
	$validations = array (
		'dataNuo' => 'date',
		'dataIki' => 'date'
	);

	// sukuriame validatoriaus objektą
	$validator = new validator($validations);

	if($validator->validate($_POST)) {
		// išrenkame ataskaitos duomenis
		$contractData = $contractsObj->getCustomerContracts($_POST['dataNuo'], $_POST['dataIki']);
		$totalPrice = $contractsObj->getSumPriceOfContracts($_POST['dataNuo'], $_POST['dataIki']);
		$totalServicePrice = $contractsObj->getSumPriceOfOrderedServices($_POST['dataNuo'], $_POST['dataIki']);
		
		// perduodame datos filtro reikšmes į šabloną
		$data['dataNuo'] = $_POST['dataNuo'];
		$data['dataIki'] = $_POST['dataIki'];
		
		// rodome ataskaitą
		include "templates/{$module}/{$module}_contracts_show.tpl.php";
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;

		// rodome ataskaitos parametrų įvedimo formą su klaidomis
		include "templates/{$module}/{$module}_contracts_form.tpl.php";
	}


	




}