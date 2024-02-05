<?php
/**
 * Darbuotojų redagavimo klasė
 *
 * @author ISK
 */

class employees {
	
	private $darbuotojai_lentele = '';
	private $sutartys_lentele = '';
	
	public function __construct() {
		$this->darbuotojai_lentele = config::DB_PREFIX . 'darbuotojai';
		$this->sutartys_lentele = config::DB_PREFIX . 'sutartys';
	}
	
	/**
	 * Darbuotojo išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getEmployee($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT *
				FROM `{$this->darbuotojai_lentele}`
				WHERE `tabelio_nr`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Darbuotojų sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getEmplyeesList($limit = null, $offset = null) {
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
				FROM `{$this->darbuotojai_lentele}`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Darbuotojų kiekio radimas
	 * @return type
	 */
	public function getEmplyeesListCount() {
		$query = "SELECT COUNT(`tabelio_nr`) as `kiekis`
				FROM `{$this->darbuotojai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Darbuotojo šalinimas
	 * @param type $id
	 */
	public function deleteEmployee($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE
				FROM `{$this->darbuotojai_lentele}`
				WHERE `tabelio_nr`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo atnaujinimas
	 * @param type $data
	 */
	public function updateEmployee($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `{$this->darbuotojai_lentele}`
				SET `vardas`='{$data['vardas']}',
				    `pavarde`='{$data['pavarde']}'
				WHERE `tabelio_nr`='{$data['tabelio_nr']}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo įrašymas
	 * @param type $data
	 */
	public function insertEmployee($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `{$this->darbuotojai_lentele}`
						  (`tabelio_nr`,
						   `vardas`,
						   `pavarde`) 
				VALUES      ('{$data['tabelio_nr']}',
						   '{$data['vardas']}',
						   '{$data['pavarde']}')";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas darbuotojas, kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfEmployee($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->darbuotojai_lentele}`
						INNER JOIN `{$this->sutartys_lentele}`
							ON `{$this->darbuotojai_lentele}`.`tabelio_nr`=`{$this->sutartys_lentele}`.`fk_darbuotojas`
				WHERE `{$this->darbuotojai_lentele}`.`tabelio_nr`='{$id}'";
		$data = mysql::select($query);
	
		//
		return $data[0]['kiekis'];
	}
	
}