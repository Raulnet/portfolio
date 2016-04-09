<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 07/12/14
 * Time: 17:45
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../app/config/dev.php';
require __DIR__.'/../app/app.php';
require __DIR__.'/../app/routes.php';

$app->run();
