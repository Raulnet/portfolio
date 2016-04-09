<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 23/08/15
 * Time: 18:26
 */

namespace portfolio\ZEM;

use portfolio\ZEM\Generated\PlayersToLoungesZEM as LegacyPlayersToLoungesZEM;

class PlayersToLoungesZEM extends LegacyPlayersToLoungesZEM{

    public function getPlayersByLounges($loungeId){
        $select = $this->sql->select();

        $select->columns(array('id' => 'plo_id'));

        $select->join(array('pca'=>'t_players_to_championships'),'pca.pca_id = t_players_to_lounges.player_to_championship_id',array());

        $select->join(array('p'=>'t_players'),'p.pla_id = pca.player_id',array('nickname'=>'pla_nickname', 'player_id' => 'pla_id'));


        $select->where(array('t_players_to_lounges.lounge_id' => $loungeId));

        return $this->selectWith($select)->toArray();
    }

}