<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 12:16
 */

$home = $app['controllers_factory'];

/* Route Home */
$home->get('/', "portfolio\Controller\HomeController::indexAction")->bind('home');

/* Route login */
$home->get('/login', "portfolio\Controller\HomeController::loginAction")->bind('login');

/* Route Contact */
$home->post('/', "portfolio\Controller\HomeController::contactAction")->bind('contact');

return $home;

