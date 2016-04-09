<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 20:21
 */

namespace portfolio\Controller;

use Silex\Application;
use portfolio\Form\Type\TestFormType;

class TheGridController extends AbstractController {

    public function indexAction(Application $app){

        $championships = $this->getChampionshipsEM($app)->findAll();
        $players = $this->getPlayersEM($app)->findAll();

        return $this->getTwig($app)->render('TheGrid/index.html.twig', array(
            'championships' => $championships,
            'players'   => $players,
        ));
    }

    /* ***** SERVICE ***** */

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\ChampionshipsZEM
     */
    private function getChampionshipsEM(Application $app){

        return $app['EM']->get('ChampionshipsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\PlayersZEM
     */
    private function getPlayersEM(Application $app){

        return $app['EM']->get('PlayersZEM');
    }
}