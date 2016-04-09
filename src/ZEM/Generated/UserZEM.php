<?php
/**
 * Zend Entity Manager ZEM User
 * Auto Generate :2016-01-17 13:32:59
 * t_user
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\User;

class UserZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_user";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "usr_id";

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
     * @return User
     */
    protected function buildZEntityObject($row)
    {
        $entity = new User();
        $entity->setId($row["usr_id"]);
        $entity->setName($row["usr_name"]);
        $entity->setPassword($row["usr_password"]);
        $entity->setSalt($row["usr_salt"]);
        $entity->setRole($row["usr_role"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return User
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}