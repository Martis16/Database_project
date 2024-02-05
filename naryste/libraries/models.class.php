<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */

class models {
	
	private $markes_lentele = '';
	private $modeliai_lentele = '';
	private $automobiliai_lentele = '';
	private $naryste_lentele = '';
	
	public function __construct() {
		$this->markes_lentele = config::DB_PREFIX . 'markes';
		$this->modeliai_lentele = config::DB_PREFIX . 'modeliai';
		$this->automobiliai_lentele = config::DB_PREFIX . 'automobiliai';
		$this->naryste_lentele =  'naryste';
	}
	
	/**
	 * Modelio išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT *
				FROM `{$this->modeliai_lentele}`
				WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Modelių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getModelList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}

		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "SELECT `{$this->modeliai_lentele}`.`id`,
					  `{$this->modeliai_lentele}`.`pavadinimas`,
					  `{$this->markes_lentele}`.`pavadinimas` AS `marke`
				FROM `{$this->modeliai_lentele}`
					LEFT JOIN `{$this->markes_lentele}`
						ON `{$this->modeliai_lentele}`.`fk_marke`=`{$this->markes_lentele}`.`id`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}



		/**
	 * Modelių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getNarysteList($limit = null, $offset = null) {
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
				FROM `{$this->naryste_lentele}`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}





	/**
	 * Modelių kiekio radimas
	 * @return type
	 */
	public function getModelListCount() {
		$query = "SELECT COUNT(`{$this->modeliai_lentele}`.`id`) as `kiekis`
					FROM `{$this->modeliai_lentele}`
						LEFT JOIN `{$this->markes_lentele}`
							ON `{$this->modeliai_lentele}`.`fk_marke`=`{$this->markes_lentele}`.`id`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Modelių išrinkimas pagal markę
	 * @param type $brandId
	 * @return type
	 */
	public function getModelListByBrand($brandId) {
		$brandId = mysql::escapeFieldForSQL($brandId);

		$query = "SELECT *
				FROM `{$this->modeliai_lentele}`
				WHERE `fk_marke`='{$brandId}'";
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Modelio atnaujinimas
	 * @param type $data
	 */
	public function updateModel($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		
		$query = "UPDATE `{$this->modeliai_lentele}`
				SET `pavadinimas`='{$data['pavadinimas']}',
				    `fk_marke`='{$data['fk_marke']}'
				WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Modelio įrašymas
	 * @param type $data
	 */
	public function insertModel($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `{$this->modeliai_lentele}`
						  (`pavadinimas`,
						   `fk_marke`)
				VALUES      ('{$data['pavadinimas']}',
						   '{$data['fk_marke']}')";
		mysql::query($query);
	}
	
	/**
	 * Modelio šalinimas
	 * @param type $id
	 */
	public function deleteModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE FROM `{$this->modeliai_lentele}`
				WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Nurodyto modelio automobilių kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getCarCountOfModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT COUNT(`{$this->automobiliai_lentele}`.`id`) AS `kiekis`
				FROM `{$this->modeliai_lentele}`
					INNER JOIN `{$this->automobiliai_lentele}`
						ON `{$this->modeliai_lentele}`.`id`=`{$this->automobiliai_lentele}`.`fk_modelis`
				WHERE `{$this->modeliai_lentele}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	
}