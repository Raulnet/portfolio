<?php
/**
 * Zend Entity Manager ZEM Coefficients
 * Auto Generate :2016-01-17 13:32:59
 * t_coefficients
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Coefficients;

class CoefficientsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_coefficients";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "coe_id";

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
     * @return Coefficients
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Coefficients();
        $entity->setId($row["coe_id"]);
        $entity->setType($row["coe_type"]);
        $entity->setValue($row["coe_value"]);
        $entity->setGridPointsId($row["grid_points_id"]);
        $entity->setResultId($row["result_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Coefficients
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}