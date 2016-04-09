<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 13:02
 */

$movie = $app['controllers_factory'];

// Route Homepage Movies
$movie->get('/', "portfolio\Controller\MovieController::indexAction")->bind('silex-movie');

// Route Nextpage Movies
$movie->get('/page/{page}/', "portfolio\Controller\MovieController::pageAction")->bind('page');

// Home GenrePage
$movie->get('/genre/{genre}/{code}/page/{page}', "portfolio\Controller\MovieController::genreAction")->bind('genre');

// Detailed info about an article
$movie->match('/article/{id}', "portfolio\Controller\MovieController::articleAction")->bind('article');

// Page single Movie
$movie->match('/movie/{code}/', "portfolio\Controller\MovieController::movieAction" )->bind('movie');

// page person movie
$movie->match('/person/{code}/', "portfolio\Controller\MovieController::personAction" )->bind('person');

// Page Test silex-Movie
$movie->get('/movieTest/{code}', "portfolio\Controller\MovieController::pageTestAction")->bind('movieTest');

// Login form
$movie->get('/login', "portfolio\Controller\MovieController::loginAction")->bind('login-movie');

return $movie;
