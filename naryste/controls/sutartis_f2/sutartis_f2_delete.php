<?php

// sukuriame užklausų klasės objektą
$contractsObj = new sutartis();

if(!empty($id)) {
	// pašaliname užsakytas paslaugas
	$contractsObj->deleteOrderedServices($id);

	// šaliname sutartį
	$contractsObj->deleteContract($id);

	// nukreipiame į sutarčių puslapį
	common::redirect("index.php?module={$module}&action=list");
	die();
}

?>