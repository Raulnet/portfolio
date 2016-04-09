<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 17/03/2015
 * Time: 12:36
 */

namespace portfolio\Controller;

use Silex\Application;

class MicroLadderController
{

    /**
     *
     * Home page controller.
     * @param Application $app Silex application
     *
     */
    public function indexAction(Application $app)
    {

        $champs = $app['dao.championship']->findAll();
        $players = $app['dao.player']->findAll();


        return $app['twig']->render('/microLadder/index.html.twig', array(
            'championships' => $champs,
            'players' => $players,

        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return mixed
     */
    public function championshipAction(Application $app, $id)
    {

        $champ = $app['dao.championship']->find($id);
        $players = $app['dao.player']->findAll();
        $rounds = $app['dao.round']->findByChampionship($id);
        $results = $app['dao.result']->findByChampionship($id);
        $topResults = $app['dao.result']->findTopByChampionship($id);

        return $app['twig']->render('/microLadder/championship.html.twig', array(
            'championship' => $champ,
            'rounds' => $rounds,
            'players' => $players,
            'results' => $results,
            'topResults' => $topResults,
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return mixed
     */
    public function roundAction(Application $app, $id)
    {
        ;
        $round = $app['dao.round']->find($id);
        $players = $app['dao.player']->findAll();
        $results = $app['dao.result']->findByRound($id);

        return $app['twig']->render('/microLadder/round.html.twig', array(
            'round' => $round,
            'players' => $players,
            'results' => $results,


        ));
    }
} 