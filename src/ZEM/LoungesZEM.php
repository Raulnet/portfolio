<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 19/08/15
 * Time: 23:04
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\LoungesZEM as LegacyLoungesZEM;
use Zend\Db\Sql\Expression;

class LoungesZEM extends LegacyLoungesZEM {

    /**
     * @param int   $loungeId
     *
     * @return array
     */
    public function getPlayersByLoungeId($loungeId){

        $select = $this->sql->select();

        $select->columns(array())
            ->join(array('plo' => 't_players_to_lounges'),'plo.lounge_id = t_lounges.lou_id', array())
            ->join(array('pca' => 't_players_to_championships'),'plo.player_to_championship_id = pca.pca_id', array())
        ->join(array('p'=>'t_player'),'p.pla_id = pca.player_id',array('nickname' => 'pla_nickname', 'id' => 'pla_id'))
        ->where(array('t_lounges.lou_id' => $loungeId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $stageId
     *
     * @return array
     */
    public function getRoundsByLoungeId($stageId){

        $select = $this->sql->select();
        $select->columns(array('lounge_id' => 'lou_id', 'lounge_title' => 'lou_title'));

        $select->where(array('t_lounges.stage_id' => $stageId));
        return $this->selectWith($select)->toArray();

    }

    /**
     * @param int   $stageId
     *
     * @return mixed
     */
    public function getByStage($stageId){
        $select = $this->sql->select();
        $select->columns(array('id' => 'lou_id',
                               'title' => 'lou_title',
            'count_players' => new Expression('COUNT(plo.plo_id)')));
        $select->join(array('plo' => 't_players_to_lounges'), 'plo.lounge_id = t_lounges.lou_id', array(), $select::JOIN_LEFT);
        $select->where(array('t_lounges.stage_id' => $stageId));
        $select->group('t_lounges.lou_id');
        $select->order('lou_id ASC');
        return $this->selectWith($select)->toArray();
    }

    /**
     * @param $loungeId
     *
     * @return array
     */
    public function getBreadcrumbs($loungeId){
        $select = $this->sql->select();
        $select->columns(array('lounge_title' => 'lou_title', 'lounge_id' => 'lou_id'));
        $select->join(array('s'=> 't_stages'), 't_lounges.stage_id = s.sta_id', array('stage_id' => 'sta_id', 'stage_title' => 'sta_title'));
        $select->join(array('c'=> 't_championships'), 'c.cha_id = s.championship_id', array('championship_id' => 'cha_id', 'championship_title' => 'cha_title'));

        $select->where(array('t_lounges.lou_id' => $loungeId));
        return $this->selectWith($select)->current();
    }

}