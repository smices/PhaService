<?php

/**
 * Kint
 *
 * @param array ...$vars
 */
function dd(...$vars)
{
    Kint::dump(...$vars);
    exit;
}

Kint::$aliases[] = 'dd';
function sd(...$vars)
{
    s(...$vars);
    exit;
}

Kint::$aliases[] = 'sd';

/**
 * Whoops
 */
//$whoops = new \Whoops\Run;
//$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//$whoops->pushHandler(new \Whoops\Handler\PlainTextHandler);
//$whoops->pushHandler(new \Whoops\Handler\XmlResponseHandler);
//$whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
//$whoops->register();
