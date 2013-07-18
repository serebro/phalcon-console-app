<?php

defined('APPLICATION_PATH') || define('APPLICATION_PATH', dirname(__FILE__));

use Phalcon\DI\FactoryDefault\CLI as CliDI,
    Phalcon\CLI\Console as ConsoleApp;

$di = new CliDI();

// Default router
$di->set('router', array(
	'className' => '\Phalcon\CLI\Router',
));

// Default dirs
$di->set('loader', array(
	'className' => '\Phalcon\Loader',
	'calls' => array(
		array('method' => 'registerDirs', 'arguments' => array(
			array('type' => 'parameter', 'value' => array(
				//'controllers' => APPLICATION_PATH . '/controllers/',
				//'models'      => APPLICATION_PATH . '/models/',
				'tasks'       => APPLICATION_PATH . '/tasks/',
			))
		)),
		array('method' => 'register'),
	),
));
$di->get('loader');

// Default Task and Action
$di->set('dispatcher', array(
	'className' => '\Phalcon\CLI\Dispatcher',
		'calls'     => array(
			array('method' => 'setDefaultTask', 'arguments' => array(
				array('type' => 'parameter', 'value' => 'Main'),
			)),
			array('method' => 'setDefaultAction', 'arguments' => array(
				array('type' => 'parameter', 'value' => 'main'),
			)),
		),
	)
);

// Console application
$console = new ConsoleApp();
$console->setDI($di);

// Parse command line parameters "console.php taskName/actionName param1=value1 param2=value2"
$handle_params = array();
array_shift($argv); // Skip "console.php"
list($task, $action) = explode('/', array_shift($argv)); // Parse "taskName/actionName"
foreach($argv as $param) {
	list($name, $value) = explode('=', $param);
	$handle_params[$name] = $value;
}
$handle_params['module'] = null; // Without modules
$handle_params['task'] = $task;
$handle_params['action'] = $action;

// Run
$console->handle($handle_params);
