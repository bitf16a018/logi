<?
/**
 * class to abstract mysql into LC framework
 *
 * This class wraps the mysql php function calls in
 * a layer that is used directly with the LC modules and
 * system infrastructure.  This class can easily be
 * duplicated or subclassed to work with other DBs.
 *
 * This class supports multiple result sets, wherein
 * DB queries and result sets may be stacked on top
 * of each other.
 * <i>Example:</i>
 * 	$db->query("select * from lcUsers");
 *	while ($db->nextRecord() ) {
 *		$db->query("select * from payments where username = '".$db->record['username']."'");
 *		while ($db->nextRecord() ) {
 *			print_r($db->record);
 *		}
 *	}
 *
 * @abstract
 */



// do some static setting up of the DB

$dsn['default'] = array(
        'driver'=>'lcMysql',
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'mysql',
        'database'=>'oneu_manager',
        'persistent'=>'y');



lcDB::getDSN($dsn);
$gdb = lcDB::getHandle();

class db extends lcDB { }

class lcDB {

	var $driverID;  		// Result of mysql_connect()
	var $resultSet;		 	// Result of most recent mysql_query()
	var $record = array(); 		// current mysql_fetch_array()-result
	var $row;  			// current row number.
	var $RESULT_TYPE;
	var $errorNumber; 		// Error number when there's an error
	var $errorMessage = ""; 		// Error message when there's an error


	function lcDB() {
	}


	/**
	 * Get a copy of the global instance
	 *
	 * The copy returned will use the same database connection
	 * as the global object.
	 * @return 	object 	copy of a db object that has the settings of a DSN entry
	 */
	function getHandle($dsn='default') {
		static $handles = array();

		//get the list of connection setups
		$_dsn = lcDB::getDSN();

		// if a connection has already been made and in the handles array
		// get it out
                if (is_object($handles[$dsn]) ) {
			$x = $handles[$dsn];
			$x->connect();
                } else {
			//make sure the driver is loaded
			$driver = $_dsn[$dsn]['driver'];
			// and make a new one
                        $x = new $driver();
			$x->host = $_dsn[$dsn]['host'];
			$x->database = $_dsn[$dsn]['database'];
			$x->user = $_dsn[$dsn]['user'];
			$x->password = $_dsn[$dsn]['password'];
			$x->persistent = $_dsn[$dsn]['persistent'];
                	$x->connect();
                        $handles[$dsn] = $x;
		}

		//return by value (copy) to make sure
		// nothing has access to old query results
		// keeps the same connection ID though
		return $x;
	}




	/**
	 * Connect to the DB server
	 *
	 * Uses the classes internal host,user,password, and database variables
	 * @return void
	 */
	function connect() {
		$pointer = lcDB::getHandle();
		$pointer->connect();
	}


	/**
	 * Send query to the DB
	 *
	 * Results are stored in $this->resultSet;
	 * @return 	void
	 * @param 	string	$queryString	SQL command to send
	 */
	function query($queryString) {
		$pointer = lcDB::getHandle();
		$pointer->query($queryString);
	}


	/**
	 * Close connection
	 *
	 * @return void
	 */
	function close() {
		$pointer = lcDB::getHandle();
		$pointer->close();
	}


	/**
	 * Grab the next record from the resultSet
	 *
	 * Returns true while there are more records, false when the set is empty
	 * Automatically frees result when the result set is emtpy
	 * @return boolean
	 * @param  int	$resID	Specific resultSet, default is last query
	 */
	function nextRecord($resID=false) {
		$pointer = lcDB::getHandle();
		return $pointer->nextRecord();
	}



	/**
	 * Return the requested column from the current record of the current result set
	 *
	 * @return	mixed
	 * @param	mixed           $key    Column key into the record set
	 */
	function getRecord($key) {
		$pointer = lcDB::getHandle();
		return $pointer->record[$key];
	}



	/**
	 * Moves resultSet cursor to beginning
	 * @return void
	 */
	function reset() {

	}


	/**
	 * Moves resultSet cursor to an aribtrary position
	 *
	 * @param int $row	Desired index offset
	 * @return void
	 */
	function seek($row) {

	}


	/**
	 * Retrieves last error message from the DB
	 *
	 * @return string Error message
	 */
	function getLastError() {

	}


	/**
	 * Return the last identity field to be created
	 *
	 * @return mixed
	 */
	function getInsertID() {

	}


	/**
	 * Return the number of rows affected by the last query
	 *
	 * @return int	number of affected rows
	 */
	function getNumRows() {

	}


	function disconnect() {

	}



	function &getDSN($d='') {
		static $dsn;
		if (isset($dsn) ) {
			return $dsn;
		} else {
			if ($d) {
				$dsn = $d;
			}
		}
	}


	function singleton($s='') {
		static $singleton;
		if (isset($singleton)) {
			return $singleton;
		}
		else {
			if ($s) {
				$singleton = $s;
			}
		}
	}


	function executeQuery($query) {
		$this->RESULT_TYPE=MYSQL_ASSOC;
		print "*** ". $query->toString(). "\n";
		$this->query($query->toString());
	}

}


