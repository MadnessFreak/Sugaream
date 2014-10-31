<?php
namespace framework\system\request;
use framework\system\exception\SystemException;
use framework\system\System;

// forces a secure connection -- test purposes only
if (!defined('REQUIRE_SECURE_CONNECTION')) define('REQUIRE_SECURE_CONNECTION', false);

/**
 * Handles a request action.
 * 
 * @author		MadnessFreak
 * @copyright	2014 MadnessFreak
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
class RequestAction {
	/**
	 * Executes the action.
	 */
	public function execute($handler) {
		if (empty($handler)) {
			throw new SystemException("Request handler is null");
		}

		if (REQUIRE_SECURE_CONNECTION && !$handler::secureConnection()) {
			throw new SystemException("Connection is not secure");
		}
	}
}