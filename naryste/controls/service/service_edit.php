<?php
	
// sukuriame užklausų klasių objektus
$contractsObj = new contracts();
$servicesObj = new services();

$formErrors = null;
$data = array();

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
		// atnaujiname duomenis
		$servicesObj->updateService($_POST);

		// pašaliname nebereikalingas paslaugų kainas ir įrašome naujas
		// gauname esamas paslaugų kainas
		$servicePricesFromDb = $servicesObj->getServicePrices($id);

		// jeigu paslaugos kainos nerandame iš duomenų įvedimo formos gautame masyve, šaliname
		foreach($servicePricesFromDb as $priceDb) {
			$found = false;
			if(isset($_POST['kaina'])) {
				foreach($_POST['kaina'] as $keyForm => $priceForm) {
					if($priceDb['kaina'] == $_POST['kaina'][$keyForm] && $priceDb['galioja_nuo'] == $_POST['galioja_nuo'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// šalinama paslaugos kaina
				$servicesObj->deleteServicePrice($id, $priceDb['galioja_nuo'], $priceDb['kaina']);
			}
		}

		if(isset($_POST['kaina'])) {
			foreach($_POST['kaina'] as $keyForm => $priceForm) {
				// jeigu paslaugos kainos nerandame duomenų bazėje, tačiau ji yra formoje, įrašome
				$found = false;
				foreach($servicePricesFromDb as $priceDb) {
					if($priceDb['kaina'] == $_POST['kaina'][$keyForm] && $priceDb['galioja_nuo'] == $_POST['galioja_nuo'][$keyForm]) {
						$found = true;
					}
				}
	
				if(!$found) {
					// įrašoma paslaugos kaina
					$servicesObj->insertServicePrices($id, $_POST['galioja_nuo'][$keyForm], $priceForm);
				}
			}
		}

		// nukreipiame į paslaugų puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		
		// gauname įvestus laukus, kad galėtume užpildyti formą
		$data = $_POST;
		if(isset($_POST['kaina'])) {
			$i = 0;
			foreach($_POST['kaina'] as $key => $val) {
				$data['paslaugos_kainos'][$i]['fk_paslauga'] = $id;
				$data['paslaugos_kainos'][$i]['kaina'] = $val;
				$data['paslaugos_kainos'][$i]['galioja_nuo'] = $_POST['galioja_nuo'][$key];
				$data['paslaugos_kainos'][$i]['neaktyvus'] = $_POST['neaktyvus'][$key];
				$i++;
			}
		}

		array_unshift($data['paslaugos_kainos'], array());
	}
} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	if(!empty($id)) {
		$data = $servicesObj->getService($id);
		$data['paslaugos_kainos'] = array();
		
		$servicePrices = $servicesObj->getServicePrices($id);
		if(sizeof($servicePrices) > 0) {
			foreach($servicePrices as $key => $val) {
				// jeigu paslaugos kaina yra naudojama, jos koreguoti neleidziame ir įvedimo laukelį padarome neaktyvų
				$priceCount = $contractsObj->getPricesCountOfOrderedServices($id, $val['galioja_nuo']);
				if($priceCount > 0) {
					$val['neaktyvus'] = 1;
				}
				$data['paslaugos_kainos'][] = $val;
			}
		}

		// į paslaugų kainų masyvo pradžią įtraukiame tuščią reikšmę, kad paslaugų kainų formoje
		// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
		// kiekį kainų
		array_unshift($data['paslaugos_kainos'], array());
	}
}

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>