<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 17:47
 */

namespace portfolio\Controller;

use Silex\Application;
use portfolio\Model\Results;
use portfolio\Model\ChronoConverter;

class ApiController extends AbstractController {

    public function articlesAction(Application $app){

        $articles = $app['dao.article']->findAll();

        $responseData = array();
        foreach ($articles as $article) {
            $responseData[] = array(
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent()
            );
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }

    public function articleByIdAction(Application $app, $id){

        $article = $app['dao.article']->find($id);
        // Convert an object ($article) into an associative array ($responseData)
        $responseData = array(
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        );
        // Create and return a JSON response
        return $app->json($responseData);
    }

    public function playersAction(Application $app) {

        $players = $app['dao.player']->findAll();

        $responseData = array();
        foreach ($players as $player) {
            $responseData[] = array(
                'id' => $player->getId(),
                'nickname' => $player->getNickname(),
                'email' => $player->getEmail()
            );
        }
        // Create and return a JSON response
        return $app->json($responseData);

    }

    public function apiRaulnetAction(Application $app){

        $responseData = json_decode(file_get_contents('http://rolnet.fr/api/articles'));

        return $app->json($responseData);
    }


    /**
     * @param Application $app
     * @param int         $championshipId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function championshipAction(Application $app, $championshipId){
        $championship = $this->getChampionshipsEM($app)->getChampionshipToAPi($championshipId);
        $players = $this->getPlayersEM($app)->getPlayersByChampionshipToApi($championshipId);
        $stages = $this->getStagesEM($app)->find(array('championship_id' => $championshipId));
        $lounges = $this->getPlayersByLoungesByStage($app, $championshipId);


        $response = array(
            'championship' => $championship,
            'list_players' => $players,
            'list_stages'  => $this->getStages($app, $stages, $lounges),
        );
        return $app->json($response);
    }

    /* ***************************************************************************** */


    private function getStages(Application $app, array $stages, array $lounges){
        $data = array();
        foreach($stages as $stage){
            $rounds = $this->getStagesEM($app)->getRoundsByStageIdtoApi($stage->getId());

            $data[$stage->getId()] = array(
                'id'    => $stage->getId(),
                'title' => $stage->getTitle(),
                'rounds' => $rounds,
                'lounges' => (array_key_exists($stage->getId(), $lounges)? $lounges[$stage->getId()] : array()),
                'results' => $this->getResultsByStage($app, $stage->getId()),
            );
        }

        return $data;
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
                    'nickname' => $data['nickname']
                );
            }
        }
        return $lounges;
    }

    /**
     * @param Application $app
     * @param int         $stageId
     *
     * @return ChampionshipsController
     */
    private function getResultsByStage(Application $app, $stageId){

        $results = array();

        $metaResults = $this->getMetaResultsEM($app)->getResultsByStagesToApi($stageId);

        $sort = 'DESC';

        foreach($metaResults as $mr){
            //find Sort Asc or desc
            $sort = $mr['sort'];
            //converte HexaResult to Number
            $mr['result'] = hexdec($mr['result']);
            $mr['value'] = hexdec($mr['value']);

            if(array_key_exists($mr['player_id'], $results)){
                $results[$mr['player_id']]['value'] += $mr['value'];
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
                unset($result['sort']);
                unset($result['type']);
                unset($result['player_id']);
                $results[$result['value'].'_'.$key] = $result;
            }

            if($type === Results::RES_TIMER || $type === Results::RES_SHORT_TIMER || $type ===  Results::RES_LONG_TIMER){
                $key = $result['value'].'_'.$key;
                $result['result'] = $chronoConverter->getStringFromMicro($result['result']);
                $result['value'] = $chronoConverter->getStringFromMicro($result['value']);
                unset($result['sort']);
                unset($result['type']);
                unset($result['player_id']);
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
    /* ***************************************************************************** */

    /** ========== SERVICE ========= **/
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
     * @return \portfolio\ZEM\StagesZEM
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
     * @return \portfolio\ZEM\PlayersZEM
     */
    private function getPlayersEM(Application $app){

        return $app['EM']->get('PlayersZEM');
    }



}