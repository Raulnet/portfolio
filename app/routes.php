<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/03/15
 * Time: 18:57
 */

// ===== ROUTE GLOBAL =============================================================================================== //

/* Route locale */
$app->get('/', "portfolio\Controller\GlobalController::localeAction");

$app->post('/emails', "portfolio\Controller\HomeController::TestEmailAction")->bind('test_emails');

// ===== ROUTE PORTFOLIO ============================================================================================ //

$app->mount('/{_locale}', include 'routes/home_routes.php');

// ===== ROUTE ADMIN ================================================================================================ //

$app->mount('/{_locale}/admin', include 'routes/admin_routes.php');

// ===== ROUTE SILEX MOVIES ========================================================================================= //

$app->mount('/{_locale}/silex-movies', include 'routes/silex_movies_routes.php');

// ===== ROUTE MICRO LADDER ========================================================================================= //

$app->mount('/{_locale}/micro-ladder', include 'routes/micro_ladder_routes.php');

// ===== ROUTE THE GRID =========================================================================================== //
$app->mount('/{_locale}/the_grid', include 'routes/theGridRoutes.php');
// ===== ROUTE THE GRID STAGES ==================================================================================== //
$app->mount('/{_locale}/the_grid/stages', include 'routes/theGridStagesRoutes.php');
// ===== ROUTE THE GRID LOUNGES =================================================================================== //
$app->mount('/{_locale}/the_grid/lounges', include 'routes/theGridLoungesRoutes.php');
// ===== ROUTE THE GRID ROUNDS ==================================================================================== //
$app->mount('/{_locale}/the_grid/rounds', include 'routes/theGridRoundsRoutes.php');
// ===== ROUTE THE GRID RESULTS =================================================================================== //
$app->mount('/{_locale}/the_grid/results', include 'routes/theGridResultsRoutes.php');
// ===== ROUTE THE GRID PLAYERS =================================================================================== //
$app->mount('/{_locale}/the_grid/players', include 'routes/theGridPlayersRoutes.php');


// ===== ROUTE API ================================================================================================== //

$app->mount('/api', include 'routes/api_routes.php');

// ===== END ROUTES ================================================================================================= //========================================== //