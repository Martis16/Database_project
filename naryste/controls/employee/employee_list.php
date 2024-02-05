<?php

// sukuriame užklausų klasės objektą
$employeesObj = new employees();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $employeesObj->getEmplyeesListCount();

// sukuriame puslapiavimo klasės objektą
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $employeesObj->getEmplyeesList($paging->size, $paging->first);

// įtraukiame šabloną
include "templates/{$module}/{$module}_list.tpl.php";

?>