<?php
/**
 * Zend Entity Manager ZEM ResultsHasStages
 * Auto Generate :2015-09-14 23:29:43
 * results_has_stages
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\ResultsHasStages;

class ResultsHasStagesZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "results_has_stages";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "result_id";

    /**
     * @var string $secondaryKey
     */
    protected $secondaryKey = "stages_id";

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
     * @return ResultsHasStages
     */
    protected function buildZEntityObject($row)
    {
        $entity = new ResultsHasStages();
        $entity->setResultId($row["result_id"]);
        $entity->setStagesId($row["stages_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return ResultsHasStages
     */
    public function findOneById($id, $id2){

        return $this->findOneEntityById($id, $id2);
    }

}