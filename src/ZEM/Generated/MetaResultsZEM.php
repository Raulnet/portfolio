<?php
/**
 * Zend Entity Manager ZEM MetaResults
 * Auto Generate :2016-01-17 13:32:59
 * t_meta_results
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\MetaResults;

class MetaResultsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_meta_results";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "mre_id";

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
     * @return MetaResults
     */
    protected function buildZEntityObject($row)
    {
        $entity = new MetaResults();
        $entity->setId($row["mre_id"]);
        $entity->setResult($row["mre_result"]);
        $entity->setValue($row["mre_value"]);
        $entity->setResultId($row["result_id"]);
        $entity->setRoundId($row["round_id"]);
        $entity->setPlayerToLoungeId($row["player_to_lounge_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return MetaResults
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}