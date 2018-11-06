<?php

$router = $di->getRouter();

$router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_GET_URL);

$router->add(':controller/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);

$router->handle();
