<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 20:35
 */

namespace portfolio\Controller;

use portfolio\Form\Type\TestFormType;
use portfolio\Model\ChronoConverter;
use portfolio\Model\ExportCsv;
use portfolio\Model\GridsPoints;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Form\Type\ChampionshipsType;
use portfolio\Model\Results;

class ChampionshipsController extends AbstractController {

    /**
     * @param Application $app
     *
     * @return mixed
     */
    public function indexAction(Application $app){

        $championships = $this->getChampionshipsEM($app)->findAll();
        $players = $this->getPlayersEM($app)->findAll();

        return $this->getTwig($app)->render('TheGrid/index.html.twig', array(
            'championships' => $championships,
            'players' => $players,
        ));
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return mixed
     */
    public function addAction(Request $request, Application $app)
    {
        $em = $this->getChampionshipsEM($app);
        if($app['security.authorization_checker']->isGranted('ROLE_ORGANIZER')){

            $champForm = $this->getFormChampionships($app);

            $champForm->handleRequest($request);
            if($champForm->isValid() && $champForm->isSubmitted()){
                $champ = $champForm->getData();
                $champ['user_id'] = $app['security.token_storage']->getToken()->getUser()->getId();
                if($em->insert($champ)){
                    $app['session']->getFlashBag()->add('success', 'The champ '. $champForm->getData()['cha_title'].' was successfully created.');
                    return $app->redirect($this->urlGenerator($app)->generate('the_grid_championships'));
                }
            }
        }

        $championships = $em->findAll();

        return $app['twig']->render('TheGrid/Championships/add.html.twig', array(
            'form' => $champForm->createView(),
            'championships'   => $championships,
        ));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return string
     */
    public function showAction(Application $app, $id){
        $championship   = $this->getChampionshipsEM($app)->getChampionshipsWithCountPlayersByChampionshipId($id);
        $lounges        = $this->getPlayersByLoungesByStage($app, $id);

        $stages         = $this->getStagesEM($app)->find(array('championship_id' => $id));
        $results        = $this->getResults($app, $id);

        return $this->getTwig($app)->render('TheGrid/Championships/show.html.twig', array(
            'championship'  => $championship,
            'stages'        => $stages,
            'results'       => $results,
            'lounges'       => $lounges
        ));
    }

    /**
     * @param Request     $request
     * @param Application $app
     * @param int         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Application $app, $id){
        $em    = $this->getChampionshipsEM($app);
        $champ = $em->findOneById($id);

        $champForm = $this->getFormChampionships($app, $id, true);

        // test if use have access
        if ($this->getSuperAccess($app, $champ->getUserId())) {
            if ($this->formRequestAction($request, $em, $champForm)) {
                $app['session']->getFlashBag()->add('success', 'The championship ' . $champForm->getData()['cha_title'] . ' was successfully updated.');

                return $app->redirect($this->urlGenerator($app)->generate('the_grid_show_championship', array('id' => $id)));
            }
        }
        $championship = $em->findOneById($id);

        return $this->getTwig($app)->render('TheGrid/Championships/edit.html.twig', array(
            'form' => $champForm->createView(),
            'championship'   => $championship,
        ));
    }

    /**
     * @param Application $app
     * @param int         $champId
     * @param int         $resultId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addResultAction(Application $app, $champId, $resultId){
        $em    = $this->getChampionshipsEM($app);
        $champ = $em->findOneById($champId);
        if ($this->getSuperAccess($app, $champ->getUserId())) {
            if($this->getChampionshipsHasResultsEM($app)->insert(array(
                'result_id' => $resultId,
                'championship_id' => $champId
            ))){
                $this->getSession($app)->getFlashBag()->add('success', 'Result was successfully added !');
            }
            return $app->redirect($this->urlGenerator($app)->generate('the_grid_edit_championship', array('id' => $champId)));
        }
        return $app->redirect($this->urlGenerator($app)->generate('the_grid'));
    }

    /**
     * @param Application $app
     * @param int         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Application $app, $id) {
        $champ = $this->getChampionshipsEM($app)->findOneById($id);

        if ($this->getSuperAccess($app, $champ->getUserId())) {

            if($champ){
                $this->getChampionshipsEM($app)->deleteEntity($champ);
                $this->getSession($app)->getFlashBag()->add('success', 'The champ '.$champ->getTitle().' was succesfully removed.');
            }
        }

        return $app->redirect($this->urlGenerator($app)->generate('the_grid'));
    }

    /**
     * @param Application $app
     * @param int         $champId
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportCsvAction(Application $app, $champId){

        $data = $this->getResults($app, $champId);
        $championship = $this->getChampionshipsEM($app)->findOneById($champId);

        $exportCsv = new ExportCsv();

        $csv = $exportCsv->getChampionshipDataCsv($data, $championship->toArray());

        $title = $this->getTitleFileCsv($championship->toArray());

        $stream = function () use ($csv) {
            echo $csv;
        };

        return $app->stream(
            $stream, 200, array(
                'Content-Disposition' => 'attachment;filename="' . $title. '.csv' . '"',
                'Content-Type'        => 'text/xml',
            )
        );

    }




    /** ****** AJAX ****** */
    /**
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function findGridPointsAction(Application $app, Request $request){
        return $app->json(GridsPoints::$arrayGrid[$request->get(('gridId'))]);
    }


    /* ***************************************** METHOD ***************************************** */
    /**
     * @param array $championship
     *
     * @return string
     */
    private function getTitleFileCsv(array $championship){

        $now = new \DateTime();
        $champ = str_replace(' ', '_',$championship['cha_title']);
        $champ = strtr(
            $champ,
            '@ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ ',
            'aAAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy_'
        );

        return 'file'.$now->format('Ymdhis').$champ;
    }

    /**
     * @param Application $app
     * @param null        $championshipId
     * @param bool        $edit
     * @     *
     * @return \Symfony\Component\Form\Form
     */
    private function getFormChampionships(Application $app, $championshipId = null, $edit = false){
        if($championshipId){
            $results = $this->getResultsToForm($app);
            $champ = $this->getChampionshipsEM($app)->findOneById($championshipId);
            return $this->getFormFactory($app)->create(new ChampionshipsType($edit, $results), $champ->toArray());
        }

        return $this->getFormFactory($app)->create(new ChampionshipsType($edit));
    }

    /**
     * @param Application $app
     *
     * @return array
     */
    private function getResultsToForm(Application $app){
        $results = array();
        $row = $this->getResultsEM($app)->findAllToForm();
        foreach($row as $result){
            $results[$result['res_id']] = $result['res_title'];
        }
        return $results;
    }

    /**
     * @param Application $app
     * @param int         $championshipId
     *
     * @return array
     */
    private function getResults(Application $app, $championshipId){
        $results = array();
        $results['general'] = $this->getGeneralResults($app, $championshipId);

        $stages = $this->getStagesEM($app)->find(array('championship_id' => $championshipId));



        foreach($stages as $stage){
            $results[$stage->getId()] = $this->getResultsByStage($app, $stage->getId());
        }

        return $results;
    }

    /**
     * @param Application $app
     * @param int         $championshipId
     *
     * @return mixed
     */
    private function getGeneralResults(Application $app, $championshipId){

        $results = array();


        $metaResults = $this->getMetaResultsEM($app)->getGeneralResultsByChampionshipId($championshipId);
        $sort = 'DESC';

        foreach($metaResults as $mr){

            //find Sort Asc or desc
            $sort = $mr['sort'];
            //converte HexaResult to Number
            $mr['result'] = hexdec($mr['result']);
            $mr['value'] = hexdec($mr['value']);
            $mr['key'] = $mr['value'];
            $mr['status'] = true;

            if($mr['result'] == 0){
                $mr['key'] += 5959999;
                $mr['status'] = false;
            }
            if(array_key_exists($mr['player_id'], $results)){
                $results[$mr['player_id']]['value'] += $mr['value'];
                $results[$mr['player_id']]['key'] += $mr['key'];

                if($mr['status'] != $results[$mr['player_id']]['status']){

                    $results[$mr['player_id']]['status'] = false;
                }

            } else {
                $results[$mr['player_id']] = $mr;
            }

        }
    return $this->rankResult($results, $sort);
    }

    /**
     * @param array $listResults
     * @param int   $order
     *
     * @return array|bool
     */
    private function rankResult(array $listResults, $order){
        $results = array();

        $chronoConverter = new ChronoConverter();

        foreach($listResults as $key => $result){

            $type = $result['type'];
            if($type === Results::RES_POS_TO_POINTS || $type === Results::RES_POINT_TO_POINT){
                $key = $result['key'].$key;
                $results[$key] = $result;
            }

            if($type === Results::RES_TIMER || $type === Results::RES_SHORT_TIMER || $type ===  Results::RES_LONG_TIMER){
                $key = $result['key'].$key;
                $result['result'] = $chronoConverter->getStringFromMicro($result['result']);
                $result['value'] = $chronoConverter->getStringFromMicro($result['value']);
                $results[$key] = $result;
            }
        }

        if($order === 'ASC'){
            ksort($results);
            return $results;
        }
        if($order === 'DESC'){

            krsort($results);
            return $results;
        }

        return array();
    }

    /**
     * @param Application $app
     * @param int         $stageId
     *
     * @return ChampionshipsController
     */
    private function getResultsByStage(Application $app, $stageId){

        $results = array();

        $metaResults = $this->getMetaResultsEM($app)->getResultsByStages($stageId);

        $sort = 'DESC';

        foreach($metaResults as $mr){

            //find Sort Asc or desc
            $sort = $mr['sort'];
            //converte HexaResult to Number
            $mr['result'] = hexdec($mr['result']);
            $mr['value'] = hexdec($mr['value']);
            $mr['key'] = $mr['value'];
            $mr['status'] = true;

            if($mr['result'] == 0){
                $mr['key'] += 5959999;
                $mr['status'] = false;
            }
            if(array_key_exists($mr['player_id'], $results)){
                $results[$mr['player_id']]['value'] += $mr['value'];
                $results[$mr['player_id']]['key'] += $mr['key'];
                if($mr['status'] != $results[$mr['player_id']]['status']){
                    $results[$mr['player_id']]['status'] = false;
                }

            } else {
                $results[$mr['player_id']] = $mr;
            }

        }

        return $this->rankResult($results, $sort);
    }

    /**
     * @param Application $app
     * @param int         $championshipId
     *
     * @return array
     */
    private function getPlayersByLoungesByStage(Application $app, $championshipId){

        $datas = $this->getChampionshipsEM($app)->getPlayersByLoungeByChampionshipId($championshipId);
        $lounges = array();
        foreach($datas as $data){
            if($data['lounge_id'] !== null){
                $lounges[$data['stage_id']][$data['lounge_id']]['title'] = $data['lounge_title'];
                $lounges[$data['stage_id']][$data['lounge_id']]['players'][] = array(
                    'player_id'=> $data['player_id'],
                    'nickname' => $data['nickname']
                );
            }
        }
        return $lounges;
    }

    /* ***************************************** SERVICE ***************************************** */
    /**
     * @param $app
     *
     * @return \portfolio\ZEM\ChampionshipsZEM
     */
    private function getChampionshipsEM($app){

        return $app['EM']->get('ChampionshipsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\Generated\StagesZEM
     */
    private function getStagesEM(Application $app){
        return $app['EM']->get('StagesZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\MetaResultsZEM
     */
    private function getMetaResultsEM(Application $app){
        return $app['EM']->get('MetaResultsZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\Generated\PlayersZEM
     */
    private function getPlayersEM(Application $app){

        return $app['EM']->get('PlayersZEM');
    }

    /**
     * @param Application $app
     *
     * @return \portfolio\ZEM\ResultsZEM
     */
    private function getResultsEM(Application $app){

        return $app['EM']->get('ResultsZEM');
    }

}