<?php
/**
 * Zend Entity Manager ZEM Results
 * Auto Generate :2016-01-17 13:32:59
 * t_results
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Results;

class ResultsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_results";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "res_id";

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
     * @return Results
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Results();
        $entity->setId($row["res_id"]);
        $entity->setTitle($row["res_title"]);
        $entity->setType($row["res_type"]);
        $entity->setSequence($row["res_sequence"]);
        $entity->setGridsPointsId($row["grids_points_id"]);
        $entity->setSort($row["res_sort"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Results
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}