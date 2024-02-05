<?php
	
// sukuriame užklausų klasių objektus
$contractsObj = new contracts();
$servicesObj = new services();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $servicesObj->getServicesListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);	

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio paslaugas
$data = $servicesObj->getServicesList($paging->size, $paging->first);

// įtraukiame šabloną
include "templates/{$module}/{$module}_list.tpl.php";

?>