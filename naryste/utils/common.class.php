<?php

/**
 * Bendrųjų pagalbinių funkcijų klasė.
 *
 * @author ISK
 */

class common {

	/**
	* @desc Nukreipimo funkcija, naudojant Javascript
	* @param url adresas, į kurį nukreipiama
	*/
	public static function redirect($url) {
		echo "<script type='text/javascript'>document.location.href='" . $url . "';</script>";
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';
	}
	
	/**
	* @desc Žinučių išvedimo į konsolę funkciją naudojant Javascript
	* @param output spausdinamų reikšmių masyvas
	*/
	public static function logToConsole($output) {
		$js_code = '';
		if($output) {
			foreach($output as $val) {
				$js_code .= 'console.log("' . $val . '");';
			}

			$js_code = '<script>' . $js_code . '</script>';
		}
		
		echo $js_code;
	}
}

?>