<?php
namespace framework\system;
use framework\system\exception\SystemException;

// try to set a time-limit to infinite
@set_time_limit(0);

// define current wcf version
define('FRAMEWORK_VERSION', '0.111.214 Alpha');

// define current unix timestamp
define('TIME_NOW', time());

// include config
require_once(RELATIVE_SYS_DIR.'config.inc.php');
// include options
require_once(RELATIVE_SYS_DIR.'options.inc.php');

// set exception handler
set_exception_handler(array('framework\system\System', 'handleException'));

// set php error handler
set_error_handler(array('framework\system\System', 'handleError'), E_ALL ^ E_DEPRECATED);

/**
 * System is the central class for the community framework.
 * It holds the database connection, access to template and language engine.
 * 
 * @author		MadnessFreak
 * @copyright	2014 MadnessFreak
 */
class System
{
	/**
	 * database object
	 * @var	\framework\system\database\Database
	 */
	protected static $dbObj = null;
	
	/**
	 * language object
	 * @var	\framework\system\language\Language
	 */
	protected static $languageObj = null;

	/**
	 * session object
	 * @var	\framework\system\session\SessionHandler
	 */
	protected static $sessionObj = null;
	
	/**
	 * template object
	 * @var	\framework\system\template\TemplateEngine
	 */
	protected static $tplObj = null;

	/**
	 * request handler object
	 * @var	\framework\system\request\RequestHandler
	 */
	protected static $requestObj = null;

	/* *************************************************************************** */

	/**
	 * Calls all init functions of the WCF class.
	 */
	public function __construct() {		
		// preload
		$this->preload();

		// start initialization
		//$this->initDB();
		$this->loadOptions();
		//$this->initSession();
		//$this->initLanguage();
		$this->initTPL();

		// handle request
		$this->handle();
	}

	/* *************************************************************************** */

	/**
	 * Returns true if the debug mode is enabled, otherwise false.
	 * 
	 * @return	boolean
	 */
	public static function debugModeIsEnabled() {
		if (defined('ENABLE_DEBUG_MODE') && ENABLE_DEBUG_MODE) {
			return true;
		}
		
		return false;
	}

	/**
	 * Includes the required util or exception classes manually.
	 */
	public static final function preload() {
		require_once(SYS_DIR.'system/exception/IPrintableException.php');
		require_once(SYS_DIR.'system/exception/LoggedException.php');
		require_once(SYS_DIR.'system/exception/SystemException.php');
		require_once(SYS_DIR.'system/request/RequestAction.php');
		require_once(SYS_DIR.'system/request/RequestHandler.php');
		require_once(SYS_DIR.'system/twig/Autoloader.php');
		require_once(SYS_DIR.'system/util/FileUtil.php');
		require_once(SYS_DIR.'system/util/JSON.php');
		require_once(SYS_DIR.'system/util/StringUtil.php');
	}

	/**
	 * Loads the database configuration and creates a new connection to the database.
	 */
	protected function initDB() {
		// get configuration
		$dbHost = $dbUser = $dbPassword = $dbName = '';
		$dbPort = 0;
		$dbClass = 'framework\system\database\Database';
		require(SYS_DIR.'config.inc.php');		
		
		// create database connection
		self::$dbObj = new $dbClass($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);
	}

	/**
	 * Loads the template engine.
	 */
	protected function initTPL() {
		\Twig_Autoloader::register(true);

		$loader = new \Twig_Loader_Filesystem(SYS_DIR.'templates');

		if (self::debugModeIsEnabled()) { // DEBUG -> No cache
			self::$tplObj = new \Twig_Environment($loader);
		} else { // RELEASE -> Cache
			self::$tplObj = new \Twig_Environment($loader, array(
			    'cache' => SYS_DIR.'cache',
			));
		}
	}

	/**
	 * Loads the options file, automatically created if not exists.
	 */
	protected function loadOptions() {
		$filename = SYS_DIR.'options.inc.php';

		require_once($filename);
	}

	/* *************************************************************************** */

	/*
	 * Handles a page request.
	 */
	protected function handle()
	{
		// create request handler
		$request = new RequestHandler();
		$request->handle();

		// render content
		$template = self::$tplObj->loadTemplate('index.tpl');
		echo $template->render($content);
	}

	/* *************************************************************************** */

	/**
	 * Returns the database object.
	 * 
	 * @return	\framework\system\database\Database
	 */
	public static final function getDB() {
		return self::$dbObj;
	}

	/**
	 * Returns the template engine object.
	 * 
	 * @return	\framework\system\database\Database
	 */
	public static final function getTPL() {
		return self::$tplObj;
	}

	/* *************************************************************************** */

	/**
	 * Calls the show method on the given exception.
	 * 
	 * @param	\Exception	$e
	 */
	public static final function handleException(\Exception $e) {
		try {
			if ($e instanceof IPrintableException) {
				$e->show();
				exit;
			}
			if ($e instanceof \Twig_Error) {
				self::handleException(new SystemException($e->getMessage(), $e->getCode(), '', $e));
				//$e->show();
				exit;
			}
			
			// repack exception
			//self::handleException(new SystemException($e->getMessage(), $e->getCode(), '', $e));

			// show exception
			$e->show();
		}
		catch (\Exception $exception) {
			die("<pre>Framework::handleException() Unhandled exception: ".$exception->getMessage()."\n\n".$exception->getTraceAsString());
		}
	}

	/**
	 * Catches php errors and throws instead a system exception.
	 * 
	 * @param	integer		$errorNo
	 * @param	string		$message
	 * @param	string		$filename
	 * @param	integer		$lineNo
	 */
	public static final function handleError($errorNo, $message, $filename, $lineNo) {
		if (error_reporting() != 0) {
			$type = 'error';
			switch ($errorNo) {
				case 2: $type = 'warning';
					break;
				case 8: $type = 'notice';
					break;
			}
			
			throw new SystemException('PHP '.$type.' in file '.$filename.' ('.$lineNo.'): '.$message, 0);
		}
	}
}