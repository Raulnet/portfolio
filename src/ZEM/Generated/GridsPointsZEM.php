<?php
/**
 * Zend Entity Manager ZEM GridsPoints
 * Auto Generate :2016-01-17 13:32:59
 * t_grids_points
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\GridsPoints;

class GridsPointsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_grids_points";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "gpo_id";

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
     * @return GridsPoints
     */
    protected function buildZEntityObject($row)
    {
        $entity = new GridsPoints();
        $entity->setId($row["gpo_id"]);
        $entity->setTitle($row["gpo_title"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return GridsPoints
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}