/**
 * MySQL specific driver
 */
class lcMysql extends lcDB {


	var $RESULT_TYPE = MYSQL_BOTH;


	/**
	 * Connect to the DB server
	 *
	 * @return void
	 */
	function connect() {


		if ( $this->driverID == 0 ) {
                if ($this->persistent=='y') {
			$this->driverID=mysql_pconnect($this->host, $this->user,$this->password);
                } else {
			$this->driverID=mysql_connect($this->host, $this->user,$this->password);
                }
			if (!$this->driverID) {
				print "driverID is false \n\n<br>\n";
				exit();
				//$this->halt();
			}
		}
		$this->query("use ".$this->database,$this->driverID);
	}


	/**
	 * Send query to the DB
	 *
	 * Results are stored in $this->resultSet;
	 * @return 	void
	 * @param 	string	$queryString	SQL command to send
	 */
	function query($queryString) {
		$this->queryString = $queryString;


		global $debugmode,$REMOTE_ADDR;
		if ($debugmode=="y") {	print microtime()."<br>\n"; printf("Debug: query = %s<br>\n", $queryString)."<br>\n"; print strlen($queryString)."<br>\n"; flush(); }
		if ($this->driverID == 0 ) {$this->connect();}

		$resSet = mysql_query($queryString,$this->driverID);
		$this->row = 0;
		if ( !$resSet ) {
		    $this->errorNumber = mysql_errno();
		    $this->errorMessage = mysql_error();
		}
		if (is_resource($resSet) )
			$this->resultSet[] = $resSet;

		if ($debugmode=="y") {	print "<br>".microtime()."<hr>\n"; }
	}


	/**
	 * Close connection
	 *
	 * @return void
	 */
	function close() {
		mysql_close($this->driverID);
	}


	/**
	 * Grab the next record from the resultSet
	 *
	 * Returns true while there are more records, false when the set is empty
	 * Automatically frees result when the result set is emtpy
	 * @return boolean
	 * @param  int	$resID	Specific resultSet, default is last query
	 */
	function nextRecord($resID=false) {
		if ( ! $resID ) { $resID = count($this->resultSet) -1; }

		$this->record = mysql_fetch_array($this->resultSet[$resID],$this->RESULT_TYPE);
		$this->row += 1;

		//no more records in the result set?
		$ret = is_array($this->record);
		if ( ! $ret ) {
			mysql_free_result($this->resultSet[$resID]);
			array_pop($this->resultSet);
		}
		return $ret;
	}


	/**
	 * Short hand for query() and nextRecord().
	 *
	 * @param string $sql SQL Command
	 */
	function queryOne($sql) {
		$this->query($sql);
		$this->nextRecord();
		array_pop($this->resultSet);
	}



	/**
	 * Moves resultSet cursor to beginning
	 * @return void
	 */
	function reset() {
		mysql_data_seek($this->Query_ID,0);
	}


	/**
	 * Moves resultSet cursor to an aribtrary position
	 *
	 * @param int $row	Desired index offset
	 * @return void
	 */
	function seek($row) {
		mysql_data_seek($this->resultSet,$row);
		$this->row  = $row;
	}



	/**
	 * Retrieves last error message from the DB
	 *
	 * @return string Error message
	 */
	function getLastError() {
	    $this->errorNumber = mysql_errno();
	    $this->errorMessage = mysql_error();
	return $this->errorMessage;
	}


	/**
	 * Return the last identity field to be created
	 *
	 * @return mixed
	 */
	function getInsertID() {
		return mysql_insert_id($this->driverID);
	}


	/**
	 * Return the number of rows affected by the last query
	 *
	 * @return int	number of affected rows
	 */
	function getNumRows() {
		$resID = count($this->resultSet) -1;
		return @mysql_num_rows($this->resultSet[$resID]);
	}



	function disconnect() {
		mysql_close();
	}

	function getTableColumns($table='') {
		if ($this->driverID == 0 ) {$this->connect();}
		$dbfields = mysql_list_fields($this->database,$table,$this->driverID);
		$columns =  mysql_num_fields($dbfields);

		for ($i = 0; $i < $columns; $i++) {
			$name = mysql_field_name($dbfields, $i);
			if ( ($this->RESULT_TYPE == MYSQL_ASSOC)  || ($this->RESULT_TYPE == MYSQL_BOTH) ) {
				$field[name][$name] = $name;
				$field[type][$name] =  mysql_field_type($dbfields, $i);
				$field[len][$name] =  mysql_field_len($dbfields, $i);
				$field[flags][$name] =  mysql_field_flags($dbfields, $i);
			}
			if ( ($this->RESULT_TYPE == MYSQL_NUM)  || ($this->RESULT_TYPE == MYSQL_BOTH) ) {
				$field[name][] =  $name;
				$field[type][] =  mysql_field_type($dbfields, $i);
				$field[len][] =  mysql_field_len($dbfields, $i);
				$field[flags][] =  mysql_field_flags($dbfields, $i);
			}
		}
	return $field;
	}

}
?>
