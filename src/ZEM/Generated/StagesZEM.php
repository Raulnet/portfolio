<?php
/**
 * Zend Entity Manager ZEM Stages
 * Auto Generate :2016-01-17 13:32:59
 * t_stages
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Stages;

class StagesZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_stages";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "sta_id";

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
     * @return Stages
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Stages();
        $entity->setId($row["sta_id"]);
        $entity->setTitle($row["sta_title"]);
        $entity->setSequence($row["sta_sequence"]);
        $entity->setChampionshipId($row["championship_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Stages
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}