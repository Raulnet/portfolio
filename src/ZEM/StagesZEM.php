<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 23/08/15
 * Time: 19:16
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\StagesZEM as LegacyStagesZEM;

class StagesZEM extends LegacyStagesZEM {

    /**
     * @param int   $stageId
     *
     * @return array
     */
    public function getRoundsByStageId($stageId){

        $select = $this->sql->select();
        $select->columns(array('sta_id'));
        $select->join(array('r' => 't_rounds'),'r.stage_id = t_stages.sta_id',array('round_title' => 'rou_title', 'round_id' => 'rou_id'));
        $select->where(array('t_stages.sta_id' => $stageId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $stageId
     *
     * @return array
     */
    public function getRoundsByStageIdToApi($stageId){

        $select = $this->sql->select();
        $select->columns(array());
        $select->join(array('r' => 't_rounds'),'r.stage_id = t_stages.sta_id',array('title' => 'rou_title', 'id' => 'rou_id'));
        $select->where(array('t_stages.sta_id' => $stageId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $stageId
     *
     * @return mixed
     */
    public function getBreadcrumb($stageId){
        $select = $this->sql->select();
        $select->columns(array('stage_id' => 'sta_id', 'stage_title' => 'sta_title'));
        $select->join(array('c' => 't_championships'),'c.cha_id = t_stages.championship_id',array('championship_title' => 'cha_title', 'championship_id' => 'cha_id'));
        $select->where(array('t_stages.sta_id' => $stageId));
        return $this->selectWith($select)->current();
    }

    /**
     * @param int   $stageId
     *
     * @return array
     */
    public function getResultsByStages($stageId){
        $select = $this->sql->select();
        $select->columns(array('stage_id' => 'sta_id', 'stage_title' => 'sta_title'));
        $select->join(array('c' => 't_championships'), 'c.cha_id = t_stages.championship_id', array());
        $select->join(array('r' => 't_results'), 'r.res_id = c.result_id', array('result_id' => 'res_id','title' => 'res_title', 'type'=> 'res_type', 'sequence' => 'res_sequence', 'grids_points_id' => 'grids_points_id', 'sort' => 'res_sort'));
        $select->where(array('sta_id' => $stageId));
        return $this->selectWith($select)->current();
    }
}