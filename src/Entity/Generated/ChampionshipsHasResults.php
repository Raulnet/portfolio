<?php
/**
 * Entity ChampionshipsHasResults
 * Auto Generate :2015-09-14 23:29:43
 * championships_has_results
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class ChampionshipsHasResults implements Entity
{

   /**
    * Primary key
    *
    * Relation Many To One
    * Table-target t_championships cha_id
    *
    * @var int
    */
   protected $championshipId = null;

   /**
    * Primary key
    *
    * Relation Many To One
    * Table-target t_results res_id
    *
    * @var int
    */
   protected $resultId = null;

   /**
    * @return int
    */
   public function getChampionshipId()
   {
       return $this->championshipId;
   }

   /**
    * @param int $championshipId
    */
   public function setChampionshipId($championshipId)
   {
       $this->championshipId = $championshipId;
   }

   /**
    * @return int
    */
   public function getResultId()
   {
       return $this->resultId;
   }

   /**
    * @param int $resultId
    */
   public function setResultId($resultId)
   {
       $this->resultId = $resultId;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "championship_id" => $this->championshipId,
            "result_id" => $this->resultId,
       );
       return $entity;
   }

}
