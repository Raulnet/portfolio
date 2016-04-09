<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 12/09/15
 * Time: 22:04
 */
namespace portfolio\Entity;

use portfolio\Entity\Generated\MetaResults as LegacyMetaResults;
use portfolio\Model\ChronoConverter;

class MetaResults extends LegacyMetaResults{

    /**
     * @var int
     */
    private $days = 0;

    /**
     * @var int
     */
    private $hours = 0;

    /**
     * @var int
     */
    private $minutes = 0;

    /**
     * @var int
     */
    private $seconds = 0;

    /**
     * @var int
     */
    private $milliseconds = 0;

    /**
     * @var string
     */
    protected $result = '';

    /**
     * @var string
     */
    protected $value = '';

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return int
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * @param int $hours
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
    }

    /**
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @param int $minutes
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param int $seconds
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * @return int
     */
    public function getMilliseconds()
    {
        return $this->milliseconds;
    }

    /**
     * @param int $milliseconds
     */
    public function setMilliseconds($milliseconds)
    {
        $this->milliseconds = $milliseconds;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getTimer(){

        $chronoConverter = new ChronoConverter();

        if($this->result !== ''){

            $timer = $this->result;

            if(!is_array($this->result)){
                $microResult = hexdec($this->result);

                $timer = $chronoConverter->getTimerByMicroResult($microResult);
            }

            $this->days         = 0; //TODO RAJOUTER LE CALCUL DES JOURS
            $this->hours        = $timer['hours'];
            $this->minutes      = $timer['minutes'];
            $this->seconds      = $timer['seconds'];
            $this->milliseconds = $timer['milliseconds'];
        }

        return array(
                'days'          => $this->days,
                'hours'         => $this->hours,
                'minutes'       => $this->minutes,
                'seconds'       => $this->seconds,
                'milliseconds'  => $this->milliseconds,
        );
    }

    /**
     * @param array $timer
     *
     * @return $this
     */
    public function setTimer($timer = array()){

            $this->days         = (array_key_exists('days', $timer)? $timer['days']: 0);
            $this->hours        = (array_key_exists('hours', $timer)? $timer['hours']: 0);
            $this->minutes      = (array_key_exists('minutes', $timer)? $timer['minutes']: 0);
            $this->seconds      = (array_key_exists('seconds', $timer)? $timer['seconds']: 0);
            $this->milliseconds = (array_key_exists('milliseconds', $timer)? $timer['milliseconds']: 0);

            $chronoConverter = new ChronoConverter();

            $this->result = dechex($chronoConverter->getMicroFromData($this->hours, $this->minutes, $this->seconds, $this->milliseconds));

        return $this;
    }


}