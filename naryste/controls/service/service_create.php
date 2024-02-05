<?php
	
// sukuriame užklausų klasių objektus
$contractsObj = new contracts();
$servicesObj = new services();

$formErrors = null;
$data = array();
$data['paslaugos_kainos'] = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'kaina', 'galioja_nuo');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 40,
	'aprasymas' => 300
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything',
		'aprasymas' => 'anything',
		'kaina' => 'price',
		'galioja_nuo' => 'date');

	// sukuriame validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);
	
	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// įrašome naują pasaugą ir gauname jos id
		$id = $servicesObj->insertService($_POST);
		
		// įrašome paslaugų kainas
		foreach($_POST['kaina'] as $keyForm => $priceForm) {
			$servicesObj->insertServicePrices($id, $_POST['galioja_nuo'][$keyForm], $_POST['kaina'][$keyForm]);
		}

		// nukreipiame į paslaugų puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
		
		$data['paslaugos_kainos'] = array();
		if(isset($_POST['kaina']) && sizeof($_POST['kaina']) > 0) {
			$i = 0;
			foreach($_POST['kaina'] as $key => $val) {
				$data['paslaugos_kainos'][$i]['kaina'] = $val;
				$data['paslaugos_kainos'][$i]['galioja_nuo'] = $_POST['galioja_nuo'][$key];
				
				$i++;
			}
		}
	}
}

// į paslaugų kainų masyvo pradžią įtraukiame tuščią reikšmę, kad paslaugų kainų formoje
// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
// kiekį kainų
array_unshift($data['paslaugos_kainos'], array());

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>