<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 23/08/15
 * Time: 17:48
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\MetaResultsZEM as LegacyMetaResultsZEM;
use Zend\Db\Sql\Expression;
use portfolio\Entity\MetaResults;

class MetaResultsZEM extends LegacyMetaResultsZEM {

    /**
     * @param $row
     * @return MetaResults
     */
    protected function buildZEntityObject($row)
    {
        $entity = new MetaResults();
        $entity->setId($row["mre_id"]);
        $entity->setResult($row["mre_result"]);
        $entity->setValue($row["mre_value"]);
        $entity->setResultId($row["result_id"]);
        $entity->setRoundId($row["round_id"]);
        $entity->setPlayerToLoungeId($row["player_to_lounge_id"]);
        return $entity;
    }

    public function getResultByLoungeId($loungeId){

        $select = $this->sql->select();
        $select->columns(array('result' => 'mre_result', 'value' => 'mre_value', 'id' => 'player_to_lounge_id', 'result_id' => 'result_id'));
        $select->join(array('rt' => 't_results'), 'rt.res_id = t_meta_results.result_id', array('type' => 'res_type', 'sequence' => 'res_sequence'));
        $select->join(array('plo'=>'t_players_to_lounges'),'t_meta_results.player_to_lounge_id = plo.plo_id',array(), $select::JOIN_LEFT);
        $select->join(array('pch'=>'t_players_to_championships'),'pch.pca_id = plo.player_to_championship_id',array(), $select::JOIN_LEFT);
        $select->join(array('p'=>'t_players'),'p.pla_id = pch.player_id',array('nickname' => 'pla_nickname', 'player_id' => 'pla_id'), $select::JOIN_LEFT);

        $select->join(array('r'=> 't_rounds'), 'r.rou_id = t_meta_results.round_id', array('round_id' => 'rou_id', 'round_title' => 'rou_title'));

        $select->where(array('plo.lounge_id' => $loungeId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param $championshipId
     *
     * @return mixed
     */
    public function getGeneralResultsByChampionshipId($championshipId){
        $select = $this->sql->select();
        $select->columns(array('result' => 'mre_result', 'value' => 'mre_value', 'id' => 'player_to_lounge_id', 'result_id' => 'result_id'));
        $select->join(array('rt' => 't_results'), 'rt.res_id = t_meta_results.result_id', array('type' => 'res_type', 'sequence' => 'res_sequence', 'sort' => 'res_sort'));
        $select->join(array('plo' => 't_players_to_lounges'), 'plo.plo_id = t_meta_results.player_to_lounge_id', array());
        $select->join(array('pca' => 't_players_to_championships'), 'pca.pca_id = plo.player_to_championship_id', array('player_id' => 'player_id'), $select::JOIN_LEFT);
        $select->join(array('p' => 't_players'), 'p.pla_id = pca.player_id', array('nickname' => 'pla_nickname'), $select::JOIN_LEFT);
        $select->join(array('l' => 't_lounges'), 'l.lou_id = plo.lounge_id', array());
        $select->join(array('s' => 't_stages'), 's.sta_id = l.stage_id', array('sta_id'));
        $select->join(array('c' => 't_championships'), 'c.cha_id = s.championship_id', array());
        $select->where(array('c.cha_id' => $championshipId));
        $select->order('result DESC');

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param $stageId
     *
     * @return array
     */
    public function getResultsByStages($stageId){
        $select = $this->sql->select();
        $select->columns(array('result' => 'mre_result', 'value' => 'mre_value', 'id' => 'player_to_lounge_id', 'result_id' => 'result_id'));
        $select->join(array('rt' => 't_results'), 'rt.res_id = t_meta_results.result_id', array('type' => 'res_type', 'sequence' => 'res_sequence', 'sort' => 'res_sort'));
        $select->join(array('plo' => 't_players_to_lounges'), 'plo.plo_id = t_meta_results.player_to_lounge_id', array());
        $select->join(array('pca' => 't_players_to_championships'), 'pca.pca_id = plo.player_to_championship_id', array('player_id' => 'player_id'), $select::JOIN_LEFT);
        $select->join(array('p' => 't_players'), 'p.pla_id = pca.player_id', array('nickname' => 'pla_nickname'), $select::JOIN_LEFT);
        $select->join(array('l' => 't_lounges'), 'l.lou_id = plo.lounge_id', array('lounge_title' => 'lou_title'));
        $select->join(array('s' => 't_stages'), 's.sta_id = l.stage_id', array('stage_title' => 'sta_title'));
        $select->where(array('s.sta_id' => $stageId));
        $select->order('result DESC');

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param $stageId
     *
     * @return array
     */
    public function getResultsByStagesToApi($stageId){
        $select = $this->sql->select();
        $select->columns(array('result' => 'mre_result', 'value' => 'mre_value'));
        $select->join(array('rt' => 't_results'), 'rt.res_id = t_meta_results.result_id', array('type' => 'res_type', 'sort' => 'res_sort'));
        $select->join(array('plo' => 't_players_to_lounges'), 'plo.plo_id = t_meta_results.player_to_lounge_id', array());
        $select->join(array('pca' => 't_players_to_championships'), 'pca.pca_id = plo.player_to_championship_id', array('player_id' => 'player_id'), $select::JOIN_LEFT);
        $select->join(array('p' => 't_players'), 'p.pla_id = pca.player_id', array('nickname' => 'pla_nickname'), $select::JOIN_LEFT);
        $select->join(array('l' => 't_lounges'), 'l.lou_id = plo.lounge_id', array());
        $select->join(array('s' => 't_stages'), 's.sta_id = l.stage_id', array());
        $select->where(array('s.sta_id' => $stageId));
        $select->order('result DESC');

        return $this->selectWith($select)->toArray();
    }
}