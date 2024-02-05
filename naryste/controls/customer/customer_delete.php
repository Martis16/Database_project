<?php

// sukuriame užklausų klasės objektą
$customersObj = new customers();

if(!empty($id)) {
	// patikriname, ar klientas neturi sudarytų sutarčių
	$count = $customersObj->getContractCountOfCustomer($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// šaliname klientą
		$customersObj->deleteCustomer($id);
	} else {
		// nepašalinome, nes klientas sudaręs bent vieną sutartį, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į klientų puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>