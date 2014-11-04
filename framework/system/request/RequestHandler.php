<?php
namespace framework\system\request;
use framework\system\exception\SystemException;
use framework\system\System;

/**
 * Handles http requests.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2014 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	system.request
 * @category	Community Framework
 */
class RequestHandler {
	/**
	 * current host and protocol
	 * @var	string
	 */
	protected static $host = '';
	
	/**
	 * HTTP protocol, either 'http://' or 'https://'
	 * @var	string
	 */
	protected static $protocol = '';
	
	/**
	 * HTTP encryption
	 * @var	boolean
	 */
	protected static $secure = null;

	/**
	 * Requested uri
	 * @var	string
	 */
	protected static $uri = '';

	/**
	 * requested page
	 * @var	string
	 */
	protected static $requestPage = '';

	/**
	 * requested action
	 * @var	string
	 */
	protected static $requestAction = '';

	/**
	 * requested type
	 * @var	string
	 */
	protected static $requestType = '';

	/**
	 * requested value
	 * @var	mixed
	 */
	protected static $requestValue = 0;

	/**
	 * action handler
	 * @var	object
	 */
	protected static $actionHandler = null;

	/* ************************************************ */

	/**
	 * Handles a http request.
	 * 
	 * @param	string		$application
	 * @param	boolean		$isACPRequest
	 */
	public function handle() {
		// build request
		$this->buildRequest();

		// start request
		self::$actionHandler = new RequestAction();
		self::$actionHandler->execute($this);
	}

	/**
	 * Builds a new request.
	 * 
	 * @param	string		$application
	 */
	protected function buildRequest() {
		// set default request variables 
		if (count($_GET) <= 1) {
			self::$uri = explode('/', $_SERVER['REQUEST_URI']);

			self::$requestPage = strtolower(!empty(self::$uri[1]) ? self::$uri[1] : 'index');
			self::$requestAction = strtolower(!empty(self::$uri[2]) ? self::$uri[2] : '');
			self::$requestType = strtolower(!empty($_GET['type']) ? $_GET['type'] : '');
			self::$requestValue = strtolower(!empty(self::$uri[3]) ? self::$uri[3] : 0);

			// check for optional 'type' param
			$temp = explode('?', self::$requestValue)[0];
			if (count($temp) > 0) self::$requestValue = explode('=', $temp)[0];
		} else {
			self::$requestPage = strtolower(!empty($_GET['page']) ? $_GET['page'] : 'index');
			self::$requestAction = strtolower(!empty($_GET['action']) ? $_GET['action'] : '');
			self::$requestType = strtolower(!empty($_GET['type']) ? $_GET['type'] : '');
			self::$requestValue = strtolower(!empty($_GET['value']) ? $_GET['value'] : 0);
		}		

		// validate variables
		self::validateQuery(self::$requestPage);
		self::validateQuery(self::$requestAction);
		self::validateQuery(self::$requestType);
		self::validateQuery(self::$requestValue);

		// assign to tpl
		System::getTPL()->addGlobal('REQUEST_PAGE', self::$requestPage);
		System::getTPL()->addGlobal('REQUEST_ACTION', self::$requestAction);
		System::getTPL()->addGlobal('REQUEST_TYPE', self::$requestType);
		System::getTPL()->addGlobal('REQUEST_VALUE', self::$requestValue);
	}

	/* ************************************************ */

	/**
	 * Validates the request query for illegal strings.
	 */
	public static function validateQuery($query) {
		if (empty($query))
			return;

		// validate query
		if (!preg_match('~^[a-z0-9_]+$~i', $query)) {
			throw new SystemException("Illegal request query '".$query."'");
		}
	}

	/**
	 * Returns true if this is a secure connection.
	 * 
	 * @return	true
	 */
	public static function secureConnection() {
		if (self::$secure === null) {
			self::$secure = false;
			
			if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
				self::$secure = true;
			}
		}
		
		return self::$secure;
	}

	/**
	 * Returns HTTP protocol, either 'http://' or 'https://'.
	 * 
	 * @return	string
	 */
	public static function getProtocol() {
		if (empty(self::$protocol)) {
			self::$protocol = 'http' . (self::secureConnection() ? 's' : '') . '://';
		}
		
		return self::$protocol;
	}

	/**
	 * Returns protocol and domain name.
	 * 
	 * @return	string
	 */
	public static function getHost() {
		if (empty(self::$host)) {
			self::$host = self::getProtocol() . $_SERVER['HTTP_HOST'];
		}
		
		return self::$host;
	}

	/**
	 * Returns the requested page.
	 * 
	 * @return	string
	 */
	public static function getPage() {		
		return self::$requestPage;
	}

	/**
	 * Returns the requested action.
	 * 
	 * @return	string
	 */
	public static function getAction() {		
		return self::$requestAction;
	}

	/**
	 * Returns the requested type.
	 * 
	 * @return	string
	 */
	public static function getType() {		
		return self::$requestType;
	}

	/**
	 * Returns the requested value.
	 * 
	 * @return	mixed
	 */
	public static function getValue() {		
		return self::$requestValue;
	}
}