<?php

/**
 * Database wrapper for a MySQL with PHP tutorial
 * 
 * @copyright Eran Galperin
 * @license MIT License
 * @see http://www.binpress.com/tutorial/using-php-with-mysql-the-right-way/17
 */
class mysql
{
    // The database connection
    protected static $connection;

    /**
     * Connect to the database
     * 
     * @return bool false on failure / mysqli MySQLi object instance on success
     */
    public static function connect()
    {
        // Try and connect to the database
        if (!isset(self::$connection)) {
            self::$connection = new mysqli(config::DB_SERVER, config::DB_USERNAME, config::DB_PASSWORD, config::DB_NAME);
            if (self::$connection !== false) {
                if(self::$connection->connect_error) {
                    die(self::$connection->connect_error);
                }
                
                // try to set mysql connection character set to UTF-8
                if (!mysql::$connection->set_charset("utf8")) {
                    printf("Error loading character set: %s\n", self::$connection->error);
                }

                // set error reporting mode
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            } else {
                // Handle error - notify administrator, log to a file, show an error screen, etc.
                // return false;
                die("Nepvyko prisijungti prie duomenų bazės.");
            }
        }

        //
        return self::$connection;
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public static function query($query)
    {
		// add query to session for later printing}
		array_push($_SESSION['queries'], preg_replace("/\s+/", " ", trim($query)));
		
		// Connect to the database
        mysql::connect();

        try {
            // Query the database
            $result = self::$connection->query($query);

            //
            return $result;
        } catch (Exception $e) {
            // print error message
            die($e->getMessage());
        }
    }

    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public static function select($query)
    {		
		$rows = array();
        $result = mysql::query($query);
        if ($result === false) {
            //
            return $rows;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        //
        return $rows;
    }

    /**
     * Fetch the last error from the database
     * 
     * @return string Database error message
     */
    public static function error()
    {
        mysql::connect();

        //
        return self::$connection::error;
    }

    /**
     * Return id of last inserted row
     * @return last insert id
     */
    public static function getLastInsertedId()
    {
        mysql::connect();
		
        //
        return self::$connection->insert_id;
    }
	
    /**
     * Quote and escape array of variables for use in a database query
     * @param type $fields
     * @return $fields escaped
     */
	public static function escapeFieldsArrayForSQL($fields) {
		mysql::connect();
		
		$data = array();
		foreach($fields as $key=>$val) {
			$tmp = null;
			if(!is_array($val)) {
				$tmp = mysqli_real_escape_string(self::$connection, $val . '');
			} else {
				foreach($val as $key2 => $val2) {
					$tmp[] = mysqli_real_escape_string(self::$connection, $val2 . '');
				}
			}
			
			if($tmp == '' || $tmp == array()) {
				$data[$key] = '';
			} else {
				if(!is_array($tmp)) {
					$data[$key] = $tmp;
				} else {
					$data[$key] = $tmp;
				}
				
			}
		}

        //
		return $data;
	}
	
    /**
     * Quote and escape variable for use in a database query
     * @param type $field
     * @return $field escaped
     */
	public static function escapeFieldForSQL($field) {
		mysql::connect();
		
		//
		return mysqli_real_escape_string(self::$connection, $field . '');
	}
	
}
