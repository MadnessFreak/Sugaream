<?php
namespace framework\system\database;
use framework\system\database\DatabaseException;
use framework\system\System;

/**
 * Abstract implementation of a database access class.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2014 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	system.database
 * @category	Community Framework
 */
class Database {
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
	 * enables failsafe connection
	 * @var	boolean
	 */
	protected $failsafeTest = false;
	
	/**
	 * number of executed queries
	 * @var	integer
	 */
	protected $queryCount = 0;

	/**
	 * connection object
	 * @var	object
	 */
	protected $connection = null;

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
	public function __construct($host, $user, $password, $database, $port, $failsafeTest = false) {
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		$this->failsafeTest = $failsafeTest;
		
		// connect database
		$this->connect();
	}

	/**
	 * Connects to database server.
	 */
	public function connect() {
		if (!$this->port) $this->port = 3306; // mysql default port
		
		try {
			$this->connection = mysql_connect($this->host, $this->user, $this->password);

			if (!$this->connection) {
				throw new DatabaseException("Connecting to MySQL server '".$this->host."' failed:\n".$e->getMessage(), $this);
			}

			mysql_select_db($this->database, $this->connection);

			$driverOptions = array(
				\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
			);
			if (!$this->failsafeTest) {
				$driverOptions = array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'"
				);
			}
			
			$this->pdo = new \PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->user, $this->password, $driverOptions);
		}
		catch (\PDOException $e) {
			throw new DatabaseException("Connecting to MySQL server '".$this->host."' failed:\n".$e->getMessage(), $this);
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
	 * @param	string		user name
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
	 * Returns true if this database type is supported.
	 * 
	 * @return	boolean
	 */
	public static function isSupported() {
		return false;
	}

	public function query($sql)
	{
		$result = mysql_query($sql, $this->connection);

		if (!$result) {
			throw new DatabaseException(mysql_error(), $this);
		}
		
		return $result;
	}

	public function queryFetch($sql)
	{
		$result = mysql_query($sql, $this->connection);
		$array = array();

		if (!$result) {
			throw new DatabaseException(mysql_error(), $this);
		}

		while ($row = mysql_fetch_array($result)) {
			array_push($array, $row);
		}
		
		return $array;
	}
}