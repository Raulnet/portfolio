<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 21/08/15
 * Time: 22:14
 */

namespace portfolio\Controller;

use portfolio\Model\ChronoConverter;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use portfolio\Entity\MetaResults;
use portfolio\Model\GridsPoints;
use portfolio\Form\Type\ResultsType;
use portfolio\Model\Results;

/**
 * Class ResultsController
 * @package portfolio\Controller
 */
class ResultsController extends AbstractController {

    /**
     * @param Application $app
     * @param Request     $request
     *
     * @return string
     */
    public function createResultAction(Application $app, Request $request){

        $form = $this->getFormResults($app);
        if($this->formRequestAction($request, $this->getResultsEm($app), $form)){
            $this->getSession($app)->getFlashBag()->add('success', 'The result was successfully added !');
            $form = $this->getFormResults($app);
        }

        $results = $this->getResultsEm($app)->findAll();

        return $this->getTwig($app)->render('TheGrid/Results/add.html.twig', array(
            'form' => $form->createView(),
            'results' => $results,
        ));
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $loungeId
     *
     * @return string
     */
    public function addAction(Request $request, Application $app, $loungeId){

        $breadcrumbs = $this->getLoungesEm($app)->getBreadcrumbs($loungeId);

        $lounge = $this->getLoungesEm($app)->findOneById($loungeId);
        $players = $this->getPlayersToLoungesEm($app)->getPlayersByLounges($loungeId);
        $rounds = $this->getStagesEm($app)->getRoundsByStageId($lounge->getStageId());
        $result = $this->getStagesEm($app)->getResultsByStages($lounge->getStageId());
        $metaResults = $this->getMetaResultsEm($app)->getResultByLoungeId($loungeId);
        $grid = $this->getGridMetaResults($metaResults);

        $form = $this->getFormGrid($app, $players, $rounds, $result, $grid);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){

           $type = $result['type'];
           if($type === Results::RES_POS_TO_POINTS){
               if($this->testResultsPostion($app, $form->getData())){
                   $this->saveResult($app, $form->getData(), $result['grids_points_id']);
                   $this->getSession($app)->getFlashBag()->add('success', 'All results are successfully added !');
                   return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_results', array('loungeId' => $loungeId)));
               }
           }
           if($type === Results::RES_POINT_TO_POINT){
               $this->saveResult($app, $form->getData(), $result['grids_points_id']);
               $this->getSession($app)->getFlashBag()->add('success', 'All results are successfully added !');
               return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_results', array('loungeId' => $loungeId)));
           }
           if($type === Results::RES_TIMER || $type === Results::RES_SHORT_TIMER || $type === Results::RES_LONG_TIMER){

                   $this->saveTimerResult($app, $form->getData());
                   $this->getSession($app)->getFlashBag()->add('success', 'All results are successfully added !');
                   return $app->redirect($this->urlGenerator($app)->generate('the_grid_add_results', array('loungeId' => $loungeId)));
           }

        }

        return $this->getTwig($app)->render('TheGrid/Grids/add.html.twig', array(
            'form'      => $form->createView(),
            'lounge'    => $lounge,
            'players'   => $players,
            'rounds'    => $rounds,
            'result'   => $result,
            'grid'      => $grid,
            'breadcrumbs' => $breadcrumbs
        ));
    }

    /****** METHOD ******/
    /**
     * @param array $metaResults
     *
     * @return array
     */
    private function getGridMetaResults($metaResults = array()){

        if(empty($metaResults)){
            return $metaResults;
        }

        $grid = array();

        foreach($metaResults as $mr){

            $type = $mr['type'];


            if($type == Results::RES_POS_TO_POINTS || $type == Results::RES_POINT_TO_POINT){
                $mr['value'] = hexdec($mr['value']);
                $mr['result'] = hexdec($mr['result']);
            }

            if($type == Results::RES_TIMER || $type == Results::RES_SHORT_TIMER || $type === Results::RES_LONG_TIMER){
                $chronoConverter = new ChronoConverter();
                $mr['value'] = $chronoConverter->getStringFromMicro(hexdec($mr['value']));
                $mr['result'] = $chronoConverter->getTimerByMicroResult(hexdec($mr['result']));
            }

            $grid[$mr['id'].'_'.$mr['round_id'].'_'.$mr['result_id'].'_'.$mr['sequence']] = $mr;
        }

        return $grid;
    }

    /**
     * @param Application $app
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function getFormResults(Application $app){
        $form = $this->getFormFactory($app)->create(new ResultsType());

        return $form;
    }


    /**
     * @param Application $app
     * @param array       $grid
     *
     * @return bool
     */
    private function testResultsPostion(Application $app, array $grid){

        $results = array();
        $sumResult = array();
        $countResult = array();

        foreach($grid as $key => $result){
            $datas = explode('_', $key);
            $results[$datas[2]] = array();
            $sumResult[$datas[2]] = array('sum_result' => 0, 'count_result' => 0);
            $countResult[$datas[2]] = 0;
        }
        foreach($grid as $key => $result){
            $datas = explode('_', $key);
            if(is_int($result) && $result >0){
                // test if result exist
                if(array_key_exists($result, $results[$datas[2]])){
                    $this->getSession($app)->getFlashBag()->add('error', 'Enregistrement refusé! Des résultas en double exist !');
                    return false;
                }

                $countResult[$datas[2]]+=1;

                $results[$datas[2]][$result] = $datas[1];
                $sumResult[$datas[2]]['sum_result'] += $result;
                $sumResult[$datas[2]]['count_result'] += $countResult[$datas[2]];

            }
        }
        foreach($sumResult as $sum){
            if($sum['count_result'] != $sum['sum_result']){
                $this->getSession($app)->getFlashBag()->add('error', 'Les positions sont mal renseignés !');
                return false;
            }
        }

        return true;
    }

