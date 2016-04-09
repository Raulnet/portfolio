<?php
/**
 * Zend Entity Manager ZEM Lounges
 * Auto Generate :2016-01-17 13:32:59
 * t_lounges
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Lounges;

class LoungesZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_lounges";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "lou_id";

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
     * @return Lounges
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Lounges();
        $entity->setId($row["lou_id"]);
        $entity->setTitle($row["lou_title"]);
        $entity->setStageId($row["stage_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Lounges
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}