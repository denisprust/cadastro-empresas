<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS . '..');
define('PROJECT_NAMESPACE', 'TesteElian\\');
define('NODE_MODULES', '/teste-elian/app/node_modules');
define('ASSETS', '/teste-elian/app/Assets');

// Classes do Core
require_once __DIR__ . '/Autoload.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/View.php';

$autoload = new \TesteElian\Core\Autoload;

spl_autoload_register(array($autoload, 'loadControllers'));
spl_autoload_register(array($autoload, 'loadModels'));
spl_autoload_register(array($autoload, 'loadHelpers'));
