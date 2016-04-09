<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 13:30
 */

$microLadder = $app['controllers_factory'];

// Page index Ladder
$microLadder->get('/', "portfolio\Controller\MicroLadderController::indexAction")->bind('micro-ladder');

// Page Championship Ladder
$microLadder->get('/championship/{id}', "portfolio\Controller\MicroLadderController::championshipAction")->bind('championship');

return $microLadder;

