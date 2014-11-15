<?php

class RequestHandler {
	/**
	 * Current host and protocol
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
	 * requested value
	 * @var	mixed
	 */
	protected static $requestValue = 0;
	/**
	 * requested params
	 * @var	array
	 */
	protected static $requestParams = array();
	/**
	 * action handler
	 * @var	object
	 */
	protected static $actionHandler = null;

	/* ************************************************ */

	/**
	 * Handles a http request.
	 * 
	 */
	public function handle() {
		// build request
		$this->buildRequest();
	}

	/**
	 * Builds a new request.
	 * 
	 * @param	string		$application
	 */
	protected function buildRequest() {
		// set default request variables
		if (isset($_SERVER['HTTP_MOD_REWRITE']) && $_SERVER['HTTP_MOD_REWRITE'] == 'On') {
			self::$uri = explode('/', $_SERVER['REQUEST_URI']);
			self::$requestPage = strtolower(!empty(self::$uri[1]) ? self::$uri[1] : 'index');
			self::$requestAction = strtolower(!empty(self::$uri[2]) ? self::$uri[2] : '');
			self::$requestValue = !empty(self::$uri[3]) ? self::$uri[3] : 0;

			// set param data
			$paramdata = explode('?', self::$requestValue);

			// check for optional params
			if ((count($paramdata) - 1) > 0) {
				self::$requestValue = $paramdata[0];
				$query = $paramdata[1];
				$temp = explode('&', $query);
				$count = count($temp);

				for ($i=0; $i < $count; $i++) { 
					// create param
					$param = explode('=', $temp[$i]);
					self::$requestParams[$param[0]] = $param[1];

					// validate param
					self::validateQuery(self::$requestParams[$param[0]]);
				}
			}
		} else {
			self::$requestPage = strtolower(!empty($_GET['page']) ? $_GET['page'] : 'index');
			self::$requestAction = strtolower(!empty($_GET['action']) ? $_GET['action'] : '');
			self::$requestValue = !empty($_GET['value']) ? $_GET['value'] : 0;
		}

		// validate variables
		self::validateQuery(self::$requestPage);
		self::validateQuery(self::$requestAction);
		self::validateQuery(self::$requestValue);

		// assign request params
		System::getTPL()->assign('REQUEST_PAGE', self::$requestPage);
		System::getTPL()->assign('REQUEST_ACTION', self::$requestAction);
		System::getTPL()->assign('REQUEST_TYPE', self::$requestValue);
		System::getTPL()->assign('REQUEST_PARAMS', self::$requestParams);

		// invoke controller
		RequestInvoker::invoke('Basic');
		RequestInvoker::invoke(self::$requestPage);
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
	 * Returns the requested value.
	 * 
	 * @return	mixed
	 */
	public static function getValue() {		
		return self::$requestValue;
	}
}