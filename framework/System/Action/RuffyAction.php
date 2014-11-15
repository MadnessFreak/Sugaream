<?php
/**
 * Handles a ruffy interaction.
 *
 * @author	MadnessFreak <madnessfreak@happyduckz.co>
 * @copyright	2014 MadnessFreak
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	Sugaream
 */
class RuffyAction implements IAction {
	/**
	 * Ruffy data.
	 */
	protected $ruffy = '';

	/**
	 * @see	\sugaream\action\IAction::read()
	 */
	public function read() {
		if (isset($_POST['ruffy'])) $this->ruffy = Utility::trim($_POST['ruffy']);
	}

	/**
	 * @see	\sugaream\action\IAction::validate()
	 */
	public function validate() {
		if (empty($this->ruffy)) {
			throw new SystemException("Ruffy is dead :/");
		}
	}

	/**
	 * @see	\sugaream\action\IAction::execute()
	 */
	public function execute() {
		
	}
}