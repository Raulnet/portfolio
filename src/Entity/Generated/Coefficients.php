<?php
/**
 * Entity Coefficients
 * Auto Generate :2016-01-17 13:32:59
 * t_coefficients
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Coefficients implements Entity
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
   protected $type = null;

   /**
    * @var float
    */
   protected $value = null;

   /**
    * Relation Many To Many
    * Table-target t_grids_points gpo_id
    *
    * @var int
    */
   protected $gridPointsId = null;

   /**
    * Relation Many To Many
    * Table-target t_results res_id
    *
    * @var int
    */
   protected $resultId = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("type", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("type", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("gridPointsId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("gridPointsId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("resultId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("resultId", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getType()
   {
       return $this->type;
   }

   /**
    * @param int $type
    */
   public function setType($type)
   {
       $this->type = $type;
   }

   /**
    * @return float
    */
   public function getValue()
   {
       return $this->value;
   }

   /**
    * @param float $value
    */
   public function setValue($value)
   {
       $this->value = $value;
   }

   /**
    * @return int
    */
   public function getGridPointsId()
   {
       return $this->gridPointsId;
   }

   /**
    * @param int $gridPointsId
    */
   public function setGridPointsId($gridPointsId)
   {
       $this->gridPointsId = $gridPointsId;
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
            "coe_id" => $this->id,
            "coe_type" => $this->type,
            "coe_value" => $this->value,
            "grid_points_id" => $this->gridPointsId,
            "result_id" => $this->resultId,
       );
       return $entity;
   }

}
