<?php
/**
 * Zend Entity Manager ZEM Players
 * Auto Generate :2016-01-17 13:32:59
 * t_players
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Players;

class PlayersZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_players";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "pla_id";

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
     * @return Players
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Players();
        $entity->setId($row["pla_id"]);
        $entity->setNickname($row["pla_nickname"]);
        $entity->setMail($row["pla_mail"]);
        $entity->setComment($row["pla_comment"]);
        $entity->setSupport($row["pla_support"]);
        $entity->setUserId($row["user_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Players
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}