<?php
/**
 * Entity StagesMetaResults
 * Auto Generate :2016-01-17 13:32:59
 * t_stages_meta_results
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class StagesMetaResults implements Entity
{

   /**
    * Primary key
    *
    * @var int
    */
   protected $id = null;

   /**
    * @var int
    */
   protected $result = null;

   /**
    * Relation Many To Many
    * Table-target t_stages sta_id
    *
    * @var int
    */
   protected $stageId = null;

   /**
    * @var int
    */
   protected $value = null;

   /**
    * Relation Many To Many
    * Table-target t_results res_id
    *
    * @var int
    */
   protected $resultId = null;

   /**
    * @var int
    */
   protected $status = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("result", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("stageId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("stageId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("value", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("resultId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("resultId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("status", new Assert\Length(array("max" => 1, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("status", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getStageId()
   {
       return $this->stageId;
   }

   /**
    * @param int $stageId
    */
   public function setStageId($stageId)
   {
       $this->stageId = $stageId;
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
   public function getStatus()
   {
       return $this->status;
   }

   /**
    * @param int $status
    */
   public function setStatus($status)
   {
       $this->status = $status;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "smr_id" => $this->id,
            "smr_result" => $this->result,
            "stage_id" => $this->stageId,
            "smr_value" => $this->value,
            "result_id" => $this->resultId,
            "status" => $this->status,
       );
       return $entity;
   }

}
