<?php
/**
 * Zend Entity Manager ZEM Player
 * Auto Generate :2016-01-17 13:32:59
 * t_player
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Player;

class PlayerZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_player";

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
     * @return Player
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Player();
        $entity->setId($row["pla_id"]);
        $entity->setNickname($row["pla_nickname"]);
        $entity->setMail($row["pla_mail"]);
        $entity->setComment($row["pla_comment"]);
        $entity->setSupport($row["pla_support"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Player
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}