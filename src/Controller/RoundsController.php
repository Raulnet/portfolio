<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 21/08/15
 * Time: 22:13
 */

namespace portfolio\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Entity\Generated\Rounds;
use portfolio\Form\Type\RoundsType;

class RoundsController extends AbstractController {

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $stageId
     *
     * @return string
     */
    public function addToStageAction(Request $request, Application $app, $stageId){

        $round = new Rounds();
        $round->setStageId($stageId);
        $round->setSequence(1);

        $form = $this->getFormFactory($app)->create(new RoundsType(), $round->toArray());

        if($this->formRequestAction($request, $this->getRoundsEm($app), $form)){
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_round_to_stage', array('stageId' => $stageId)));
        }

        $breadcrumb = $this->getBreadcrumb($app, $round->getStageId());
        $rounds = $this->getRoundsEm($app)->find(array('stage_id' => $stageId));
        return $this->getTwig($app)->render('TheGrid/Rounds/add.html.twig', array(
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb,
            'rounds'    => $rounds
        ));
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $id
     *
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Application $app, $id){

        $round = $this->getRoundsEm($app)->findOneById($id);

        $round->setSequence(1);

        $form = $this->getFormFactory($app)->create(new RoundsType(), $round->toArray());
        if($this->formRequestAction($request, $this->getRoundsEm($app), $form)){

            return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_round_to_stage', array('stageId' => $round->getStageId())));
        }

        $breadcrumb = $this->getBreadcrumb($app, $round->getStageId());
        $rounds = $this->getRoundsEm($app)->find(array('stage_id' => $round->getStageId()));
        return $this->getTwig($app)->render('TheGrid/Rounds/edit.html.twig', array(
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb,
            'rounds'    => $rounds,
            'round'     => $round
        ));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Application $app, $id){

        $round = $this->getRoundsEM($app)->findOneById($id);

        if($this->getroundsEM($app)->deleteEntity($round)){
            $this->getSession($app)->getFlashBag('success', 'Round '.$round->getTitle().' bien supprimé !!');
        }

        return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_stage', array('id' => $round->getStageId())));
    }

    /* ***** METHOD ****** */

    /**
     * @param Application $app
     * @param int         $stageId
     *
     * @return \portfolio\ZEM\Generated\StagesZEM
     */
    private function getBreadcrumb(Application $app, $stageId){
        return $this->getStagesEM($app)->getBreadcrumb($stageId);
    }

    /****** SERVICE ******/
    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\RoundsZEM
     */
    private function getRoundsEm(Application $app){
        return $app['EM']->get('RoundsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\StagesZEM
     */
    private function getStagesEm(Application $app){
        return $app['EM']->get('StagesZEM');
    }
}