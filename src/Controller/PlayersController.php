<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 23/08/15
 * Time: 01:35
 */

namespace portfolio\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Form\Type\PlayersType;
use portfolio\Form\Type\PlayersEditType;

class PlayersController extends AbstractController {

    /**
     * @param Application $app
     *
     * @return string
     */
    public function indexAction(Application $app){

        $players = $this->getPlayersEm($app)->findAll();

        return $this->getTwig($app)->render('TheGrid/Players/index.html.twig', array(
            'players' => $players
        ));
    }

    /**
     * @param Application $app
     * @param Request     $request
     *
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Application $app, Request $request){

        $form = $this->getFormFactory($app)->create(new PlayersType());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $app['security.token_storage']->getToken()->getUser();
            $player = $form->getData();
            $player['user_id'] = $user->getId();
            if($this->getPlayersEm($app)->insert($player)){
                $this->getSession($app)->getFlashBag()->add('success', 'New player successfully added !');
                return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_player'));
            }
        }

        $players = $this->getPlayersEm($app)->findAll();
        return $this->getTwig($app)->render('TheGrid/Players/add.html.twig', array(
            'form' => $form->createView(),
            'players' => $players
        ));
    }

    /**
     * @param Application $app
     * @param Request     $request
     * @param int         $id
     *
     * @return string
     */
    public function editAction(Application $app, Request $request, $id){

        $player = $this->getPlayersEm($app)->findOneById($id);

        $form = $this->getFormFactory($app)->create(new PlayersEditType(), $player->toArray());

        if($this->getSuperAccess($app, $player->getUserId())){
            if($this->formRequestAction($request, $this->getPlayersEm($app), $form)){

                $this->getSession($app)->getFlashBag()->add('success', 'The player was successfully edited !');
                return $app->redirect($this->urlGenerator($app)->generate('the_grid_players'));
            }
        }

        return $this->getTwig($app)->render('TheGrid/Players/edit.html.twig', array(
            'form' => $form->createView(),
            'player' => $player
        ));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Application $app, $id){
        $player = $this->getPlayersEm($app)->findOneById($id);
        if($this->getSuperAccess($app, $player->getUserId())) {
            if ($this->getPlayersEm($app)->delete(array('pla_id' => $id))) {

                $this->getSession($app)->getFlashBag()->add('success', 'The player was successfully deleted !');
                return $app->redirect($this->urlGenerator($app)->generate('the_grid_players'));
            }
        }
        return $app->redirect($this->urlGenerator($app)->generate('the_grid_players'));
    }

    /**
     * @param Application $app
     * @param int         $championshipId
     *
     * @return string
     */
    public function showToChampionshipAction(Application $app, $championshipId){

        $championship = $this->getChampionshipsEm($app)->findOneById($championshipId);

        $players = $this->getPlayersToChamp($app, $championshipId);

        return $this->getTwig($app)->render('TheGrid/Players/show_to_championship.html.twig', array(
            'players'               => $players,
            'championship'          => $championship
        ));
    }

    /**
     * @param Application $app
     * @param int         $championshipId
     * @param int         $playerId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addToChampionshipAction(Application $app, $championshipId, $playerId){

        if(!$this->getPlayersToChampionshipsEm($app)->find(array('championship_id' => $championshipId, 'player_id' => $playerId))){
            $this->getPlayersToChampionshipsEm($app)->insert(array('championship_id' => $championshipId, 'player_id' => $playerId));
            $this->getSession($app)->getFlashBag()->add('success', 'Players was successfully added !');
        }
        return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_player_to_championship', array('championshipId' => $championshipId)));
    }

    /**
     * @param Application $app
     * @param int         $championshipId
     * @param int         $playerId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeToChampionshipAction(Application $app, $championshipId, $playerId){

        $playerToChamp = current($this->getPlayersToChampionshipsEm($app)->find(array('championship_id' => $championshipId, 'player_id' => $playerId)));

        if($playerToChamp){
            $this->getPlayersToChampionshipsEm($app)->delete(array('pca_id' => $playerToChamp->getId()));
            $this->getSession($app)->getFlashBag()->add('success', 'Players was successfully removed !');
        }
        return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_player_to_championship', array('championshipId' => $championshipId)));
    }

    /******** METHOD ******/
    /**
     * @param Application $app
     * @param int         $championshipId
     *
     * @return array
     */
    private function getPlayersToChamp(Application $app, $championshipId){

        $players = array();

        $allPlayers = $this->getPlayersEm($app)->findAll($championshipId);

        foreach($allPlayers as $player){
            $players[$player->getId()] = $player->toArray();
            $players[$player->getId()]['pca_id'] = null;
            $players[$player->getId()]['championship_id'] = null;
        }

        $playersToChamp = $this->getPlayersEm($app)->getPlayersByChampionship($championshipId);
        foreach($playersToChamp as $player){
            $players[$player['id']]['pca_id'] = $player['pca_id'];
            $players[$player['id']]['championship_id'] = $player['championship_id'];
        }

        return $players;
    }

    /******* SERVICE ******/
    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\PlayersZEM
     */
    private function getPlayersEm(Application $app){
        return $app['EM']->get('PlayersZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\Generated\ChampionshipsZEM
     */
    private function getChampionshipsEm(Application $app){
        return $app['EM']->get('ChampionshipsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\Generated\PlayersToChampionshipsZEM
     */
    private function getPlayersToChampionshipsEm(Application $app){
        return $app['EM']->get('PlayersToChampionshipsZEM');
    }
}