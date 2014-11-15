<?php

abstract class AlertType {
    const Warning = 0;
    const Error = 1;
    const Success = 2;
    const Info = 3;
}

class Alert {
	public static function show($message, $title = false, $type = AlertType::Info, $closeable = false) {
		$alert = array(
			'type' => self::decodeType($type),
			'title' => $title,
			'message' => $message,
			'closeable' => $closeable
			);

		System::getTPL()->assign('ALERT', $alert);
	}

	private static function decodeType($type) {
		switch ($type) {
			case 0: return 'warning';
			case 1: return 'error';
			case 2: return 'success';
			default: return 'info';
		}
	}
}