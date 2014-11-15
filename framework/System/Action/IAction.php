<?php
/**
 * Provides an interface for an action that executes a user input.
 *
 * @author	MadnessFreak <madnessfreak@happyduckz.co>
 * @copyright	2014 MadnessFreak
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	Sugaream
 */
interface IAction {
	/**
	 * Reads the given parameters.
	 */
	public function read();

	/**
	 * Executes the data.
	 */
	public function validate();

	/**
	 * Executes the action.
	 */
	public function execute();
}