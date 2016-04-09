<?php
/**
 * Zend Entity Manager ZEM Championship
 * Auto Generate :2016-01-17 13:32:59
 * t_championship
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Championship;

class ChampionshipZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_championship";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "cha_id";

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
     * @return Championship
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Championship();
        $entity->setId($row["cha_id"]);
        $entity->setTitle($row["cha_title"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Championship
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}