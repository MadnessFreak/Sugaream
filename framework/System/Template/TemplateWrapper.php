<?php
/**
 * Provides an wrapper for the template engine.
 *
 * @author	MadnessFreak <madnessfreak@happyduckz.co>
 * @copyright	2014 MadnessFreak
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	Sugaream
 */
class TemplateWrapper {
	/**
	 * template engine object
	 * @var	\framework\system\template\TemplateEngine
	 */
	protected $engine = null;

	/* ************************************************ */

	public function init() {
		// include
		Utility::load(SYS_DIR.'System/Template/Twig/Autoloader.php');

		// register autoloader
		Twig_Autoloader::register(true);

		// create engine
		$loader = new Twig_Loader_Filesystem(SYS_DIR . 'Templates');
		$twig = new Twig_Environment($loader);

		// activate cache if release
		if (!System::debugModeIsEnabled()) {
			$twig->setCache(SYS_DIR . 'Cache');
		}

		// set engine
		$this->engine = $twig;
	}

	/* ************************************************ */

	/**
	 * Assigns a value to the template.
	 *
	 * @param	string	name
	 * @param	mixed	value
	 */
	public function assign($name, $value) {
		$this->engine->addGlobal($name, $value);
	}

	/**
	 * Renders a template.
	 */
	public function render()
	{
		echo $this->engine->render('index.tpl');
	}
}