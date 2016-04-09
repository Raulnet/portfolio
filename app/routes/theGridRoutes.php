<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 20:17
 */
$theGrid = $app['controllers_factory'];

/* Route Home */
$theGrid->get('/', "portfolio\Controller\TheGridController::indexAction")->bind('the_grid');
/***** CHAMPIONSHIPS *****/
$theGrid->get('/championships', "portfolio\Controller\ChampionshipsController::indexAction")->bind('the_grid_championships');
/***** ADD *****/
$theGrid->match('/admin/championships/add', "portfolio\Controller\ChampionshipsController::addAction")->bind('the_grid_add_championships');
/***** EDIT *****/
$theGrid->match('/admin/championships/edit/{id}', "portfolio\Controller\ChampionshipsController::editAction")->bind('the_grid_edit_championship');
/***** SHOW *****/
$theGrid->match('/championships/show/{id}', "portfolio\Controller\ChampionshipsController::showAction")->bind('the_grid_show_championship');
/***** DELETE *****/
$theGrid->get('/admin/championships/delete/{id}', "portfolio\Controller\ChampionshipsController::deleteAction")->bind('the_grid_delete_championship');

/***** ADD RESULT*****/
$theGrid->match('/admin/championships/add_result/{champId}/{resultId}', "portfolio\Controller\ChampionshipsController::addResultAction")->bind('the_grid_add_result_championship');

/***** EXPORT CSV*****/
$theGrid->match('/admin/championships/csv/{champId}', "portfolio\Controller\ChampionshipsController::exportCsvAction")->bind('the_grid_championship_export_csv');


/***** AJAX *****/
$theGrid->post('/championships/find_grid_points', "portfolio\Controller\ChampionshipsController::findGridPointsAction")
    ->bind('the_grid_championships_findgridpoints');

return $theGrid;