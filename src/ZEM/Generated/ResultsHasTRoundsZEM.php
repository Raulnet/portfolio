<?php
/**
 * Zend Entity Manager ZEM ResultsHasTRounds
 * Auto Generate :2015-09-01 23:02:22
 * t_results_has_t_rounds
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\ResultsHasTRounds;

class ResultsHasTRoundsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_results_has_t_rounds";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "result_id";

    /**
     * @var string $secondaryKey
     */
    protected $secondaryKey = "round_id";

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
     * @return ResultsHasTRounds
     */
    protected function buildZEntityObject($row)
    {
        $entity = new ResultsHasTRounds();
        $entity->setResultId($row["result_id"]);
        $entity->setRoundId($row["round_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return ResultsHasTRounds
     */
    public function findOneById($id, $id2){

        return $this->findOneEntityById($id, $id2);
    }

}