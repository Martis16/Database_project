<?php

// sukuriame užklausų klasės objektą
$employeesObj = new employees();

if(!empty($id)) {
	// patikriname, ar darbuotojas neturi sudarytų sutarčių
	$count = $employeesObj->getContractCountOfEmployee($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// šaliname darbuotoją
		$employeesObj->deleteEmployee($id);
	} else {
		// nepašalinome, nes darbuotojas sudaręs bent vieną sutartį, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į darbuotojų puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>