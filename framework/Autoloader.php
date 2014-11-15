<?php

/**
 * Provides the autoloader.
 *
 * @package	Sugaream
 * @author	MadnessFreak <madnessfreak@happyduckz.co>
 * @copyright	2014 MadnessFreak
 * @version	0.1112.214 Alpha
 */
class Autoloader {
	/**
	 * Registers the autoloader.
	 */
	public static function register()
	{
		spl_autoload_register(array(__CLASS__, 'load'));
	}

	/**
     * Handles autoloading of classes.
     *
     * @param string $class
     */
	public static function load($class)
	{
		$cache = Utility::unifydir(SYS_DIR . 'Cache/Autoloader.cache');
		$directories = array();

		// delete if debug
		if (System::debugModeIsEnabled() && file_exists($cache)) {
			unlink($cache);
		}

		// load from cache or scan
		if (file_exists($cache)) {
			$directories = unserialize(file_get_contents($cache));
		} else {
			$directories = self::scan(Utility::unifydir(SYS_DIR));
			$temp = serialize($directories);
			file_put_contents($cache, $temp);
		}

        // prepare class path
        $className = str_replace(__NAMESPACE__ . DIRECTORY_SEPARATOR, '', $class);
		$classPath = Utility::unifydir($className . '.php');
		$loadable = false;	

		// checking if file exists
		for ($i=0; $i < count($directories); $i++) { 
			if (file_exists($directories[$i] . $classPath)) {
				$classPath = $directories[$i] . $classPath;
				$loadable = true;
				break;
			}
		}

		// include
		if ($loadable && is_file($file = $classPath)) {
			require_once $file;
		} else {
			throw new SystemException("Loading class '$class' failed");
		}
	}

	/**
	 * Searches for all directories in the base path.
	 *
	 * @param	string	$base
	 */
	private static function scan($base) {
		$directories = array();
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base), \RecursiveIteratorIterator::SELF_FIRST);
		
		foreach ($iterator as $dir) {
			if ($dir->isDir() && !$iterator->isDot() && strpos($dir->__toString(), 'Twig') === false) {
				array_push($directories, $dir->__toString() . DIRECTORY_SEPARATOR);
			}
		}

		array_push($directories, $base);

		return $directories;
	}
}