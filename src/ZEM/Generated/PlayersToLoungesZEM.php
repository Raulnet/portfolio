<?php
/**
 * Zend Entity Manager ZEM PlayersToLounges
 * Auto Generate :2016-01-17 13:32:59
 * t_players_to_lounges
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\PlayersToLounges;

class PlayersToLoungesZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_players_to_lounges";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "plo_id";

    /**
     * @param $configArray
     * @param Application $app
     */
    function __construct($configArray, $app)
    {
        parent::__construct($configArray, $app);
    }

    /**
     * @param $row
     * @return PlayersToLounges
     */
    protected function buildZEntityObject($row)
    {
        $entity = new PlayersToLounges();
        $entity->setId($row["plo_id"]);
        $entity->setPlayerToChampionshipId($row["player_to_championship_id"]);
        $entity->setLoungeId($row["lounge_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return PlayersToLounges
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}