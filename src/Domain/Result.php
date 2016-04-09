<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 17/03/2015
 * Time: 16:09
 */

namespace portfolio\Domain;

use portfolio\Model\ChronoConverter;


class Result {

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $microResult;

    /**
     * Associated Round
     *
     * @var \portfolio\Domain\Round
     */
    private $round;

    /**
     * Associated Player
     *
     * @var \portfolio\Domain\Player
     */
    private $player;

    /**
     * @var int
     */
    private $minute;

    /**
     * @var int
     */
    private $seconde;

    /**
     * @var int
     */
    private $milliseconde;

    /**
     * @var string
     */
    private $stringResult;

    /**
     * Chronoconverter
     */
    private $chronoConverter;

    /**
     *
     */
    function __construct()
    {
       $this->chronoConverter = new ChronoConverter();
    }


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
     * @return int
     */
    public function getMicroResult()
    {
        return $this->microResult;
    }

    /**
     * @param int $microResult
     */
    public function setMicroResult($microResult)
    {
        $this->microResult = (int)$microResult;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return Round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @param Round $round
     */
    public function setRound($round)
    {
        $this->round = $round;
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        if($this->minute == null){ // if minute is empty find result with Chronoconverter from microResult

            $minutes = $this->chronoConverter->getMinuteFromMicroResult($this->microResult);

            $this->setMinute($minutes);
        }

        return $this->minute;
    }

    /**
     * @param int $minute
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
    }

    /**
     * @return int
     */
    public function getSeconde(){

        if($this->seconde == null){ // if minute is empty find result with Chronoconverter from microResult

            $secondes = $this->chronoConverter->getSecondFromMicroResult($this->microResult);

            $this->setSeconde($secondes);
        }

        return $this->seconde;
    }

    /**
     * @param int $seconde
     */
    public function setSeconde($seconde)
    {
        $this->seconde = $seconde;
    }

    /**
     * @return int
     */
    public function getMilliseconde()
    {
        if($this->milliseconde == null){ // if minute is empty find result with Chronoconverter from microResult

            $milliseconde = $this->chronoConverter->getMillisecondeFromMicroResult($this->microResult);

            $this->setMilliseconde($milliseconde);
        }
        return $this->milliseconde;
    }

    /**
     * @param int $milliseconde
     */
    public function setMilliseconde($milliseconde)
    {
        $this->milliseconde = $milliseconde;
    }

    /**
     * @return string
     */
    public function getStringResult()
    {
        return $this->stringResult;
    }

    /**
     * @param string $stringResult
     */
    public function setStringResult($stringResult)
    {
        $this->stringResult = $stringResult;
    }




} // END CLASS !!!!