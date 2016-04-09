<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 22/08/15
 * Time: 12:27
 */
$results = $app['controllers_factory'];
/***** RESULTS *****/
$results->get('/admin/', "portfolio\Controller\ResultsController::indexAction")->bind('the_grid_results');
/***** GRID *****/
$results->match('/admin/grid/{loungeId}', "portfolio\Controller\ResultsController::addAction")->bind('the_grid_add_results');
/***** ADD TO STAGE *****/
$results->match('/admin/create_result', "portfolio\Controller\ResultsController::createResultAction")->bind('the_grid_create_result');
/***** EDIT *****/
$results->match('/admin/edit/{id}', "portfolio\Controller\ResultsController::editAction")->bind('the_grid_edit_result');
/***** SHOW *****/
$results->get('/admin/show/{id}', "portfolio\Controller\ResultsController::showAction")->bind('the_grid_show_result');
/***** DELETE *****/
$results->get('/admin/delete/{id}', "portfolio\Controller\ResultsController::deleteAction")->bind('the_grid_delete_result');

return $results;