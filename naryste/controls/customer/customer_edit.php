<?php
	
// sukuriame užklausų klasės objektą
$customersObj = new customers();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('asmens_kodas', 'vardas', 'pavarde', 'gimimo_data', 'telefonas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'asmens_kodas' => 11,
	'vardas' => 20,
	'pavarde' => 20
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'asmens_kodas' => 'positivenumber',
		'vardas' => 'alfanum',
		'pavarde' => 'alfanum',
		'gimimo_data' => 'date',
		'telefonas' => 'phone',
		'epastas' => 'email'
	);

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// redaguojame klientą
		$customersObj->updateCustomer($_POST);

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
} else {
	// išrenkame klientą
	$data = $customersObj->getCustomer($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>