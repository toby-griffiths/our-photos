<?php

namespace OurPhotos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// $app needs to be defined already.
// This should be done in the ../web/index.php routing file
if (!isset($app) || !$app instanceof Application) {
    throw new \RuntimeException('$app needs to be set and an instance of \\Silex\\Application');
}

/**
 * JSON decode application/json content
 */
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});