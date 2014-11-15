<?php
//namespace sugaream\system\exceptions;

/**
* 
*/
class SystemException extends LoggedException implements IPrintableException {
	/**
	 * error description
	 * @var	string
	 */
	protected $description = null;
	
	/**
	 * additional information
	 * @var	string
	 */
	protected $information = '';
	
	/**
	 * additional information
	 * @var	string
	 */
	protected $functions = '';

	/**
	 * Creates a new SystemException.
	 * 
	 * @param	string		$message	error message
	 * @param	integer		$code		error code
	 * @param	string		$description	description of the error
	 * @param	\Exception	$previous	repacked Exception
	 */
	public function __construct($message = '', $code = 0, $description = '', \Exception $previous = null) {
		parent::__construct((string) $message, (int) $code, $previous);
		$this->description = $description;
	}

	/**
	 * Returns the description of this exception.
	 * 
	 * @return	string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @see	\wcf\system\exception\IPrintableException::show()
	 */
	public function show() {
		// send status code
		@header('HTTP/1.1 503 Service Unavailable');
		
		// show user-defined system-exception
		if (defined('SYSTEMEXCEPTION_FILE') && file_exists(SYSTEMEXCEPTION_FILE)) {
			require(SYSTEMEXCEPTION_FILE);
			return;
		}
		
		$innerMessage = 'Please send the ID above to the site <a href="mailto:'.FRAMEWORK_ADMIN.'">administrator</a>.';

		// print report
		$e = ($this->getPrevious() ?: $this);

		// include layout
		require 'ExceptionLayout.php';

		// exit
		exit();
	}
}