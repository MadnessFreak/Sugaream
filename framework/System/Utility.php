<?php

/**
* Provides a utility for frequently used functions.
*/
class Utility
{
	/**
	 * Converts html special characters.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	public static function encodeHTML($string) {
		if (is_object($string)) 
			$string = $string->__toString();
		
		return @htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Unifies windows and unix directory separators.
	 * 
	 * @param	string		$path
	 * @return	string
	 */
	public static function unifyDirSeparator($path) {
		$path = str_replace('\\\\', '/', $path);
		$path = str_replace('\\', '/', $path);
		return $path;
	}

	public static function unifydir($path) {
		return self::unifyDirSeparator($path);
	}

	/**
	 * Alias to php sha1() function.
	 * 
	 * @param	string		$value
	 * @return	string
	 */
	public static function getHash($value) {
		return sha1($value);
	}
	
	/**
	 * Creates a random hash.
	 * 
	 * @return	string
	 */
	public static function getRandomID() {
		return self::getHash(microtime() . uniqid(mt_rand(), true));
	}

	public static function load($path) {
		require_once(self::unifyDirSeparator($path));
	}
}

?>