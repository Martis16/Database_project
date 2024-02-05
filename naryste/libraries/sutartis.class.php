<?php
/**
 * Sutarčių redagavimo klasė
 *
 * @author ISK
 */

class sutartis {

	private $sutartys_lentele = '';
	private $darbuotojai_lentele = '';
	private $klientai_lentele = '';
	private $sutarties_busenos_lentele = '';
	private $uzsakyta_paslauga_lentele = '';
	private $aiksteles_lentele = '';
	private $paslaugos_lentele = '';
	private $naryste_lentele = '';

	public function __construct() {
		$this->sutartys_lentele = 'sutartis';
		//$this->darbuotojai_lentele = 'darbuotojai';
		$this->klientai_lentele = 'asmuo';
		//$this->sutarties_busenos_lentele = 'sutarties_busenos';
		$this->uzsakyta_paslauga_lentele = 'uzsakyta_paslauga';
		//$this->aiksteles_lentele = 'aiksteles';
		//$this->paslaugu_kainos_lentele = 'paslaugu_kainos';
		$this->paslaugos_lentele = 'papildoma_paslauga';
		$this->naryste_lentele = 'naryste';
	}
	
	/**
	 * Sutarčių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getContractList($limit, $offset) {
		$limit = mysql::escapeFieldForSQL($limit);
		$offset = mysql::escapeFieldForSQL($offset);

		$query = "SELECT `{$this->sutartys_lentele}`.`Nr`,
					  `{$this->sutartys_lentele}`.`Pasirasymo_data`,
					  `{$this->sutartys_lentele}`.`busena` AS `busena`,
					  `{$this->klientai_lentele}`.`Vardas` AS `kliento_vardas`,
					  `{$this->klientai_lentele}`.`Pavarde` AS `kliento_pavarde`
				FROM `{$this->sutartys_lentele}`
					LEFT JOIN `{$this->klientai_lentele}`
						ON `{$this->sutartys_lentele}`.`fk_Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`
				LIMIT {$limit} OFFSET {$offset}";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Sutarčių kiekio radimas
	 * @return type
	 */
	public function getContractListCount() {
		$query = "SELECT COUNT(`{$this->sutartys_lentele}`.`Nr`) AS `kiekis`
					FROM `{$this->sutartys_lentele}`
						LEFT JOIN `{$this->klientai_lentele}`
							ON `{$this->sutartys_lentele}`.`fk_Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Sutarties išrinkimas
	 * @param type $nr
	 * @return type
	 */
	public function getContract($nr) {
		$nr = mysql::escapeFieldForSQL($nr);

		$query = "SELECT `{$this->sutartys_lentele}`.`Nr`,
					  `{$this->sutartys_lentele}`.`Pasirasymo_data`,
					  `{$this->sutartys_lentele}`.`Baigia_galioti`,
					  `{$this->sutartys_lentele}`.`busena`,
					  `{$this->sutartys_lentele}`.`fk_Saskaitaid_Saskaita`,
					  `{$this->sutartys_lentele}`.`fk_Asmens_id`,
					  `{$this->sutartys_lentele}`.`fk_Narysteid_Naryste`,
					  (IFNULL(SUM(`{$this->uzsakyta_paslauga_lentele}`.`Sumine_kaina` * `{$this->uzsakyta_paslauga_lentele}`.`kiekis`), 0)) AS `bendra_kaina`
				FROM `{$this->sutartys_lentele}`
					LEFT JOIN `{$this->uzsakyta_paslauga_lentele}`
						ON `{$this->sutartys_lentele}`.`Nr`=`{$this->uzsakyta_paslauga_lentele}`.`fk_sutartisNr`
				WHERE `{$this->sutartys_lentele}`.`Nr`='{$nr}'
				GROUP BY `{$this->sutartys_lentele}`.`Nr`";
		$data = mysql::select($query);

		//
		return $data[0];
	}
	
	/**
	 * Patikrinama, ar sutartis su nurodytu numeriu egzistuoja
	 * @param type $nr
	 * @return type
	 */
	public function checkIfContractNrExists($nr) {
		$nr = mysql::escapeFieldForSQL($nr);

		$query = "SELECT COUNT(`{$this->sutartys_lentele}`.`Nr`) AS `kiekis`
				FROM `{$this->sutartys_lentele}`
				WHERE `{$this->sutartys_lentele}`.`Nr`='{$nr}'";
		$data = mysql::select($query);

		//
		return $data[0]['kiekis'];
	}

	/**
	 * Užsakytų papildomų paslaugų sąrašo išrinkimas
	 * @param type $contractId
	 * @return type
	 */
	public function getOrderedServices($contractId) {
		$contractId = mysql::escapeFieldForSQL($contractId);

		$query = "SELECT `{$this->uzsakyta_paslauga_lentele}`.`kiekis`,
						`{$this->uzsakyta_paslauga_lentele}`.`Sumine_kaina`,
						`{$this->uzsakyta_paslauga_lentele}`.`fk_Papildoma_Paslaugaid_Papildoma_Paslauga`,
						`{$this->uzsakyta_paslauga_lentele}`.`fk_sutartisNr`,					  					  
					  	`{$this->paslaugos_lentele}`.`Tipas`
				FROM `{$this->uzsakyta_paslauga_lentele}`
					LEFT JOIN `{$this->paslaugos_lentele}`
						ON `{$this->uzsakyta_paslauga_lentele}`.`fk_Papildoma_Paslaugaid_Papildoma_Paslauga`=`{$this->paslaugos_lentele}`.`id_Papildoma_Paslauga`
				WHERE `fk_sutartisNr`='{$contractId}'";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Užsakytų papildomų paslaugų sąrašo išrinkimas
	 * @param type $orderId
	 * @return type
	 */
	public function checkIfOrderedServiceExists($contractId, $serviceId, $priceFrom) {
		$query = "SELECT COUNT(`{$this->uzsakyta_paslauga_lentele}`.`fk_sutartisNr`) AS `kiekis`
				FROM `{$this->uzsakyta_paslauga_lentele}`
				WHERE `fk_sutartisNr`='{$contractId}' AND `fk_Papildoma_Paslaugaid_Papildoma_Paslauga`='{$serviceId}'";
		$data = mysql::select($query);
	
		//
		return $data[0]['kiekis'];
	}


	/**
	 * Sutarties atnaujinimas
	 * @param type $data
	 */
	public function updateContract($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `{$this->sutartys_lentele}`
				SET `Pasirasymo_data`='{$data['Pasirasymo_data']}',
					`Baigia_galioti`='{$data['Baigia_galioti']}',
					`busena`='{$data['busena']}',
					`fk_Saskaitaid_Saskaita`='{$data['fk_Saskaitaid_Saskaita']}',
					`fk_Asmens_id`='{$data['fk_Asmens_id']}',
					`fk_Narysteid_Naryste`='{$data['fk_Narysteid_Naryste']}'
				WHERE `Nr`='{$data['Nr']}'";
		mysql::query($query);
	}
	
	/**
	 * Sutarties įrašymas
	 * @param type $data
	 */
	public function insertContract($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `{$this->sutartys_lentele}`
						  (`Nr`,
							`Pasirasymo_data`,
							`Baigia_galioti`,
							`busena`,
							`fk_Saskaitaid_Saskaita`,
							`fk_Asmens_id`,
							`fk_Narysteid_Naryste`)
				VALUES      ('{$data['Nr']}',
						   '{$data['Pasirasymo_data']}',
						   '{$data['Baigia_galioti']}',
						   '{$data['busena']}',
						   '{$data['fk_Saskaitaid_Saskaita']}',
						   '{$data['fk_Asmens_id']}',
						   '{$data['fk_Narysteid_Naryste']}')";
		mysql::query($query);
	}
	
	/**
	 * Sutarties šalinimas
	 * @param type $id
	 */
	public function deleteContract($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE FROM `{$this->sutartys_lentele}`
				WHERE `Nr`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Visų sutarties užsakytų papildomų paslaugų šalinimas
	 * @param type $contractId
	 */
	public function deleteOrderedServices($contractId) {
		$contractId = mysql::escapeFieldForSQL($contractId);

		$query = "DELETE FROM `{$this->uzsakyta_paslauga_lentele}`
				WHERE `fk_SutartisNr`='{$contractId}'";
		mysql::query($query);
	}
	
	/**
	 * Sutarties užsakytos papildomos paslaugos šalinimas
	 * @param type $contractId
	 */
	public function deleteOrderedService($contractId, $serviceId) {
		$contractId = mysql::escapeFieldForSQL($contractId);
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		//$priceFrom = mysql::escapeFieldForSQL($priceFrom);
		//$price = mysql::escapeFieldForSQL($price);

		$query = "DELETE FROM `{$this->uzsakyta_paslauga_lentele}`
				WHERE `fk_sutartisNr`='{$contractId}' AND `fk_Papildoma_Paslaugaid_Papildoma_Paslauga`='{$serviceId}'";
		mysql::query($query);
	}

	/**
	 * Užsakytos papildomos paslaugos atnaujinimas
	 * @param type $data
	 */
	public function updateOrderedService($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `{$this->uzsakyta_paslauga_lentele}`
				SET `Sumine_kaina`='{$data['Sumine_kaina']}',
				    `kiekis`='{$data['kiekis']}'
				WHERE `fk_sutartisNr`='{$data['fk_sutartisNr']}'AND `fk_Papildoma_Paslaugaid_Papildoma_Paslauga`='{$data['fk_Papildoma_Paslaugaid_Papildoma_Paslauga']}'";
		mysql::query($query);
	}
	
	/**
	 * Užsakytos papildomos paslaugos įrašymas
	 * @param type $data
	 */
	public function insertOrderedService($contractId, $serviceId, $price, $amount) {
		$contractId = mysql::escapeFieldForSQL($contractId);
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		//$priceFrom = mysql::escapeFieldForSQL($priceFrom);
		$price = mysql::escapeFieldForSQL($price);
		$amount = mysql::escapeFieldForSQL($amount);

		$query = "INSERT INTO `{$this->uzsakyta_paslauga_lentele}`
						  (`kiekis`,
						   `Sumine_kaina`,
						   `fk_Papildoma_Paslaugaid_Papildoma_Paslauga`,
						   `fk_SutartisNr`)
				VALUES	  ('{$amount}',
							'{$price}',
							'{$serviceId}',
							'{$contractId}'
						   )";
		mysql::query($query);
	}


	

	/**
	 * Paslaugos kainų įtraukimo į užsakymus kiekio radimas
	 * @param type $serviceId
	 * @param type $validFrom
	 * @return type
	 */
	public function getPricesCountOfOrderedServices($serviceId, $validFrom) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		$validFrom = mysql::escapeFieldForSQL($validFrom);
		
		$query = "SELECT COUNT(`{$this->uzsakyta_paslauga_lentele}`.`fk_Papildoma_Paslaugaid_Papildoma_Paslauga`) AS `kiekis`
				FROM `{$this->paslaugos_lentele}`
					INNER JOIN `{$this->uzsakyta_paslauga_lentele}`
						ON `{$this->paslaugos_lentele}`.`id_Papildoma_Paslauga`=`{$this->uzsakyta_paslauga_lentele}`.`fk_Papildoma_Paslaugaid_Papildoma_Paslauga`
				WHERE `{$this->paslaugos_lentele}`.`id_Papildoma_Paslauga`='{$serviceId}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}


	/**
	 * Klientų sutarčių sąrašo išrinkimas. Suskaičiuojamos kiekvieno kliento sutarčių ir užsakytų papildomų paslaugų sumos
	 * @param $dateFrom laikotarpio pradžios data
	 * @param $dateTo laikotarpio pabaigos data
	 * @return klientų sutarčių įrašai
	 */
	public function getCustomerContracts($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`Pasirasymo_data`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`Pasirasymo_data`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`Pasirasymo_data`<='{$dateTo}'";
			}
		}

		
		$query = "SELECT `{$this->sutartys_lentele}`.`Nr`,
					  `{$this->sutartys_lentele}`.`Pasirasymo_data`,
					  `{$this->klientai_lentele}`.`Asmens_id`,
					  `{$this->klientai_lentele}`.`Vardas`,
					  `{$this->klientai_lentele}`.`Pavarde`,
					  `{$this->naryste_lentele}`.`Kaina` as `sutarties_kaina`,
					  IFNULL(SUM(`{$this->uzsakyta_paslauga_lentele}`.`kiekis` * `{$this->uzsakyta_paslauga_lentele}`.`Sumine_kaina`), 0) as `sutarties_paslaugu_kaina`,
					  `t`.`bendra_kliento_sutarciu_kaina`,
					  `s`.`bendra_kliento_paslaugu_kaina`
				FROM `{$this->sutartys_lentele}`
					INNER JOIN `{$this->klientai_lentele}`
						ON `{$this->sutartys_lentele}`.`fk_Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`
					INNER JOIN `{$this->naryste_lentele}`
						ON `{$this->sutartys_lentele}`.`fk_Narysteid_Naryste`=`{$this->naryste_lentele}`.`id_Naryste`
					LEFT JOIN `{$this->uzsakyta_paslauga_lentele}`
						ON `{$this->sutartys_lentele}`.`Nr`=`{$this->uzsakyta_paslauga_lentele}`.`fk_sutartisNr`
					INNER JOIN (
						SELECT `Asmens_id`,
							  SUM(`{$this->naryste_lentele}`.`Kaina`) AS `bendra_kliento_sutarciu_kaina`
						FROM `{$this->sutartys_lentele}`
							INNER JOIN `{$this->naryste_lentele}`
								ON `{$this->sutartys_lentele}`.`fk_Narysteid_Naryste`=`{$this->naryste_lentele}`.`id_Naryste`
							INNER JOIN `{$this->klientai_lentele}`
								ON `{$this->sutartys_lentele}`.`fk_Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`
						{$whereClauseString}
						GROUP BY `Asmens_id`
					) `t` ON `t`.`Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`
					INNER JOIN (
						SELECT `Asmens_id`,
							IFNULL(SUM(`{$this->uzsakyta_paslauga_lentele}`.`kiekis` * `{$this->uzsakyta_paslauga_lentele}`.`Sumine_kaina`), 0) as `bendra_kliento_paslaugu_kaina`
						FROM `{$this->sutartys_lentele}`
							INNER JOIN `{$this->klientai_lentele}`
								ON `{$this->sutartys_lentele}`.`fk_Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`
							LEFT JOIN `{$this->uzsakyta_paslauga_lentele}`
								ON `{$this->sutartys_lentele}`.`Nr`=`{$this->uzsakyta_paslauga_lentele}`.`fk_sutartisNr`
						{$whereClauseString}							
						GROUP BY `Asmens_id`
					) `s` ON `s`.`Asmens_id`=`{$this->klientai_lentele}`.`Asmens_id`
				{$whereClauseString}
				GROUP BY `{$this->sutartys_lentele}`.`Nr`
				ORDER BY `{$this->klientai_lentele}`.`Pavarde` ASC";
				

		echo $query;
		$data = mysql::select($query);

		
		return $data;
	}

		/**
	 * Sutarčių sumos išrinkimas
	 * @param $dateFrom laikotarpio pradžios data
	 * @param $dateTo laikotarpio pabaigos data
	 * @return įrašas su sutarčių suma
	 */
	public function getSumPriceOfContracts($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`Pasirasymo_data`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`Pasirasymo_data`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`Pasirasymo_data`<='{$dateTo}'";
			}
		}
		
		$query = "SELECT SUM(`{$this->naryste_lentele}`.`Kaina`) AS `nuomos_suma`
				FROM `{$this->naryste_lentele}`
				{$whereClauseString}";
		$data = mysql::select($query);

		//
		return $data;
	}
	



		/**
	 * Užsakytų paslaugų kiekio ir sumos išrinkimas
	 * @param $dateFrom laikotarpio pradžios data
	 * @param $dateTo laikotarpio pabaigos data
	 * @return įrašas su užsakytų paslaugų kiekiu ir suma
	 */
	public function getSumPriceOfOrderedServices($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`Pasirasymo_data`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`Pasirasymo_data`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`Pasirasymo_data`<='{$dateTo}'";
			}
		}
		
		$query = "SELECT SUM(`{$this->uzsakyta_paslauga_lentele}`.`kiekis` * `{$this->uzsakyta_paslauga_lentele}`.`Sumine_kaina`) AS `paslaugu_suma`
					FROM `{$this->sutartys_lentele}`
						INNER JOIN `{$this->uzsakyta_paslauga_lentele}`
							ON `{$this->sutartys_lentele}`.`Nr`=`{$this->uzsakyta_paslauga_lentele}`.`fk_sutartisNr`
				{$whereClauseString}";
		$data = mysql::select($query);

		//
		return $data;
	}

	
}