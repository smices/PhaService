<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt'  => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath'      => $config->application->cacheDir,
                'compiledSeparator' => '_',
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class,

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class  = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset,
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


/**
 * The logger
 */
//$di->setShared('logger', function () {
//    $loggerFile = sprintf('%s/var/log/%d.log', BASE_PATH, date('ymd'));
//    if (!is_dir(dirname($loggerFile))) @mkdir(dirname($loggerFile), 0755, TRUE);
//
//    return new \Phalcon\Logger\Adapter\File($loggerFile, ['mode' => 'a']);
//});

$di->setShared('logger', function () {
    $logDir = BASE_PATH . '/var/log/app/' . date('ymd') . '/';
    if (!is_dir($logDir)) @mkdir($logDir, 0755, TRUE);
    return new Phalcon\Logger\Adapter\File\Multiple($logDir, [
        'prefix' => date('ymd'),
    ]);
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ]);
});

/**
 * Redis Service
 */
$di->setShared('redis', function () use ($di) {
    $opts = $di['config']['redis'];

    $frontendOpts = new \Phalcon\Cache\Frontend\Data([
        "lifetime" => $opts['lifetime'],
    ]);
    $backendRedis = new Phalcon\Cache\Backend\Redis($frontendOpts, $opts);

    return $backendRedis;
});

/**
 * PiKa DB
 */
$di->setShared('pika', function () use ($di) {
    $opts    = $di['config']['pika'];
    $service = new \Redis();
    if (TRUE == $opts['persistent']) {
        $service->pconnect($opts['host'], $opts['port'], 1);
    } else {
        $service->connect($opts['host'], $opts['port'], 1);
    }
    $service->select(10);
    return $service;
});


/**
 * Starts the session the first time some component requests the session service
 */
$di->setShared('session', function () use ($di) {
//    $session = new Phalcon\Session\Adapter\Files();
//    $session->start();
    $opts             = $di['config']['redis'];
    $opts['uniqueId'] = 'cn.qhbit.passport';
    $opts['index']    = 1;
    $opts['lifetime'] = 604800; //3600*24*7;
    $opts['prefix']   = 's_';
    $session          = new \Phalcon\Session\Adapter\Redis($opts->toArray());
    $session->setName('JSESSIONID');
    if ($session->isStarted() == FALSE) {
        $session->start();
    }

    return $session;
});


/**
 * Crypt
 */
$di->set("crypt", function () {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey('8792a575474c5');
    return $crypt;
});

$di->set("cookies", function () {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(TRUE);
    return $cookies;
});


/**
 * Starts the cache service
 */
$di->setShared('cache', function () use ($di) {
    $client        = $di['redis'];
    $opts          = $client->getOptions();
    $opts['index'] = 2;
    $client->setOptions($opts);

    return $client;
});


/**
 * Message Queue
 */
$di->setShared('queue', function () {
    $config = $this->getConfig();
    //return new Phalcon\Queue\Beanstalk($config->beanstalk->toArray());
    return new Beanspeak\Client($config->beanstalk->toArray());
});


