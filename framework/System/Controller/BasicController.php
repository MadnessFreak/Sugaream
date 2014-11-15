<?php

class BasicController extends Controller {
	public function index() {
		$this->createNavigation();
	}

	private function createNavigation() {
		// prepare sql request
		$sql = "SELECT		*
				FROM		sug_navigation
				ORDER BY	showOrder ASC";
		$statement = System::getDB()->prepareStatement($sql);
		$statement->execute();
		$navigation = array();
		
		// fetch rows
		while ($row = $statement->fetchArray()) {
			array_push($navigation, $row);
		}

		// assign data
		System::getTPL()->assign('navigation', $navigation);
	}
}