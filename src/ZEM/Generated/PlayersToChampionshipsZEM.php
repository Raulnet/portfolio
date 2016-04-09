<?php
/**
 * Zend Entity Manager ZEM PlayersToChampionships
 * Auto Generate :2016-01-17 13:32:59
 * t_players_to_championships
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\PlayersToChampionships;

class PlayersToChampionshipsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_players_to_championships";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "pca_id";

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
     * @return PlayersToChampionships
     */
    protected function buildZEntityObject($row)
    {
        $entity = new PlayersToChampionships();
        $entity->setId($row["pca_id"]);
        $entity->setChampionshipId($row["championship_id"]);
        $entity->setPlayerId($row["player_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return PlayersToChampionships
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}