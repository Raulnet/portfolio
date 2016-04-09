<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 12:48
 */

$admin = $app['controllers_factory'];

// Index Admin Page
$admin->get('/', "portfolio\Controller\AdminController::indexAction")->bind('admin');

// Add a new article
$admin->match('/article/add', "portfolio\Controller\AdminController::addArticleAction")->bind('addArticle');

// Edit an existing article
$admin->match('/article/{id}/edit', "portfolio\Controller\AdminController::editArticleAction")->bind('editArticle');

// Remove an article
$admin->get('/article/{id}/delete', "portfolio\Controller\AdminController::deleteArticleAction")->bind('deletArticle');

// Edit an existing comment
$admin->match('/comment/{id}/edit', "portfolio\Controller\AdminController::editCommentAction")->bind('editComment');

// Remove a comment
$admin->get('/comment/{id}/delete', "portfolio\Controller\AdminController::deleteCommentAction")->bind('deletComment');

// Add a user
$admin->match('/user/add', "portfolio\Controller\AdminController::addUserAction")->bind('addUser');

// Edit an existing user
$admin->match('/user/{id}/edit', "portfolio\Controller\AdminController::editUserAction")->bind('editUser');

// Remove a user
$admin->get('/user/{id}/delete', "portfolio\Controller\AdminController::deleteUserAction")->bind('deletUser');

// Page Round Ladder ON THE FIREWAll !!!
$admin->get('/round/{id}', "portfolio\Controller\MicroLadderController::roundAction")->bind('round');

// Add Ladder Result
$admin->match('/Ladder/{playerId}/{roundId}/result/', "portfolio\Controller\AdminController::addLadderResultAction")->bind('addLadderResult');

// Edit Ladder Result
$admin->match('/Ladder/{resultId}/result/', "portfolio\Controller\AdminController::editLadderResultAction")->bind('editLadderResult');

// remove ladder result
$admin->get('/result/{resultId}/delete/{roundId}', "portfolio\Controller\AdminController::deleteResultAction")->bind('deletResult');

// Add Ladder Player
$admin->match('/Ladder/player/{roundId}', "portfolio\Controller\AdminController::addLadderPlayerAction")->bind('addLadderPlayer');

// edit Ladder Player
$admin->match('/Ladder/{id}/player/{roundId}/', "portfolio\Controller\AdminController::editLadderPlayerAction")->bind('editLadderPlayer');

// remove ladder result
$admin->get('/player/{playerId}/delete/{roundId}', "portfolio\Controller\AdminController::deletePlayerAction")->bind('deletPlayer');

/* Route All JSON Players */
$admin->get('/api/players', "portfolio\Controller\ApiController::playersAction");

/* Route JSON Player By Id */
$admin->get('/api/player/{id}', "portfolio\Controller\ApiController::playerByIdAction");

return $admin;