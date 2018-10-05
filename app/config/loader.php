<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces([
    'Phalcon' => BASE_PATH . '/library/Phalcon',
]);


$loader->registerDirs(
    [
        //$config->application->controllersDir,
        //$config->application->modelsDir
        APP_PATH . '/controllers',
        APP_PATH . '/models',
    ]
);


$loader->register();
