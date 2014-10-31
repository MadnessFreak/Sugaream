<?php
namespace framework\system\exception;
use framework\system\System;
use framework\util\FileUtil;
use framework\util\StringUtil;

/**
 * A SystemException is thrown when an unexpected error occurs.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2014 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	system.exception
 * @category	Community Framework
 */
// @codingStandardsIgnoreFile
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
		
		$innerMessage = '';
		/*try {
			if (is_object(System::getLanguage())) {
				$innerMessage = System::getLanguage()->get('wcf.global.error.exception', true);
			}
		}
		catch (\Exception $e) { }*/
		
		if (empty($innerMessage)) {
			$innerMessage = 'Please send the ID above to the site administrator.<br />The error message can be looked up at &ldquo;ACP &raquo; Logs &raquo; Errors&rdquo;.';
		}
		
		// print report
		$e = ($this->getPrevious() ?: $this);
		?><!DOCTYPE html>
		<html>
			<head>
				<title>Fatal error: <?php echo StringUtil::encodeHTML($this->_getMessage()); ?></title>
				<meta charset="utf-8" />
				<style type="text/css">
					body {
						font-family: Verdana, Helvetica, sans-serif;
						font-size: 0.8em;
					}
					div {
						border: 1px outset lightgrey;
						padding: 3px;
						background-color: lightgrey;
					}
					
					div div {
						border: 1px inset lightgrey;
						padding: 4px;
					}
					
					h1 {
						background-color: #154268;
						padding: 4px;
						color: #fff;
						margin: 0 0 3px 0;
						font-size: 1.15em;
					}
					h2 {
						font-size: 1.1em;
						margin-bottom: 0;
					}
					
					pre, p {
						margin: 0;
					}
				</style>
			</head>
			<body>
				<div>
					<h1>Fatal error: <?php if(!$this->getExceptionID()) { ?>Unable to write log file, please make &quot;<?php echo FileUtil::unifyDirSeparator(SYS_DIR); ?>log/&quot; writable!<?php } else { echo StringUtil::encodeHTML($this->_getMessage()); } ?></h1>
					
					<?php if (System::debugModeIsEnabled()) { ?>
						<div>
							<?php if ($this->getDescription()) { ?><p><br /><?php echo $this->getDescription(); ?></p><?php } ?>
							
							<h2>Information:</h2>
							<p>
								<b>id:</b> <code><?php echo $this->getExceptionID(); ?></code><br>
								<b>error message:</b> <?php echo StringUtil::encodeHTML($this->_getMessage()); ?><br>
								<b>error code:</b> <?php echo intval($e->getCode()); ?><br>
								<?php echo $this->information; ?>
								<b>file:</b> <?php echo StringUtil::encodeHTML($e->getFile()); ?> (<?php echo $e->getLine(); ?>)<br>
								<b>php version:</b> <?php echo StringUtil::encodeHTML(phpversion()); ?><br>
								<b>framework version:</b> <?php echo FRAMEWORK_VERSION; ?><br>
								<b>date:</b> <?php echo gmdate('r'); ?><br>
								<b>request:</b> <?php if (isset($_SERVER['REQUEST_URI'])) echo StringUtil::encodeHTML($_SERVER['REQUEST_URI']); ?><br>
								<b>referer:</b> <?php if (isset($_SERVER['HTTP_REFERER'])) echo StringUtil::encodeHTML($_SERVER['HTTP_REFERER']); ?><br>
							</p>
							
							<h2>Stacktrace:</h2>
							<pre><?php echo StringUtil::encodeHTML($this->__getTraceAsString()); ?></pre>
						</div>
					<?php } else { ?>
						<div>
							<h2>Information:</h2>
							<p>
								<?php if (!$this->getExceptionID()) { ?>
									Unable to write log file, please make &quot;<?php echo FileUtil::unifyDirSeparator(WCF_DIR); ?>log/&quot; writable!
								<?php } else { ?>
									<b>ID:</b> <code><?php echo $this->getExceptionID(); ?></code><br>
									<?php echo $innerMessage; ?>
								<?php } ?>
							</p>
						</div>
					<?php } ?>
					
					<?php echo $this->functions; ?>
				</div>
			</body>
		</html>
		
		<?php
	}
}
