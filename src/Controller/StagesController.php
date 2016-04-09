<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 23:26
 */

namespace portfolio\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Form\Type\StagesType;
use portfolio\Entity\Generated\Stages;
use portfolio\Model\GridsPoints;

class StagesController extends AbstractController
{

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return string
     */
    public function showAction(Application $app, $id)
    {
        $stage   = $this->getStagesEM($app)->findOneById($id);
        $lounges = $this->getLoungesEM($app)->getByStage($id);
        $results = $this->getResults($app, $id);
        $rounds = $this->getRoundsEM($app)->find(array('stage_id' => $id));

        return $this->getTwig($app)->render('TheGrid/Stages/show.html.twig', array(
            'stage'   => $stage,
            'lounges' => $lounges,
            'rounds'  => $rounds,
            'results' => $results
        ));
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $championshipId
     *
     * @return string
     */
    public function addToChampionshipAction(Request $request, Application $app, $championshipId)
    {
        $championship = $this->getChampionshipsEM($app)->findOneById($championshipId);
        $em           = $this->getStagesEM($app);
        $stages = $em->find(array(
            'championship_id' => $championshipId
        ));
        // if any stage exist add stage generator formulaire
        if (empty($stages)) {
            $form = $this->getGenerateStageForm($app);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                if ($this->generateStagesHasChampionship($app, $data, $championshipId)) {
                    return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_championship', array('id' => $championshipId)));
                }

            }

            return $this->getTwig($app)->render('TheGrid/Stages/add.html.twig', array(
                'form'         => $form->createView(),
                'championship' => $championship,
                'stages'       => $stages,
            ));
        }
        $sequence = count($stages) + 1;
        // else if some stages Exist add One by One
        $stage = new Stages();
        $stage->setChampionshipId($championshipId);
        $stage->setSequence($sequence);
        $form = $this->getFormFactory($app)->create(new StagesType(), $stage->toArray());
        if ($this->formRequestAction($request, $em, $form)) {
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_championship', array('id' => $championshipId)));
        }

        return $this->getTwig($app)->render('TheGrid/Stages/add.html.twig', array(
            'form'         => $form->createView(),
            'championship' => $championship,
            'stages'       => $stages,
        ));
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $id
     *
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Application $app, $id)
    {
        $em = $this->getStagesEM($app);
        $stage        = $this->getStagesEM($app)->findOneById($id);
        $championship = $this->getChampionshipsEM($app)->findOneById($stage->getChampionshipId());
        $form         = $this->getFormFactory($app)->create(new StagesType(), $stage->toArray());
        if ($this->formRequestAction($request, $em, $form)) {
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_championship', array('id' => $stage->getChampionshipId())));
        }

        return $this->getTwig($app)->render('TheGrid/Stages/edit.html.twig', array(
            'form'         => $form->createView(),
            'championship' => $championship,
            'stage'        => $stage
        ));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Application $app, $id)
    {
        $stage = $this->getStagesEM($app)->findOneById($id);
        if ($this->getStagesEM($app)->deleteEntity($stage)) {
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_championship', array('id' => $stage->getChampionshipId())));
        }

        return $app->redirect('/the_grid/web/the_grid/championships');
    }

    /***** METHOD ******/
    /**
     * @param Application $app
     * @param int         $stageId
     *
     * @return array
     */
    private function getResults(Application $app, $stageId)
    {
        $result = $this->getStagesEM($app)->getResultsByStages($stageId);

            if ($result['grids_points_id'] != null) {
                $result['grid'] = GridsPoints::$arrayGrid[$result['grids_points_id']];
            }
            $datas[] = $result;


        return $datas;
    }

    /**
     * @param Application $app
     * @param array       $data
     * @param int         $championshipId
     *
     * @return bool
     */
    private function generateStagesHasChampionship(Application $app, $data = array(), $championshipId)
    {
        $number = $data['nbr_stage'];
        if ($number > 20 || $number < 1) {
            return false;
        }
        $title = $data['title_stage'];
        if (count($title) > 20) {
            return false;
        }
        $response = true;
        $stageId  = array();
        for ($iPos = 1; $iPos <= $number; $iPos++) {
            if ($response) {
                $stage = new Stages();
                $stage->setChampionshipId($championshipId);
                $stage->setSequence($iPos);
                $stage->setTitle($title . ' ' . $iPos);
                $this->getStagesEM($app)->insert($stage->toArray());
                $stageId[] = $this->getStagesEM($app)->getLastInsertValue();
                $response  = true;
            }
        }
        $stages = $this->getStagesEM($app)->find(array('championship_id' => $championshipId));
        foreach ($stages as $stage) {

            for ($iPos = 1; $iPos <= $data['nbr_round']; $iPos++) {
                // insert round has stages
                $this->getRoundsEM($app)->insert(array(
                    'rou_title'    => $data['title_round'] . ' ' . $iPos,
                    'stage_id'     => $stage->getId(),
                    'rou_sequence' => $iPos
                ));
            }
        }

        return $response;
    }

    /**
     * @param Application $app
     *
     * @return \Symfony\Component\Form\Form
     */
    private function getGenerateStageForm(Application $app)
    {
        $form = $this->getFormFactory($app)->createBuilder('form');
        $form->add('nbr_stage', 'integer', array(
            'label' => 'Nombre de stages :',
            'attr'  => array(
                'class' => 'form-control',
                'min'   => 0,
                'max'   => 20
            )
        ))->add('title_stage', 'text', array(
            'label' => 'Titre des stages :',
            'attr'  => array(
                'class'       => 'form-control',
                'placeholder' => 'Stage',
                'maxLength'   => 20,
                'value'       => 'Stage'
            )
        ))->add('nbr_round', 'integer', array(
            'label' => 'Nombre de rounds/stages :',
            'attr'  => array(
                'class' => 'form-control',
                'min'   => 0,
                'max'   => 10,
                'value' => 1
            )
        ))->add('title_round', 'text', array(
            'label' => 'Titre des rounds :',
            'attr'  => array(
                'class'       => 'form-control',
                'placeholder' => 'Round',
                'maxLength'   => 20,
                'value'       => 'Round'
            )
        ))->add('valider', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ));

        return $form->getForm();
    }

    /***** SERVICE *****/
    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\StagesZEM
     */
    private function getStagesEM(Application $app)
    {
        return $app['EM']->get('StagesZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\LoungesZEM
     */
    private function getLoungesEM(Application $app)
    {
        return $app['EM']->get('LoungesZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\Generated\roundsZEM
     */
    private function getRoundsEM(Application $app)
    {
        return $app['EM']->get('RoundsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\ChampionshipsZEM
     */
    private function getChampionshipsEM(Application $app)
    {
        return $app['EM']->get('ChampionshipsZEM');
    }

}