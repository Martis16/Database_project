<?php

// sukuriame užklausų klasės objektą
$modelsObj = new models();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $modelsObj->getModelListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $modelsObj->getModelList($paging->size, $paging->first);

// įtraukiame šabloną
include "templates/{$module}/{$module}_list.tpl.php";
	
?>