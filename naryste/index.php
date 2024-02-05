<?php
	
	// pradedame sesiją
	session_start();
	
	// nuskaitome konfigūracijų failą
	include 'config.php';

	// iškviečiame bendrųjų funkcijų klasę
	include 'utils/common.class.php';
	
	// iškviečiame prisijungimo prie duomenų bazės klasę
	include 'utils/mysql.class.php';
	
	// iškviečiame validatoriaus klasę
	include 'utils/validator.class.php';

	// iškviečiame puslapiavimo klasę
	include 'utils/paging.class.php';

	// iškviečiame visų modulių užklausų klases
	include 'libraries/brands.class.php';
	include 'libraries/cars.class.php';
	include 'libraries/sutartis.class.php';
	include 'libraries/customers.class.php';
	include 'libraries/employees.class.php';
	include 'libraries/models.class.php';
	include 'libraries/services.class.php';

	// nustatome pasirinktą modulį
	$module = '';
	if(isset($_GET['module'])) {
		$module = mysql::escapeFieldForSQL($_GET['module']);
	}
	
	// jeigu pasirinktas elementas (sutartis, automobilis ir kt.), nustatome elemento id
	$id = '';
	if(isset($_GET['id'])) {
		$id = mysql::escapeFieldForSQL($_GET['id']);
	}
	
	// nustatome, kokia funkcija kviečiama
	$action = '';
	if(isset($_GET['action'])) {
		$action = mysql::escapeFieldForSQL($_GET['action']);
	}
		
	// nustatome elementų sąrašo puslapio numerį
	$pageId = 1;
	if(!empty($_GET['page'])) {
		$pageId = mysql::escapeFieldForSQL($_GET['page']);
	}
	
	// nustatome, kurį valdiklį įtraukti šablone main.tpl.php
    $actionFile = "";
	if(!empty($module) && !empty($action)) {
		$actionFile = "controls/{$module}/{$module}_{$action}.php";
	} else {
		// rodome, jeigu nenurodyti parametrai
		$actionFile = "controls/home_page.php";
	}
	
	// įtraukiame pagrindinį šabloną
	include 'templates/main.tpl.php';
	
	// spausdiname vykdytas užklausas į konsolę
	if(array_key_exists('queries', $_SESSION)) {
		common::logToConsole($_SESSION['queries']);
	}
	
	// išvalome vykdytų užklausų masyvą
	$_SESSION['queries'] = array();
?>