    /**
     * @param Application $app
     * @param array       $players
     * @param array       $result
     * @param array       $rounds
     * @param array       $grid
     *
     * @return \Symfony\Component\Form\Form
     */
    private function getFormGrid(Application $app, $players = array(), $rounds = array(), $result = array(), $grid = array()){
        $form = $this->getFormFactory($app)->createBuilder('form');

        $resultsService = New Results();
        // loop players
        foreach($players as $player){
            // loop player by rounds
            foreach($rounds as $round){

                    $metaResult = null;

                    $key = $player['id'].'_'.$round['round_id'].'_'.$result['result_id'].'_'.$result['sequence'];

                    if(array_key_exists($key, $grid)){
                        $metaResult = $this->getMetaResults($grid[$key]['result'], $result['type']);
                    }

                    $options = array(
                        'key'           => $key,
                        'label'         => $player['nickname'],
                        'metaResult'    => $metaResult,
                        );

                    if($result['type'] == Results::RES_POS_TO_POINTS){
                        $options['max'] = count($players);
                    }

                    $form = $resultsService->getForm($result['type'], $form, $options);

            }
        }

        $form->add('valider', 'submit');

        return $form->getForm();
    }



    /**
     * @param Application $app
     * @param array       $results
     * @param int         $gridPointsId
     *
     * @return bool
     */
    private function saveResult(Application $app, $results = array(), $gridPointsId = null){

        $points = ($gridPointsId == null ? null : $this->getGridPoints($gridPointsId));
        //declarer l'entity Manager avant la boucle pour initier la conneciton une fois
        //et ensuite bouclé
        //si l'instance de l'entity est dans la boucle cela initie trop de connection au serveur et fais planter la requete
        $em =  $this->getMetaResultsEm($app);
        $metaResultEm = $this->getMetaResultsEm($app);

        foreach($results as $key => $result){
            if($result !== null){
                $dataKey = explode('_', $key);
                $resultArray = $metaResultEm->find(array(
                    'player_to_lounge_id' => $dataKey[1],
                    'round_id'  => $dataKey[2],
                    'result_id' => $dataKey[3]
                ));
                $resultEntity = new MetaResults();
                if(!empty($resultArray)){
                    $resultEntity = $resultArray[0];
                }
                $resultEntity->setResult(dechex($result));
                $resultEntity->setValue(is_array($points) ? dechex($points[$result]) : dechex($result));
                $resultEntity->setPlayerToLoungeId($dataKey[1]);
                $resultEntity->setRoundId($dataKey[2]);
                $resultEntity->setResultId($dataKey[3]);

                $em->saveEntity($resultEntity->toArray());
            }
        }

        return true;
    }

    /**
     * @param Application $app
     * @param array       $results
     *
     * @return bool
     */
    private function saveTimerResult(Application $app, $results = array()){

        $em =  $this->getMetaResultsEm($app);
        $metaResultEm = $this->getMetaResultsEm($app);

        foreach($results as $key => $timer){
            if($timer !== null){
                $dataKey = explode('_', $key);
                $resultArray = $metaResultEm->find(array(
                    'player_to_lounge_id' => $dataKey[1],
                    'round_id'  => $dataKey[2],
                    'result_id' => $dataKey[3]
                ));
                $resultEntity = new MetaResults();
                if(!empty($resultArray)){
                    $resultEntity = $resultArray[0];
                }

                $resultEntity->setTimer($timer);
                $resultEntity->setValue($resultEntity->getResult());
                $resultEntity->setPlayerToLoungeId($dataKey[1]);
                $resultEntity->setRoundId($dataKey[2]);
                $resultEntity->setResultId($dataKey[3]);

                $em->saveEntity($resultEntity->toArray());
            }
        }

        return true;
    }

    /**
     * @param string    $metaResult
     * @param string    $type
     *
     * @return array|string
     */
    private function getMetaResults($metaResult, $type){

        $result = new MetaResults();
        $result->setResult($metaResult);

        if($type == Results::RES_POS_TO_POINTS || $type == Results::RES_POINT_TO_POINT){
            return $result->getResult();
        }

        if($type == Results::RES_TIMER || $type == Results::RES_SHORT_TIMER || Results::RES_LONG_TIMER){
            return $result->getTimer();
        }
    }

    /**
     * @param null $id
     *
     * @return array
     */
    private function getGridPoints($id = null){
        if($id === null){
            return array();
        }
        return GridsPoints::$arrayGrid[$id];
    }

    /****** SERVICE ******/

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
     * @return \portfolio\ZEM\ResultsZEM
     */
    private function getResultsEm(Application $app){
        return $app['EM']->get('ResultsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\PlayersToLoungesZEM
     */
    private function getPlayersToLoungesEm(Application $app){
        return $app['EM']->get('PlayersToLoungesZEM');
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
     * @return \portfolio\ZEM\MetaResultsZEM
     */
    private function getMetaResultsEm(Application $app){
        return $app['EM']->get('MetaResultsZEM');
    }
}