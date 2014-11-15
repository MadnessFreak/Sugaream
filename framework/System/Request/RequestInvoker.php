<?php

/**
 * Provides an invoker for controllers.
 */
class RequestInvoker {
	/**
	 * Invokes the requested controller.
	 *
	 * @param	string	name
	 */
	public static function invoke($name) {
		// create controller name
		$name = ucfirst($name) . 'Controller';
		$path = SYS_DIR . 'System/Controller/' . $name . '.php';

		// try invoke
		if (file_exists($path)) {
			$controller = new $name();
			$action = System::getRequest()->getAction();
			$action = $name == 'BasicController' ? 'index' : $action;
			$action = empty($action) ? 'index' : $action;

			if (method_exists($controller, $action)) {
				$controller->init();
				$controller->{$action}();
			} else {
				Alert::show("<b>Dev Mode:</b> Controller method $action not found while invoking $name", false, AlertType::Warning);
			}
		} else {
			if (System::debugModeIsEnabled()) {
				Alert::show("<b>Dev Mode:</b> Controller $name was not found", false, AlertType::Warning);
			}
		}
	}
}