<?php

abstract class Controller {
	/**
	 * request object
	 * @var	\framework\system\request\RequestHandler
	 */
	protected $request = null;

	/* ************************************************ */

	/**
	 * Initializes a new instance of the controller class.
	 */
	public function init() {
		$this->request = System::getRequest();
	}

	/**
	 * Default invoke method.
	 */
	public function index() {
	}
}