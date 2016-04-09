<?php
/**
 * Zend Entity Manager ZEM Championships
 * Auto Generate :2016-01-17 13:32:59
 * t_championships
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Championships;

class ChampionshipsZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_championships";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "cha_id";

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
     * @return Championships
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Championships();
        $entity->setId($row["cha_id"]);
        $entity->setTitle($row["cha_title"]);
        $entity->setUserId($row["user_id"]);
        $entity->setStatus($row["status"]);
        $entity->setBackgroundFile($row["cha_background_file"]);
        $entity->setStyleCss($row["cha_style_css"]);
        $entity->setResultId($row["result_id"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Championships
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}