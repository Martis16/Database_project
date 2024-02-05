<?php
/**
 * Klientų redagavimo klasė
 *
 * @author ISK
 */

class customers {
	
	private $klientai_lentele = '';
	private $sutartys_lentele = '';
	
	public function __construct() {
		$this->klientai_lentele = 'asmuo';
		$this->sutartys_lentele = 'sutartis';
	}
	
	/**
	 * Kliento išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT *
				FROM `{$this->klientai_lentele}`
				WHERE `Asmens_id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Klientų sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCustomersList($limit = null, $offset = null) {
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
				FROM `{$this->klientai_lentele}`
				{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Klientų kiekio radimas
	 * @return type
	 */
	public function getCustomersListCount() {
		$query = "SELECT COUNT(`Asmens_id`) as `kiekis`
				FROM `{$this->klientai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Kliento šalinimas
	 * @param type $id
	 */
	public function deleteCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "DELETE FROM `{$this->klientai_lentele}`
				WHERE `Asmens_id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Kliento atnaujinimas
	 * @param type $data
	 */
	public function updateCustomer($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `{$this->klientai_lentele}`
				SET `vardas`='{$data['vardas']}',
					`pavarde`='{$data['pavarde']}',
					`gimimo_data`='{$data['gimimo_data']}',
					`telefonas`='{$data['telefonas']}',
					`epastas`='{$data['epastas']}'
				WHERE `Asmens_id`='{$data['Asmens_id']}'";
		mysql::query($query);
	}
	
	/**
	 * Kliento įrašymas
	 * @param type $data
	 */
	public function insertCustomer($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "INSERT INTO `{$this->klientai_lentele}`
						  (`Asmens_id`,
						   `vardas`,
						   `pavarde`,
						   `gimimo_data`,
						   `telefonas`,
						   `epastas`) 
				VALUES      ('{$data['Asmens_id']}',
						   '{$data['vardas']}',
						   '{$data['pavarde']}',
						   '{$data['gimimo_data']}',
						   '{$data['telefonas']}',
						   '{$data['epastas']}')";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas klientas, kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->klientai_lentele}`
						INNER JOIN `{$this->sutartys_lentele}`
							ON `{$this->klientai_lentele}`.`Asmens_id`=`{$this->sutartys_lentele}`.`fk_klientas`
				WHERE `{$this->klientai_lentele}`.`Asmens_id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
}