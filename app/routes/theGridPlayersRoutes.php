<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 23/08/15
 * Time: 01:46
 */
$players = $app['controllers_factory'];

/* Route index */
$players->get('/', "portfolio\Controller\PlayersController::indexAction")
    ->bind('the_grid_players');

$players->match('/admin/add', "portfolio\Controller\PlayersController::addAction")
    ->bind('the_grid_add_player');

$players->match('/admin/edit/{id}', "portfolio\Controller\PlayersController::editAction")
    ->bind('the_grid_edit_player');

$players->match('/admin/delete/{id}', "portfolio\Controller\PlayersController::deleteAction")
    ->bind('the_grid_delete_player');

$players->get('/admin/show_to_championship/{championshipId}', "portfolio\Controller\PlayersController::showToChampionshipAction")
    ->bind('the_grid_show_player_to_championship');

$players->get('/admin/add_to_championship/{championshipId}/{playerId}', "portfolio\Controller\PlayersController::addToChampionshipAction")
    ->bind('the_grid_add_player_to_championship');

$players->get('/admin/remove_to_championship/{championshipId}/{playerId}', "portfolio\Controller\PlayersController::removeToChampionshipAction")
    ->bind('the_grid_remove_player_to_championship');


return $players;