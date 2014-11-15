<?php

// define current wcf version
define('FRAMEWORK_VERSION', '0.11.0414 Alpha');

// define current unix timestamp
define('TIME_NOW', time());

define('ENABLE_DEBUG_MODE', 1);

// set exception handler
set_exception_handler(array('System', 'handleException'));

// set php error handler
set_error_handler(array('System', 'handleError'), E_ALL);

/**
 * Provides the framework core.
 *
 * @author	MadnessFreak <madnessfreak@happyduckz.co>
 * @copyright	2014 MadnessFreak
 * @package	Sugaream
 * @version	0.1112.214 Alpha
 */
class System
{
	/**
	 * request object
	 * @var	\framework\system\request\RequestHandler
	 */
	protected static $requestObj = null;

	/**
	 * template object
	 * @var	\framework\system\template\TemplateWrapper
	 */
	protected static $templateObj = null;

	/**
	 * database object
	 * @var	\framework\system\database\Database
	 */
	protected static $dbObj = null;

	/* ************************************************ */

	/**
	 * Calls all init functions of framework.
	 */
	function __construct()
	{
	}

	/* ************************************************ */

	public static final function init() {
		// preload
		self::preload();

		// start initialization
		self::initTemplateEngine();
		self::initDatabase();

		// handle request
		self::handle();
	}

	/**
	 * Includes the required util or exception classes manually.
	 */
	private static final function preload() {
		// include utility
		require_once('System/Utility.php');

		Utility::load(SYS_DIR.'System/Exceptions/IPrintableException.php');
		Utility::load(SYS_DIR.'System/Exceptions/LoggedException.php');
		Utility::load(SYS_DIR.'System/Exceptions/SystemException.php');

		// include autoloader
		Utility::load(SYS_DIR.'Autoloader.php');

		// register autoloader
		Autoloader::register();
	}

	/*
	 * Handles a request.
	 */
	private static final function handle()
	{
		// create request handler
		self::$requestObj = new RequestHandler();
		self::$requestObj->handle();

		// assign
		$defines = get_defined_constants(true)['user'];
		foreach ($defines as $key => $value) {
			self::$templateObj->assign($key, $value);
		}

		// display the view
		self::$templateObj->render();
	}

	/**
	 * Loads the template engine.
	 */
	private static function initTemplateEngine() {
		self::$templateObj = new TemplateWrapper();
		self::$templateObj->init();
	}

	/**
	 * Loads the template engine.
	 */
	private static function initDatabase() {
		// get configuration
		$dbHost = $dbUser = $dbPassword = $dbName = '';
		$dbPort = 0;

		$dbHost = 'localhost';
		$dbUser = 'root';
		$dbName = 'sugaream';

		// create database connection
		self::$dbObj = new Database($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);
	}

	/* ************************************************ */

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

	public static function getRequest() {
		return self::$requestObj;
	}

	public static function getTPL() {
		return self::$templateObj;
	}

	public static function getDB() {
		return self::$dbObj;
	}

	/* ************************************************ */

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
			if ($e instanceof Twig_Error) {
				self::handleException(new SystemException($e->getMessage(), $e->getCode(), '', $e));
				//$e->show();
				exit;
			}
			
			// repack exception
			self::handleException(new SystemException($e->getMessage(), $e->getCode(), '', $e));
			// show exception
			//$e->show();
		}
		catch (Exception $exception) {
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