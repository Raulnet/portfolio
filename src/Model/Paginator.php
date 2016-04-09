<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 30/03/2015
 * Time: 00:49
 */

namespace portfolio\Model;


class Paginator {

    /**
     * Get Data in Array at Page selected ex: in 40 data for page 3 and 10 data/page return data 30->39
     *
     * @param array $dataArray
     * @param int $page
     * @param int $dataQuantity
     * @return array
     */
    public function getDataToPage($dataArray = array(), $page = 1, $dataQuantity = 10){

        $array = array(); // load Array

        $iPos = ($dataQuantity * $page) - $dataQuantity; // find where start de loop

        for($iPos; $iPos < $dataQuantity * $page; $iPos++){

            $array[] = $dataArray[$iPos];
        }


        return $array;

    }

    /**
     * @param array $dataArray
     * @param int $page
     * @param int $dataQuantity
     * @param int $delta
     * @return array
     */
    public function getPaginator($dataArray = array(), $page = 1, $dataQuantity = 10, $delta = 5){

        $Paginator = array(); // Declare Array() Paginator

        $nbrPages = $this->getNbrPage($dataArray, $dataQuantity); // Load how Many Page exist in dataArray



        for ($iPos = 1; $iPos <= $nbrPages; $iPos++) {

            if($page > 1 && $iPos == 1){

                $prev = $page-1;
                $Paginator[] = array('pageId' => $prev, 'value' => '<span aria-hidden="true">&laquo;</span>');

            } elseif ($page - $delta > $iPos) {

                $midPage = ceil(($page - $delta)/2);

                $Paginator[] = array('pageId' => $midPage, 'value' => '...') ;
                $iPos = $page - $delta;

            } elseif ($page + $delta < $iPos) {

                $midPage = ceil(($nbrPages - $page + $delta)/2);

                $Paginator[] = array('pageId' => $midPage, 'value' => '...') ;
                $Paginator[] = array('pageId' => $nbrPages, 'value' => $nbrPages) ;
                break;
            }

            $Paginator[] = array('pageId' => $iPos, 'value' => $iPos);

        }

        if($page < $nbrPages){
            $next = $page+1;
            $Paginator[] = array('pageId' => $next, 'value' => '<span aria-hidden="true">&raquo;</span>');
        }

        return $Paginator;
    }

    /**
     * @param array $dataArray
     * @param int $dataQuantity
     * @return int
     */
    private function getNbrPage($dataArray, $dataQuantity){

        $nbrData = count($dataArray);
        $nbrPages = $nbrData / $dataQuantity;

        if(is_float($nbrPages)){
            $nbrPages = floor($nbrPages);
        }

        return $nbrPages;
    }


} 