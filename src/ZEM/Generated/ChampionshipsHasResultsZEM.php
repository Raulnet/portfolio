<?php
/**
 * Zend Entity Manager ZEM ChampionshipsHasResults
 * Auto Generate :2015-09-14 23:29:43
 * championships_has_results
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\ChampionshipsHasResults;

class ChampionshipsHasResultsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "championships_has_results";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "championship_id";

    /**
     * @var string $secondaryKey
     */
    protected $secondaryKey = "result_id";

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
     * @return ChampionshipsHasResults
     */
    protected function buildZEntityObject($row)
    {
        $entity = new ChampionshipsHasResults();
        $entity->setChampionshipId($row["championship_id"]);
        $entity->setResultId($row["result_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return ChampionshipsHasResults
     */
    public function findOneById($id, $id2){

        return $this->findOneEntityById($id, $id2);
    }

}