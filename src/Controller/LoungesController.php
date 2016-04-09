<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 18/08/15
 * Time: 22:09
 */

namespace portfolio\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Entity\Generated\Lounges;
use portfolio\Form\Type\LoungesType;
use portfolio\Entity\Generated\PlayersToLounges;

class LoungesController extends AbstractController {

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $id
     *
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Application $app, $id){

        $lounge = $this->getLoungesEm($app)->findOneById($id);

        $form = $this->getFormFactory($app)->create(new LoungesType(), $lounge->toArray());

        if($this->formRequestAction($request, $this->getLoungesEm($app), $form)){
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_stage', array('id' => $lounge->getStageId())));
        }
        $breadcrumb = $this->getBreadcrumb($app, $lounge->getStageId());
        $lounges = $this->getLoungesEM($app)->find(array('stage_id' => $lounge->getStageId()));

        return $this->getTwig($app)->render('TheGrid/Lounges/edit.html.twig', array(
            'form' => $form->createView(),
            'lounge' => $lounge,
            'lounges' => $lounges,
            'breadcrumb' => $breadcrumb
        ));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Application $app, $id){

        $lounge = $this->getLoungesEm($app)->findOneById($id);

        if($this->getLoungesEm($app)->deleteEntity($lounge)){

        }

        return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_stage', array('id' => $lounge->getStageId())));
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $stageId
     *
     * @return string
     */
    public function addToStageAction(Request $request, Application $app, $stageId){

        $lounge = new Lounges();
        $lounge->setStageId($stageId);


        $form = $this->getFormFactory($app)->create(new LoungesType(), $lounge->toArray());

        if($this->formRequestAction($request, $this->getLoungesEm($app), $form)){
            $this->getSession($app)->getFlashBag()->add('success', 'new lounge successfully added !');
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_lounges_to_stage', array('stageId' => $stageId)));
        }

        $breadcrumb = $this->getBreadcrumb($app, $stageId);
        $lounges = $this->getLoungesEM($app)->find(array('stage_id' => $stageId));

        return $this->getTwig($app)->render('TheGrid/Lounges/add.html.twig', array(
            'form' => $form->createView(),
            'stageId' => $stageId,
            'lounges' => $lounges,
            'breadcrumb' => $breadcrumb
        ));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return string
     */
    public function showAction(Application $app, $id){

        $lounge = $this->getLoungesEm($app)->findOneById($id);
        $players = $this->getPlayerHasLounge($app, $lounge->getStageId());

        return $this->getTwig($app)->render('TheGrid/Lounges/show.html.twig', array(
            'lounge' => $lounge,
            'players'=> $players,
        ));
    }

    /**
     * @param Application $app
     * @param int         $loungeId
     * @param int         $playerId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addPlayerToLoungeAction(Application $app, $loungeId, $playerId){

        $loungeToPlayer = new PlayersToLounges();
        $loungeToPlayer->setPlayerToChampionshipId($playerId);
        $loungeToPlayer->setLoungeId($loungeId);

        if(!$this->getPlayersToLoungesEm($app)->find($loungeToPlayer->toArray())){
            if($this->getPlayersToLoungesEm($app)->insert($loungeToPlayer->toArray())){
                $this->getSession($app)->getFlashBag()->add('success', 'Player added');
            }
        }

        return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_lounge', array('id' => $loungeId)));
    }

    /**
     * @param Application $app
     * @param int         $loungeId
     * @param int         $playerId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removePlayerToLoungeAction(Application $app, $loungeId, $playerId){

        $entity = $this->getPlayersToLoungesEm($app)->find(array(
            'plo_id' => $playerId
        ));
        $entity = current($entity);
        if($entity){
            if($this->getPlayersToLoungesEm($app)->delete($entity->toArray())){
                $this->getSession($app)->getFlashBag()->add('success', 'Player removed');
            } else {
                $this->getSession($app)->getFlashBag()->add('danger', 'Player not removed');
            }
        }
        return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_lounge', array('id' => $loungeId)));
    }

    /** ===== METHOD ===== **/

    /**
     * @param Application $app
     * @param int         $stageId
     *
     * @return \portfolio\ZEM\Generated\StagesZEM
     */
    private function getBreadcrumb(Application $app, $stageId){
        return $this->getStagesEM($app)->getBreadcrumb($stageId);
    }
    /**
     * @param Application $app
     * @param int         $stageId
     *
     * @return array
     */
    private function getPlayerHasLounge(Application $app, $stageId){

        $players = array();
        $stage = $this->getStagesEm($app)->findOneById($stageId);
        $allPlayers = $this->getPlayersEm($app)->getPlayersByChampionship($stage->getChampionshipId());

        $playersHasLounges = $this->getPlayersEm($app)->getPlayersHasStageLounge($stageId);

        foreach($allPlayers as $player){
            $players[$player['id']] = $player;
            $players[$player['id']]['loungeId'] = null;
        }

        foreach ($playersHasLounges as $player) {
            $players[$player['id']]['lounge'] = $player['loungeTitle'];
            $players[$player['id']]['loungeId'] = $player['loungeId'];
            $players[$player['id']]['plo_id'] = $player['plo_id'];
            $players[$player['id']]['pca_id'] = $player['pca_id'];
        }

        return $players;
    }



    /** ===== SERVICE ===== **/

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\LoungesZEM
     */
    private function getLoungesEm(Application $app){
        return $app['EM']->get('LoungesZEM');
    }

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
     * @return \portfolio\ZEM\StagesZEM
     */
    private function getStagesEm(Application $app){
        return $app['EM']->get('StagesZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\PlayersToLoungesZEM
     */
    private function getPlayersToLoungesEm(Application $app){
        return $app['EM']->get('PlayersToLoungesZEM');
    }

}