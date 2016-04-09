<?php
/**
 * Zend Entity Manager ZEM Round
 * Auto Generate :2016-01-17 13:32:59
 * t_round
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Round;

class RoundZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_round";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "rou_id";

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
     * @return Round
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Round();
        $entity->setId($row["rou_id"]);
        $entity->setTitle($row["rou_title"]);
        $entity->setChampionshipId($row["rou_championship_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Round
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}