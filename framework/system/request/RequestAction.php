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

		// do what to do
		$template = System::getTPL();
		$database = System::getDB();
		$page = $handler->getPage();
		$action = $handler->getAction();
		$value = $handler->getValue();
		$type = $handler->getType();

		switch ($page) {
			case 'members':
				if ($action == 'profile') {
					$temp = $database->queryFetch("SELECT * FROM sug_user WHERE username = '$value'");
					
					if (count($temp) < 1) {
						$template->addGlobal('member', false);
					} else {
						$temp[0]['groups'] = $database->queryFetch("SELECT u.groupID, g.groupName, g.priority FROM sug_user_to_group u INNER JOIN sug_group g ON (u.groupID = g.groupID) WHERE u.userID = ".$temp[0]['userID']." ORDER BY g.priority DESC");
						$temp[0]['group'] = $temp[0]['groups'][0];
						$template->addGlobal('member', $temp[0]);
					}
				} else {
					//$template->addGlobal('members', $database->queryFetch("SELECT us.*, u.*, g.* FROM sug_user us INNER JOIN sug_user_to_group u ON (us.userID = u.userID) INNER JOIN sug_group g ON (u.groupID = g.groupID) ORDER BY g.priority DESC"));
					$temp = $database->queryFetch("SELECT * FROM sug_user");
					for ($i = 0; $i < count($temp); $i++) { 
						$temp[$i]['group'] = $database->queryFetch("SELECT u.groupID, g.* FROM sug_user_to_group u INNER JOIN sug_group g ON (u.groupID = g.groupID) WHERE u.userID = ".$temp[$i]['userID']." ORDER BY g.priority DESC")[0];
					}
					$template->addGlobal('members', $temp);
				}
				break;
			case 'groups':
				$template->addGlobal('groups', $database->queryFetch("SELECT * FROM sug_group"));
				break;
			default:
				# code...
				break;
		}

		$template->addGlobal('navigation', $database->queryFetch("SELECT * FROM sug_navigation ORDER BY showOrder ASC"));
	}
}