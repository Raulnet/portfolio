<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 20/08/15
 * Time: 21:47
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\PlayersZEM as LegacyPlayersZEM;
use Zend\Db\Sql\Predicate\Expression;

class PlayersZEM extends LegacyPlayersZEM{

    /**
     * @param int   $stageId
     *
     * @return array
     */
    public function getPlayersHasStageLounge($stageId){
        $select = $this->sql->select();
        $select->columns(array('nickname' => 'pla_nickname', 'id' => 'pla_id'));
        $select->join(array('pca' => 't_players_to_championships'), 'pca.player_id = t_players.pla_id', array('pca_id' => 'pca_id'), $select::JOIN_LEFT);
        $select->join(array('plo' => 't_players_to_lounges'), 'plo.player_to_championship_id = pca.pca_id', array('plo_id' => 'plo_id'), $select::JOIN_LEFT);
        $select->join(array('l' => 't_lounges'), 'plo.lounge_id = l.lou_id', array('loungeId' => 'lou_id', 'loungeTitle' => 'lou_title'), $select::JOIN_LEFT);
        $select->join(array('s' => 't_stages'), 's.sta_id = l.stage_id', array(), $select::JOIN_LEFT);

        $select->where(array('s.sta_id' => $stageId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $championshipId
     *
     * @return array
     */
    public function getAllPlayersAndChampionship($championshipId){
        $select = $this->sql->select();

        $select->columns(array(
            'nickname' => 'pla_nickname',
            'id' => 'pla_id',
            'championship_id' =>
            new Expression('IF(pca.championship_id ='.$championshipId.', pca.championship_id, NULL)')));
        $select->join(array('pca' => 't_players_to_championships'),'pca.player_id = t_players.pla_id',array(), $select::JOIN_LEFT);
        $select->where(array('pca.championship_id' => $championshipId));
        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $championshipId
     *
     * @return array
     */
    public function getPlayersByChampionship($championshipId){
        $select = $this->sql->select();

        $select->columns(array(
            'pla_nickname' => 'pla_nickname',
            'id' => 'pla_id'));

        $select->join(array('pca' => 't_players_to_championships'),'pca.player_id = t_players.pla_id',array('pca_id' => 'pca_id', 'championship_id' => 'championship_id'));
        $select->where(array('pca.championship_id' => $championshipId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $championshipId
     *
     * @return array
     */
    public function getPlayersByChampionshipToApi($championshipId){
        $select = $this->sql->select();

        $select->columns(array(
            'pla_nickname' => 'pla_nickname'));

        $select->join(array('pca' => 't_players_to_championships'),'pca.player_id = t_players.pla_id',array());
        $select->where(array('pca.championship_id' => $championshipId));

        return $this->selectWith($select)->toArray();
    }

}