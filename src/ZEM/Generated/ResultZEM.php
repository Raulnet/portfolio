<?php
/**
 * Zend Entity Manager ZEM Result
 * Auto Generate :2016-01-17 13:32:59
 * t_result
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Result;

class ResultZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_result";

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
     * @return Result
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Result();
        $entity->setId($row["res_id"]);
        $entity->setMicroResult($row["res_micro_result"]);
        $entity->setId($row["rou_id"]);
        $entity->setId($row["pla_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Result
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}