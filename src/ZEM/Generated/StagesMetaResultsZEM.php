<?php
/**
 * Zend Entity Manager ZEM StagesMetaResults
 * Auto Generate :2016-01-17 13:32:59
 * t_stages_meta_results
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\StagesMetaResults;

class StagesMetaResultsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_stages_meta_results";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "smr_id";

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
     * @return StagesMetaResults
     */
    protected function buildZEntityObject($row)
    {
        $entity = new StagesMetaResults();
        $entity->setId($row["smr_id"]);
        $entity->setResult($row["smr_result"]);
        $entity->setStageId($row["stage_id"]);
        $entity->setValue($row["smr_value"]);
        $entity->setResultId($row["result_id"]);
        $entity->setStatus($row["status"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return StagesMetaResults
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}