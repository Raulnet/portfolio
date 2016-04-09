<?php
/**
 * Zend Entity Manager ZEM Rounds
 * Auto Generate :2016-01-17 13:32:59
 * t_rounds
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Rounds;

class RoundsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_rounds";

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
     * @return Rounds
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Rounds();
        $entity->setId($row["rou_id"]);
        $entity->setTitle($row["rou_title"]);
        $entity->setSequence($row["rou_sequence"]);
        $entity->setStageId($row["stage_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Rounds
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}