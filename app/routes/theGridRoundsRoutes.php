<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 21/08/15
 * Time: 22:09
 */

$rounds = $app['controllers_factory'];

/***** rounds *****/
$rounds->get('/admin/', "portfolio\Controller\RoundsController::indexAction")
    ->bind('the_grid_rounds');
/***** ADD *****/
$rounds->match('/admin/add', "portfolio\Controller\RoundsController::addAction")
    ->bind('the_grid_add_rounds');
/***** ADD TO STAGE *****/
$rounds->match('/admin/add_to_round/{stageId}', "portfolio\Controller\RoundsController::addToStageAction")
    ->bind('the_grid_add_round_to_stage');
/***** EDIT *****/
$rounds->match('/admin/edit/{id}', "portfolio\Controller\RoundsController::editAction")
    ->bind('the_grid_edit_round');
/***** SHOW *****/
$rounds->get('/admin/show/{id}', "portfolio\Controller\RoundsController::showAction")
    ->bind('the_grid_show_round');
/***** DELETE *****/
$rounds->get('/admin/delete/{id}', "portfolio\Controller\RoundsController::deleteAction")
    ->bind('the_grid_delete_round');


return $rounds;