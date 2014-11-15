<?php

if (!defined('APP_DIR')) define('APP_DIR', dirname(__FILE__).'/');
if (!defined('RELATIVE_APP_DIR')) define('RELATIVE_APP_DIR', '');

if (!defined('SYS_DIR')) define('SYS_DIR', dirname(__FILE__).'/framework/');
if (!defined('RELATIVE_SYS_DIR')) define('RELATIVE_SYS_DIR', RELATIVE_APP_DIR.'framework/');

if (!defined('FRAMEWORK_ADMIN')) define('FRAMEWORK_ADMIN', 'webmaster@localhost'); // $_SERVER['SERVER_ADMIN']

if (!defined('PAGE_TITLE')) define('PAGE_TITLE', 'Sugaream');
if (!defined('PAGE_AUTHOR')) define('PAGE_AUTHOR', 'MadnessFreak');
if (!defined('PAGE_KEYWORDS')) define('PAGE_KEYWORDS', '');
if (!defined('PAGE_DESCRIPTION')) define('PAGE_DESCRIPTION', '');

if (!defined('ENABLE_BREADCRUM_ON_INDEX')) define('ENABLE_BREADCRUM_ON_INDEX', 0);