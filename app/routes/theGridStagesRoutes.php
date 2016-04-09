<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 23:53
 */
$stages = $app['controllers_factory'];

/***** STAGES *****/
$stages->get('/', "portfolio\Controller\StagesController::indexAction")->bind('the_grid_stages');
/***** ADD *****/
$stages->match('/add', "portfolio\Controller\StagesController::addAction")->bind('the_grid_add_stages');
/***** ADD TO CHAMPIONSHIP *****/
$stages->match('/add_to_champ/{championshipId}', "portfolio\Controller\StagesController::addToChampionshipAction")->bind('the_grid_add_stages_to_championship');
/***** EDIT *****/
$stages->match('/edit/{id}', "portfolio\Controller\StagesController::editAction")->bind('the_grid_edit_stage');
/***** SHOW *****/
$stages->get('/show/{id}', "portfolio\Controller\StagesController::showAction")->bind('the_grid_show_stage');
/***** DELETE *****/
$stages->get('/delete/{id}', "portfolio\Controller\StagesController::deleteAction")->bind('the_grid_delete_stage');

return $stages;