<?php

/**
* Provides access to a database.
*/
class Database
{
	/**
	 * sql server hostname
	 * @var	string
	 */
	protected $host = '';
	
	/**
	 * sql server post
	 * @var	integer
	 */
	protected $port = 0;
	
	/**
	 * sql server login name
	 * @var	string
	 */
	protected $user = '';
	
	/**
	 * sql server login password
	 * @var	string
	 */
	protected $password = '';
	
	/**
	 * database name
	 * @var	string
	 */
	protected $database = '';

	/**
	 * number of executed queries
	 * @var	integer
	 */
	protected $queryCount = 0;

	/**
	 * pdo object
	 * @var	\PDO
	 */
	protected $pdo = null;

	/**
	 * Creates a Dabatase Object.
	 * 
	 * @param	string		$host			SQL database server host address
	 * @param	string		$user			SQL database server username
	 * @param	string		$password		SQL database server password
	 * @param	string		$database		SQL database server database name
	 * @param	integer		$port			SQL database server port
	 */
	public function __construct($host, $user, $password, $database, $port) {
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		
		// connect database
		$this->connect();
	}

	/**
	 * Connects to database server.
	 */
	public function connect() {
		if (!$this->port) $this->port = 3306; // mysql default port
		
		try {
			$driverOptions = array(
				\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
			);
			
			// disable prepared statement emulation since MySQL 5.1.17 is the minimum required version
			$driverOptions[\PDO::ATTR_EMULATE_PREPARES] = false;
			
			$this->pdo = new \PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->user, $this->password, $driverOptions);
			$this->setAttributes();
		}
		catch (\PDOException $e) {
			throw new DatabaseException("Connecting to MySQL server '".$this->host."' failed:\n".$e->getMessage(), $this);
		}
	}

	/**
	 * Returns true if this database type is supported.
	 * 
	 * @return	boolean
	 */
	public static function isSupported() {
		return (extension_loaded('PDO') && extension_loaded('pdo_mysql'));
	}

	/**
	 * Returns the number of the last error.
	 * 
	 * @return	integer
	 */
	public function getErrorNumber() {
		if ($this->pdo !== null) return $this->pdo->errorCode();
		return 0;
	}
	
	/**
	 * Returns the description of the last error.
	 * 
	 * @return	string
	 */
	public function getErrorDesc() {
		if ($this->pdo !== null) {
			$errorInfoArray = $this->pdo->errorInfo();
			if (isset($errorInfoArray[2])) return $errorInfoArray[2];
		}
		return '';
	}

	/**
	 * Returns ID from last insert.
	 * 
	 * @param	string		$table
	 * @param	string		$field
	 * @return	integer
	 */
	public function getInsertID($table, $field) {
		try {
			return $this->pdo->lastInsertId();
		}
		catch (\PDOException $e) {
			throw new DatabaseException("Cannot fetch last insert id", $this);
		}
	}

	/**
	 * Gets the current database type.
	 * 
	 * @return	string
	 */
	public function getDBType() {
		return get_class($this);
	}
	
	/**
	 * Escapes a string for use in sql query.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	public function escapeString($string) {
		return addslashes($string);
	}
	
	/**
	 * Gets the sql version.
	 * 
	 * @return	string
	 */
	public function getVersion() {
		try {
			if ($this->pdo !== null) {
				return $this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);
			}
		}
		catch (\PDOException $e) {}
		
		return 'unknown';
	}
	
	/**
	 * Gets the database name.
	 * 
	 * @return	string
	 */
	public function getDatabaseName() {
		return $this->database;
	}
	
	/**
	 * Returns the name of the database user.
	 * 
	 * @return	string		user name
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * Returns the amount of executed sql queries.
	 * 
	 * @return	integer
	 */
	public function getQueryCount() {
		return $this->queryCount;
	}
	
	/**
	 * Increments the query counter by one.
	 */
	public function incrementQueryCount() {
		$this->queryCount++;
	}

	/**
	 * Sets default connection attributes.
	 */
	protected function setAttributes() {
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
		$this->pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
		$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	}

	/**
	 * Prepares a statement for execution and returns a statement object.
	 * 
	 * @param	string			$statement
	 * @param	integer			$limit
	 * @param	integer			$offset
	 * @return	\wcf\system\database\statement\PreparedStatement
	 */
	public function prepareStatement($statement, $limit = 0, $offset = 0) {
		$statement = $this->handleLimitParameter($statement, $limit, $offset);
		
		try {
			$pdoStatement = $this->pdo->prepare($statement);
			if ($pdoStatement instanceof \PDOStatement) {
				return new PreparedStatement($this, $pdoStatement, $statement);
			}
			throw new DatabaseException("Cannot prepare statement: ".$statement, $this);
		}
		catch (\PDOException $e) {
			throw new DatabaseException("Cannot prepare statement: ".$statement, $this);
		}
	}

	/**
	 * Handles the limit and offset parameter in SELECT queries.
	 * This is a default implementation compatible to MySQL and PostgreSQL.
	 * Other database implementations should override this function. 
	 * 
	 * @param	string		$query
	 * @param	integer		$limit
	 * @param	integer		$offset
	 * @return	string
	 */
	public function handleLimitParameter($query, $limit = 0, $offset = 0) {
		if ($limit != 0) {
			if ($offset > 0) $query .= " LIMIT " . $offset . ", " . $limit;
			else $query .= " LIMIT " . $limit;
		}
		
		return $query;
	}
}

?>