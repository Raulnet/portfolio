<?php
/**
 * Created by PhpStorm.
 * User: laurent
 * Date: 19/03/15
 * Time: 20:29
 */

/**
 * class convert microChrono to string or string to microChrono
 */

namespace portfolio\Model;


class ChronoConverter
{
    /**
     *
     * PHPunit test !!!
     *
     * @param $data
     * @return mixed
     */
    public function getVar($data){

        return $data;
    }

    /**
     * @param $string
     * @return int
     */
    public function getMicroFromString($string)
    {
        // TODO FAIRE LE PARSING DE LA STRING VER MICRO
        // TODO PARSER LES DONNEES POUR RECUPERER HEURE MINUTE SECONDE MILLI

        $hr = 0;
        $min = 0;
        $sc = 0;
        $milli = 0;

        $micro = $this->getMicroFromData($hr, $min, $sc, $milli);

        return $micro;
    }

    /**
     * Convert microChrono to String ex:3500 = 3,500 sc
     * @param $microChrono
     * @return null|string
     */
    public function getStringFromMicro($microChrono)
    {

        $strChrono = null;
        (int)$microChrono; //Force to int (db conflict!!)

        if($microChrono != null && is_int($microChrono)) { //test microChrono

            $milli = $microChrono - (floor($microChrono / 1000) * 1000); // isol milli
            $microChrono = $microChrono - $milli; // sub milli
            $hr = floor($microChrono / 3600000); // isol hours
            $microChrono = $microChrono - ($hr * 3600000); // sub hours
            $min = floor($microChrono / 60000);// isol minutes
            $microChrono = $microChrono - ($min * 60000); // sub minutes
            $sc = $microChrono / 1000; //find last seconde :)
            //concatene int to string
            //test if 0 is needed ex:01hours = 1hours
            if ($min < 10 && $hr > 0) {
                $min = '0' . $min;
            }
            if ($sc < 10) {
                $sc = '0' . $sc;
            }
            if ($milli < 10 && $milli < 100) {
                $milli = '00' . $milli;
            } elseif ($milli < 100 && $milli > 10) {
                $milli = '0' . $milli;
            }
            if ($hr > 0) { // test if hours is needed ex: 0hours25min = 25min allown
                $strChrono = $hr . ':';
            }
            $strChrono = $strChrono . $min . ':' . $sc . ',' . $milli;
        }

        return $strChrono;
    }

    /**
     * convert data to millisecond
     *
     * @param $hr = hours max 23 min 0
     * @param $min = minutes max 59
     * @param $sc = seconds max 59
     * @param $mil = milliseconds max 999
     * @return int
     */
    public function getMicroFromData($hr = 0, $min = 0, $sc = 0, $mil = 0)
    {
        // test Millisecond
        if ((int)$mil > 999 || (int)$mil < 0) {
            (int)$mil = 999;
        }
        // test Seconde
        if ((int)$sc > 59 || (int)$sc < 0) {
            (int)$sc = 59;
        }
        // test Minute
        if ((int)$min > 59 || (int)$min < 0) {

            (int)$min = 59;
        }
        // test Hours
        if ((int)$hr > 24 || (int)$hr < 0) {
            (int)$hr = 24;
        }
        $result = (int)$mil // convert on milli and Add
            + (int)$sc * 1000
            + (int)$min * 60000;
            + (int)$hr * 3600000;
        return $result;
    }

    /**
     * @param $hr = hours max 23
     * @param $min = minutes max 59
     * @param $sc = seconds max 59
     * @param $mil = milliseconds max 999
     * @return array
     */
    public function getStringFromData($hr = 0, $min = 0, $sc = 0, $mil = 0)
    {
        $micro = $this->getMicroFromData($hr, $min, $sc, $mil);
        return $this->getStringFromMicro($micro);
    }

    /**
     * @param $microChrono
     * @return int
     */
    public function getMinuteFromMicroResult($microChrono){

        $milli = $microChrono - (floor($microChrono / 1000) * 1000); // isol milli
        $microChrono = $microChrono - $milli; // sub milli
        $hr = floor($microChrono / 3600000); // isol hours
        $microChrono = $microChrono - ($hr * 3600000); // sub hours
        $minutes = floor($microChrono / 60000);// isol minutes

        return (int)$minutes;
    }

    /**
     * @param $microChrono
     * @return int
     */
    public function getSecondFromMicroResult($microChrono){

        $milli = $microChrono - (floor($microChrono / 1000) * 1000); // isol milli
        $microChrono = $microChrono - $milli; // sub milli
        $hr = floor($microChrono / 3600000); // isol hours
        $microChrono = $microChrono - ($hr * 3600000); // sub hours
        $min = floor($microChrono / 60000);// isol minutes
        $microChrono = $microChrono - ($min * 60000); // sub minutes
        $sc = $microChrono / 1000; //find last seconde :)

        return (int)$sc;

    }

    /**
     * @param $microChrono
     * @return int
     */
    public function getMillisecondeFromMicroResult($microChrono){

        $milli = $microChrono - (floor($microChrono / 1000) * 1000); // isol milli

        return (int)$milli;

    }

    /**
     * @param $microChrono
     *
     * @return array
     */
    public function getTimerByMicroResult($microChrono){

        $milli = $microChrono - (floor($microChrono / 1000) * 1000); // isol milli
        $microChrono = $microChrono - $milli; // sub milli
        $hr = floor($microChrono / 3600000); // isol hours
        $microChrono = $microChrono - ($hr * 3600000); // sub hours
        $min = floor($microChrono / 60000);// isol minutes
        $microChrono = $microChrono - ($min * 60000); // sub minutes
        $sc = $microChrono / 1000; //find last seconde :)

        return  array(
            'hours'         => (int)$hr,
            'minutes'       => (int)$min,
            'seconds'       => (int)$sc,
            'milliseconds'  => (int)$milli
        );
    }

 }