<?php
/**
 * Zend Entity Manager ZEM Comment
 * Auto Generate :2016-01-17 13:32:59
 * t_comment
 */
namespace portfolio\ZEM\Generated;

use portfolio\Entity\Generated\Comment;

class CommentZEM extends ZEM {

    /**
     * @var string table Entity
     */
    protected $table = "t_comment";

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = "com_id";

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
     * @return Comment
     */
    protected function buildZEntityObject($row)
    {
        $entity = new Comment();
        $entity->setId($row["com_id"]);
        $entity->setContent($row["com_content"]);
        $entity->setCodemovie($row["com_codeMovie"]);
        $entity->setId($row["art_id"]);
        $entity->setId($row["usr_id"]);
        $entity->setDatetime($row["com_dateTime"]);
        return $entity;
    }

    /**
     * @param int        $id primaryKey
     * @param null|int   $id2 secondaryKey
     * 
     * @return Comment
     */
    public function findOneById($id, $id2 = null){

        return $this->findOneEntityById($id, $id2 = null);
    }

}