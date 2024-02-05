<?php

// sukuriame užklausų klasių objektus
$contractsObj = new sutartis();
$servicesObj = new services();
$carsObj = new cars();
$employeesObj = new employees();
$customersObj = new customers();
$modelsObj = new models();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('Nr', 'Pasirasymo_data', 'Baigia_galioti', 'busena', 'fk_Saskaitaid_Saskaita', 'fk_Asmens_id', 'fk_Narysteid_Naryste', 'kiekiai');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'Nr' => 'positivenumber',
		'Pasirasymo_data' => 'date',
		'Baigia_galioti' => 'date',
		'busena' => 'alfanum',
		'fk_Saskaitaid_Saskaita' => 'positivenumber',
		'fk_Asmens_id' => 'alfanum',
		'fk_Narysteid_Naryste' => 'positivenumber',
		'kiekis' => 'int');
	
		
	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// atnaujiname sutartį
		$contractsObj->updateContract($_POST);

		// pašaliname nebereikalingas paslaugas ir įrašome naujas
		// gauname esamas paslaugas
		$servicesFromDb = $contractsObj->getOrderedServices($id);

		// jeigu paslaugos kainos nerandame iš formos gautame masyve, šaliname
		foreach($servicesFromDb as $serviceDb) {
			$found = false;
			if(isset($_POST['paslauga'])) {
				foreach($_POST['paslauga'] as $keyForm => $serviceForm) {
					// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
					$tmp = explode("#", $serviceForm);
					
					$serviceId = $tmp[0];
					//$priceFrom = $tmp[1];
					
					if($serviceDb['fk_Papildoma_Paslaugaid_Papildoma_Paslauga'] == $serviceId && $serviceDb['Sumine_kaina'] == $_POST['paslaugos_kaina'][$keyForm] && $serviceDb['kiekis'] == $_POST['paslaugos_kiekis'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// šalinama paslaugos kaina
				$contractsObj->deleteOrderedService($id, $serviceDb['fk_Papildoma_Paslaugaid_Papildoma_Paslauga']);
			}
		}
		
		if(isset($_POST['paslauga'])) {
			foreach($_POST['paslauga'] as $keyForm => $serviceForm) {
				// jeigu užsakytos paslaugos nerandame duomenų bazėje, tačiau ji yra formoje, įrašome

				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
				$tmp = explode("#", $serviceForm);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];

				$found = false;
				foreach($servicesFromDb as $serviceDb) {
					if($serviceDb['fk_Papildoma_Paslaugaid_Papildoma_Paslauga'] == $serviceId && $serviceDb['Sumine_kaina'] == $_POST['paslaugos_kaina'][$keyForm] && $serviceDb['kiekis'] == $_POST['paslaugos_kiekis'][$keyForm]) {
						$found = true;
					}
				}

				if(!$found) {
					// įrašoma paslaugos kaina
					$contractsObj->insertOrderedService($id, $serviceId, $_POST['paslaugos_kaina'][$keyForm], $_POST['paslaugos_kiekis'][$keyForm]);
				}
			}
		}

		// nukreipiame vartotoją į sutarčių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
		if(isset($_POST['paslauga'])) {
			$i = 0;
			foreach($_POST['paslauga'] as $key => $val) {
				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}
				$tmp = explode("#", $val);
				
				$serviceId = $tmp[0];
				//$priceFrom = $tmp[1];
				
				$data['uzsakyta_paslauga'][$i]['fk_Papildoma_Paslaugaid_Papildoma_Paslauga'] = $serviceId;
				//$data['uzsakyta_paslauga'][$i]['fk_kaina_galioja_nuo'] = $priceFrom;
				$data['uzsakyta_paslauga'][$i]['Sumine_kaina'] = $_POST['paslaugos_kaina'][$key];
				$data['uzsakyta_paslauga'][$i]['kiekis'] = $_POST['paslaugos_kiekis'][$key];


				$i++;
			}
		}
		
		array_unshift($data['uzsakyta_paslauga'], array());
	}
} else {
	//  išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $contractsObj->getContract($id);
	$data['uzsakyta_paslauga'] = $contractsObj->getOrderedServices($id);

	// į užsakytų paslaugų masyvo pradžią įtraukiame tuščią reikšmę, kad užsakytų paslaugų formoje
	// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
	// kiekį paslaugų
	array_unshift($data['uzsakyta_paslauga'], array());
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>