<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 18/08/15
 * Time: 22:28
 */

$lounges = $app['controllers_factory'];

/***** LOUNGES *****/
$lounges->get('/admin/', "portfolio\Controller\LoungesController::indexAction")
    ->bind('the_grid_lounges');
/***** ADD *****/
$lounges->match('/admin/add', "portfolio\Controller\LoungesController::addAction")
    ->bind('the_grid_add_lounges');
/***** ADD TO STAGE *****/
$lounges->match('/admin/add_to_lounge/{stageId}', "portfolio\Controller\LoungesController::addToStageAction")
    ->bind('the_grid_add_lounges_to_stage');
/***** ADD PLAYER TO LOUNGE *****/
$lounges->match('/admin/add_player_to_lounge/{loungeId}/{playerId}', "portfolio\Controller\LoungesController::addPlayerToLoungeAction")
    ->bind('the_grid_add_player_to_lounge');
/***** REMOVE PLAYER TO LOUNGE *****/
$lounges->match('/admin/remove_player_to_lounge/{loungeId}/{playerId}', "portfolio\Controller\LoungesController::removePlayerToLoungeAction")
    ->bind('the_grid_remove_player_to_lounge');
/***** EDIT *****/
$lounges->match('/admin/edit/{id}', "portfolio\Controller\LoungesController::editAction")
    ->bind('the_grid_edit_lounge');
/***** SHOW *****/
$lounges->get('/admin/show/{id}', "portfolio\Controller\LoungesController::showAction")
    ->bind('the_grid_show_lounge');
/***** DELETE *****/
$lounges->get('/admin/delete/{id}', "portfolio\Controller\LoungesController::deleteAction")
    ->bind('the_grid_delete_lounge');

return $lounges;