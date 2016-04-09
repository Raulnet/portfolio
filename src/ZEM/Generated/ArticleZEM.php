<?php
/**
 * Zend Entity Manager ZEM Article
 * Auto Generate :2016-01-17 13:32:59
 * t_article
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Article;

class ArticleZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_article";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "art_id";

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
     * @return Article
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Article();
        $entity->setId($row["art_id"]);
        $entity->setTitle($row["art_title"]);
        $entity->setContent($row["art_content"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Article
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}