<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 14/03/2015
 * Time: 09:49
 */

namespace portfolio\Domain;


class Championship {

    /**
     * @var int
     */
    private $id;


    /**
     * @var string(45)
     */
    private $title;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    function __toString()
    {
        return $this->title;
    }


} // END CLASS !!!