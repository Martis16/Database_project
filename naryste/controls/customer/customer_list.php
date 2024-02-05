<?php

// sukuriame užklausų klasės objektą
$customersObj = new customers();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $customersObj->getCustomersListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio klientus
$data = $customersObj->getCustomersList($paging->size, $paging->first);

// įtraukiame šabloną
include "templates/{$module}/{$module}_list.tpl.php";

?>