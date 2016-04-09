<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 14/03/2015
 * Time: 10:09
 */

namespace portfolio\Domain;


class Round {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string(45)
     */
    private  $title;

    /**
     * Associated championship
     *
     * @var \portfolio\Domain\Championship
     */
    private $championship;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Championship
     */
    public function getChampionship()
    {
        return $this->championship;
    }

    /**
     * @param Championship $championship
     */
    public function setChampionship(Championship $championship)
    {
        $this->championship = $championship;
    }

    function __toString()
    {
       return $this->title;
    }


}