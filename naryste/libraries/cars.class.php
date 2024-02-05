<?php
/**
 * Automobilių redagavimo klasė
 *
 * @author ISK
 */

class cars {

	private $markes_lentele = '';
	private $modeliai_lentele = '';
	private $automobiliai_lentele = '';
	private $auto_busenos_lentele = '';
	private $sutartys_lentele = '';
	private $degalu_tipai_lentele = '';
	private $kebulu_tipai_lentele = '';
	private $pavaru_dezes_lentele = '';
	private $lagaminai_lentele = '';
	private $saskaita_lentele = '';
	
	public function __construct() {
		$this->markes_lentele = config::DB_PREFIX . 'markes';
		$this->modeliai_lentele = config::DB_PREFIX . 'modeliai';
		$this->automobiliai_lentele = config::DB_PREFIX . 'automobiliai';
		$this->auto_busenos_lentele = config::DB_PREFIX . 'auto_busenos';
		$this->sutartys_lentele = config::DB_PREFIX . 'sutartys';
		$this->degalu_tipai_lentele = config::DB_PREFIX . 'degalu_tipai';
		$this->kebulu_tipai_lentele = config::DB_PREFIX . 'kebulu_tipai';		
		$this->pavaru_dezes_lentele = config::DB_PREFIX . 'pavaru_dezes';
		$this->lagaminai_lentele = config::DB_PREFIX . 'lagaminai';
		$this->saskaita_lentele = 'saskaita';
	}
	
