<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 30/08/15
 * Time: 00:12
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\ChampionshipsZEM as LegacyChampionshipsZEM;
use Zend\Db\Sql\Expression;

/**
 * Class ChampionshipsZEM
 * @package portfolio\ZEM
 */
class ChampionshipsZEM extends LegacyChampionshipsZEM {

    /**
     * @param int   $championshipId
     *
     * @return array
     */
    public function getPlayersByLoungeByChampionshipId($championshipId){

        $select = $this->sql->select();
        $select->columns(array('id' => 'cha_id', 'title' => 'cha_title'));
        $select->join(array('s' => 't_stages'), 't_championships.cha_id = s.championship_id', array('stage_id' => 'sta_id'), $select::JOIN_LEFT);
        $select->join(array('l' => 't_lounges'), 'l.stage_id = s.sta_id', array('lounge_id' => 'lou_id', 'lounge_title' => 'lou_title'), $select::JOIN_LEFT);
        $select->join(array('plo' => 't_players_to_lounges'), 'plo.lounge_id = l.lou_id', array(), $select::JOIN_LEFT);
        $select->join(array('pca' => 't_players_to_championships'), 'plo.player_to_championship_id = pca.pca_id', array(), $select::JOIN_LEFT);
        $select->join(array('p' => 't_players'), 'p.pla_id = pca.player_id', array('nickname' => 'pla_nickname', 'player_id' => 'pla_id'), $select::JOIN_LEFT);
        $select->where(array('t_championships.cha_id' => $championshipId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param int   $championshipId
     *
     * @return array
     */
    public function getChampionshipsWithCountPlayersByChampionshipId($championshipId){
        $select = $this->sql->select();
        $select->columns(array('id' => 'cha_id',
                               'title' => 'cha_title',
            'countPlayers' => new Expression('COUNT(pca.player_id)')
        ));
        $select->join(array('pca' => 't_players_to_championships'), 't_championships.cha_id = pca.championship_id', array(), $select::JOIN_LEFT);
        $select->where(array('t_championships.cha_id' => $championshipId));

        return $this->selectWith($select)->current();
    }

    /**
     * @param $championshipId
     *
     * @return array
     */
    public function getChampionshipAndResultsById($championshipId){
        $select = $this->sql->select();
        $select->columns(array('id' => 'cha_id',
                               'title' => 'cha_title',
        ));
        $select->join(array('cr' => 'championships_has_results'),'t_championships.cha_id = cr.championship_id',array());
        $select->join(array('r' => 't_results'),'r.res_id = cr.result_id',array('result_id' => 'res_id', 'result_title' => 'res_title'));
        $select->where(array('t_championships.cha_id' => $championshipId));

        return $this->selectWith($select)->toArray();
    }

    /**
     * @param $championshipId
     *
     * @return array|null
     */
    public function getChampionshipToAPi($championshipId){
        $select = $this->sql->select();
        $select->columns(array('id' => 'cha_id',
                               'title' => 'cha_title',
        ));
        $select->where(array('t_championships.cha_id' => $championshipId));

        return $this->selectWith($select)->current();
    }

}