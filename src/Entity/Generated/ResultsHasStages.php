<?php
/**
 * Entity ResultsHasStages
 * Auto Generate :2015-09-14 23:29:43
 * results_has_stages
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class ResultsHasStages implements Entity
{

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
    * Primary key
    *
    * Relation Many To One
    * Table-target t_stages sta_id
    *
    * @var int
    */
   protected $stagesId = null;

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
   public function getStagesId()
   {
       return $this->stagesId;
   }

   /**
    * @param int $stagesId
    */
   public function setStagesId($stagesId)
   {
       $this->stagesId = $stagesId;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "result_id" => $this->resultId,
            "stages_id" => $this->stagesId,
       );
       return $entity;
   }

}
