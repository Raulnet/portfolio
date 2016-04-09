<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/03/15
 * Time: 18:56
 */

/***********************************************************
 *REQUIRE PROVIDER
 ************************************************************/

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new portfolio\DAO\UserDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_SUPER_ORGANIZER', 'ROLE_ORGANIZER', 'ROLE_USER'),
        'ROLE_SUPER_ORGANIZER' => array('ROLE_ORGANIZER', 'ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('/admin', 'ROLE_ADMIN', ),
        array('/the_grid/admin', 'ROLE_ORGANIZER'),
    ),
));

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('fr'),
));

// Register services
$app['dao.article'] = $app->share(function ($app) {
    return new portfolio\DAO\ArticleDAO($app['db']);
});
$app['dao.user'] = $app->share(function ($app) {
    return new portfolio\DAO\UserDAO($app['db']);
});
$app['dao.comment'] = $app->share(function ($app) {
    $commentDAO = new portfolio\DAO\CommentDAO($app['db']);
    $commentDAO->setArticleDAO($app['dao.article']);
    $commentDAO->setUserDAO($app['dao.user']);
    return $commentDAO;
});
$app['paginator'] = $app->share(function () {
    return new portfolio\Model\Paginator();
});
$app['alloCine'] = $app->share(function () {
    require_once "../vendor/api-allocine/api-allocine-helper/api-allocine-helper.php";
    return new portfolio\DAO\AlloCineAPI(new AlloHelper);
});
$app['dao.championship'] = $app->share(function ($app){
    return new portfolio\DAO\ChampionshipDAO($app['db']);
});
$app['dao.player'] = $app->share(function ($app){
    return new portfolio\DAO\PlayerDAO($app['db']);
});
$app['dao.round'] = $app->share(function ($app){
    $roundDAO = new portfolio\DAO\RoundDAO($app['db']);
    $roundDAO->setChampionshipDAO($app['dao.championship']);
    return $roundDAO ;
});
$app['model.chrono'] = $app->share(function (){
    return new portfolio\Model\ChronoConverter();
});
$app['dao.result'] = $app->share(function ($app){
    $resultDAO = new portfolio\DAO\ResultDAO($app['db']);
    $resultDAO->setRoundDAO($app['dao.round']);
    $resultDAO->setPlayerDAO($app['dao.player']);
    $resultDAO->setChronoConverter($app['model.chrono']);
    return $resultDAO ;
});
$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('xliff', new XliffFileLoader());

    $translator->addResource('xliff', __DIR__.'/../src/locales/en.xlf', 'en');
    $translator->addResource('xliff', __DIR__.'/../src/locales/fr.xlf', 'fr');

    return $translator;
}));
// Register JSON data decoder for JSON requests
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

/* Register services */
$app['EM'] = $app->share(function ($app) {
    return new \portfolio\Model\GetEntityManager($app['zdb.configArray'], $app);
});

// ===== Register error handler ====================================================================================== //
//$app->error(function (\Exception $e, $code) use ($app) {
//    switch ($code) {
//        case 403:
//            $message = 'Access denied.';
//            break;
//        case 404:
//            $message = 'The requested resource could not be found.';
//            break;
//        default:
//            $message = "Something went wrong.";
//    }
//    return $app['twig']->render('error.html.twig', array('message' => $message));
//});
