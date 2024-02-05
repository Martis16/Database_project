<?php
	
// sukuriame užklausų klasės objektą
$employeesObj = new employees();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('tabelio_nr', 'vardas', 'pavarde');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'tabelio_nr' => 6,
	'vardas' => 20,
	'pavarde' => 20
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'tabelio_nr' => 'alfanum',
		'vardas' => 'alfanum',
		'pavarde' => 'alfanum');

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// įrašome naują klientą
		$employeesObj->insertEmployee($_POST);

		// nukreipiame vartotoją į klientų puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	}
	else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
}

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>