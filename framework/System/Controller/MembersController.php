<?php

class MembersController extends Controller {
	public function index() {
		// prepare sql request
		/*$sql = "SELECT		user.username 'User', group.groupName 'Group'
				FROM		sug_user user
				INNER JOIN	sug_user_to_group ug ON user.userID = ug.userID
				INNER JOIN	sug_group group ON ug.groupID = group.groupID
				ORDER BY	user.userID";*/
		$sql = "SELECT		user.username \"sug_user\", group.groupName \"sug_group\"
				FROM		sug_user user, ug_user_to_group ug, sug_group group
				WHERE		ug.userID = user.userID AND ug.groupID = group.groupID";

		// SELECT s.name AS Student, c.name AS Course FROM student s LEFT JOIN (bridge b CROSS JOIN course c) ON (s.id = b.sid AND b.cid = c.id);

/*
$this->sqlSelects .= "user_avatar.*, user_option_value.*, user_group.userOnlineMarking, user_table.*";
		
		$this->sqlJoins .= " LEFT JOIN wcf".WCF_N."_user user_table ON (user_table.userID = session.userID)";
		$this->sqlJoins .= " LEFT JOIN wcf".WCF_N."_user_option_value user_option_value ON (user_option_value.userID = user_table.userID)";
		$this->sqlJoins .= " LEFT JOIN wcf".WCF_N."_user_avatar user_avatar ON (user_avatar.avatarID = user_table.avatarID)";
		$this->sqlJoins .= " LEFT JOIN wcf".WCF_N."_user_group user_group ON (user_group.groupID = user_table.userOnlineGroupID)";
		
*/

		$statement = System::getDB()->prepareStatement($sql);
		$statement->execute();
		$members = array();
		
		// fetch rows
		while ($row = $statement->fetchArray()) {
			array_push($members, $row);
			print_r($row);
		}

		// assign data
		System::getTPL()->assign('members', $members);
	}

	public function profile() {
		
	}
}