	/**
	 * Automobilio išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT `{$this->automobiliai_lentele}`.`id`,
					  `{$this->automobiliai_lentele}`.`valstybinis_nr`,
					  `{$this->automobiliai_lentele}`.`pagaminimo_data`,
					  `{$this->automobiliai_lentele}`.`rida`,
					  `{$this->automobiliai_lentele}`.`radijas`,
					  `{$this->automobiliai_lentele}`.`grotuvas`,
					  `{$this->automobiliai_lentele}`.`kondicionierius`,
					  `{$this->automobiliai_lentele}`.`vietu_skaicius`,
					  `{$this->automobiliai_lentele}`.`registravimo_data`,
					  `{$this->automobiliai_lentele}`.`verte`,
					  `{$this->automobiliai_lentele}`.`pavaru_deze`,
					  `{$this->automobiliai_lentele}`.`degalu_tipas`,
					  `{$this->automobiliai_lentele}`.`kebulas`,
					  `{$this->automobiliai_lentele}`.`bagazo_dydis`,
					  `{$this->automobiliai_lentele}`.`busena`,
					  `{$this->automobiliai_lentele}`.`fk_modelis` AS `modelis`
				FROM `{$this->automobiliai_lentele}`
				WHERE `{$this->automobiliai_lentele}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Automobilio atnaujinimas
	 * @param type $data
	 */
	public function updateCar($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `{$this->automobiliai_lentele}`
				SET `valstybinis_nr`='{$data['valstybinis_nr']}',
				    `pagaminimo_data`='{$data['pagaminimo_data']}',
				    `rida`='{$data['rida']}',
				    `radijas`='{$data['radijas']}',
				    `grotuvas`='{$data['grotuvas']}',
				    `kondicionierius`='{$data['kondicionierius']}',
				    `vietu_skaicius`='{$data['vietu_skaicius']}',
				    `registravimo_data`='{$data['registravimo_data']}',
				    `verte`='{$data['verte']}',
				    `pavaru_deze`='{$data['pavaru_deze']}',
				    `degalu_tipas`='{$data['degalu_tipas']}',
				    `kebulas`='{$data['kebulas']}',
				    `bagazo_dydis`='{$data['bagazo_dydis']}',
				    `busena`='{$data['busena']}',
				    `fk_modelis`='{$data['modelis']}'
				WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	/**
	 * Automobilio įrašymas
	 * @param type $data
	 */
	public function insertCar($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `{$this->automobiliai_lentele}` 
						  (`valstybinis_nr`,
						   `pagaminimo_data`,
						   `rida`,
						   `radijas`,
						   `grotuvas`,
						   `kondicionierius`,
						   `vietu_skaicius`,
						   `registravimo_data`,
						   `verte`,
						   `pavaru_deze`,
						   `degalu_tipas`,
						   `kebulas`,
						   `bagazo_dydis`,
						   `busena`,
						   `fk_modelis`) 
				VALUES	  ('{$data['valstybinis_nr']}',
						   '{$data['pagaminimo_data']}',
						   '{$data['rida']}',
						   '{$data['radijas']}',
						   '{$data['grotuvas']}',
						   '{$data['kondicionierius']}',
						   '{$data['vietu_skaicius']}',
						   '{$data['registravimo_data']}',
						   '{$data['verte']}',
						   '{$data['pavaru_deze']}',
						   '{$data['degalu_tipas']}',
						   '{$data['kebulas']}',
						   '{$data['bagazo_dydis']}',
						   '{$data['busena']}',
						   '{$data['modelis']}')";
		mysql::query($query);
	}
	
	/**
	 * Automobilių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCarList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}
		
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "SELECT `{$this->automobiliai_lentele}`.`id`,
					  `{$this->automobiliai_lentele}`.`valstybinis_nr`,
					  `{$this->auto_busenos_lentele}`.`name` AS `busena`,
					  `{$this->modeliai_lentele}`.`pavadinimas` AS `modelis`,
					  `{$this->markes_lentele}`.`pavadinimas` AS `marke`
				FROM `{$this->automobiliai_lentele}`
					LEFT JOIN `{$this->modeliai_lentele}`
						ON `{$this->automobiliai_lentele}`.`fk_modelis`=`{$this->modeliai_lentele}`.`id`
					LEFT JOIN `{$this->markes_lentele}`
						ON `{$this->modeliai_lentele}`.`fk_marke`=`{$this->markes_lentele}`.`id`
					LEFT JOIN `{$this->auto_busenos_lentele}`
						ON `{$this->automobiliai_lentele}`.`busena`=`{$this->auto_busenos_lentele}`.`id`" .
				$limitOffsetString;
		$data = mysql::select($query);
		
		//
		return $data;
	}



	public function getSaskaitaList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}
		
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "SELECT *
				FROM `{$this->saskaita_lentele}`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}





	/**
	 * Automobilių kiekio radimas
	 * @return type
	 */
	public function getCarListCount() {
		$query = "SELECT COUNT(`{$this->automobiliai_lentele}`.`id`) AS `kiekis`
				FROM `{$this->automobiliai_lentele}`
					LEFT JOIN `{$this->modeliai_lentele}`
						ON `{$this->automobiliai_lentele}`.`fk_modelis`=`{$this->modeliai_lentele}`.`id`
					LEFT JOIN `{$this->markes_lentele}` 
						ON `{$this->modeliai_lentele}`.`fk_marke`=`{$this->markes_lentele}`.`id`
					LEFT JOIN `{$this->auto_busenos_lentele}`
						ON `{$this->automobiliai_lentele}`.`busena`=`{$this->auto_busenos_lentele}`.`id`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Automobilio šalinimas
	 * @param type $id
	 */
	public function deleteCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE FROM `{$this->automobiliai_lentele}`
				WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Sutačių, į kurias įtrauktas automobilis, kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
				FROM `{$this->automobiliai_lentele}`
					INNER JOIN `{$this->sutartys_lentele}`
						ON `{$this->automobiliai_lentele}`.`id`=`{$this->sutartys_lentele}`.`fk_automobilis`
				WHERE `{$this->automobiliai_lentele}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Pavarų dėžių sąrašo išrinkimas
	 * @return type
	 */
	public function getGearboxList() {
		$query = "SELECT *
				FROM `{$this->pavaru_dezes_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Degalų tipo sąrašo išrinkimas
	 * @return type
	 */
	public function getFuelTypeList() {
		$query = "SELECT *
				FROM `{$this->degalu_tipai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Kėbulo tipų sąrašo išrinkimas
	 * @return type
	 */
	public function getBodyTypeList() {
		$query = "SELECT *
				FROM `{$this->kebulu_tipai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Bagažo tipų sąrašo išrinkimas
	 * @return type
	 */
	public function getLugageTypeList() {
		$query = "SELECT *
				FROM `{$this->lagaminai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Automobilio būsenų sąrašo išrinkimas
	 * @return type
	 */
	public function getCarStateList() {
		$query = "SELECT *
				FROM `{$this->auto_busenos_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
}