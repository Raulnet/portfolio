<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 17:44
 */

$api = $app['controllers_factory'];

/* Route All JSON Articles */
$api->get('/articles', "portfolio\Controller\ApiController::articlesAction");

/* Route JSON Article By Id */
$api->get('/article/{id}', "portfolio\Controller\ApiController::articleByIdAction");

/* Route JSON Championship By Id */
$api->get('/championship/{championshipId}', "portfolio\Controller\ApiController::championshipAction");





return $api;