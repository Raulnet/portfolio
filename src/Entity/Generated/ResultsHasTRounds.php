<?php
/**
 * Entity ResultsHasTRounds
 * Auto Generate :2015-09-01 23:02:22
 * t_results_has_t_rounds
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class ResultsHasTRounds implements Entity
{

   /**
    * Primary key
    *
    * Relation Many To One
    * Table-target t_results res_id
    *
    * @var int
    */
   private $resultId = null;

   /**
    * Primary key
    *
    * Relation Many To One
    * Table-target t_rounds rou_id
    *
    * @var int
    */
   private $roundId = null;

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
    * @return int
    */
   public function getRoundId()
   {
       return $this->roundId;
   }

   /**
    * @param int $roundId
    */
   public function setRoundId($roundId)
   {
       $this->roundId = $roundId;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "result_id" => $this->resultId,
            "round_id" => $this->roundId,
       );
       return $entity;
   }

}
