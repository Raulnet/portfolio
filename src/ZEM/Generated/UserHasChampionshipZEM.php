<?php
/**
 * Zend Entity Manager ZEM UserHasChampionship
 * Auto Generate :2016-01-17 13:32:59
 * user_has_championship
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\UserHasChampionship;

class UserHasChampionshipZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "user_has_championship";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "user_id";

    /**
     * @var string $secondaryKey
     */
    protected $secondaryKey = "championship_id";

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
     * @return UserHasChampionship
     */
    protected function buildZEntityObject($row)
    {
        $entity = new UserHasChampionship();
        $entity->setUserId($row["user_id"]);
        $entity->setChampionshipId($row["championship_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return UserHasChampionship
     */
    public function findOneById($id, $id2){

        return $this->findOneEntityById($id, $id2);
    }

}