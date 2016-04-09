<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 22/08/15
 * Time: 14:02
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\ResultsZEM as LegacyResultsZEM;

class ResultsZEM extends LegacyResultsZEM {

    /**
     * @param $loungeId
     *
     * @return array
     */
    public function getResultToGridByLoungeId($loungeId){
        $select = $this->sql->select();
        $select->columns(array('id' => 'res_id', 'result' => 'res_value', 'player_id' => 'player_id', 'round_id' => 'round_id'));
        $select->join(array('r' => 't_rounds'),'r.rou_id = t_results.round_id',array('round_id' => 'rou_id', 'round_title' => 'rou_title', 'stage_id' => 'stage_id'), $select::JOIN_LEFT);
        $select->join(array('p' => 't_player'),'p.pla_id = t_results.player_id',array('nickname' => 'pla_nickname', 'player_id' => 'pla_id'), $select::JOIN_LEFT);
        $select->join(array('s' => 't_stages'),'r.stage_id = s.sta_id',array('stage_id' => 'sta_id', 'stage_title' => 'sta_title'), $select::JOIN_LEFT);
        $select->join(array('l' => 't_lounges'),'l.stage_id = s.sta_id',array('lounge_id' => 'lou_id', 'lounge_title' => 'lou_title'), $select::JOIN_LEFT);
        $select->where(array('l.lou_id' => $loungeId));
        return $this->selectWith($select)->toArray();
    }


    /**
     * @return array
     */
    public function findAllToForm(){
        $select = $this->sql->select();
        $select->columns(array('res_id', 'res_title' ));
        return $this->selectWith($select)->toArray();
    }

}