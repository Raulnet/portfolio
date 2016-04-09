<?php
/**
 * Entity Result
 * Auto Generate :2016-01-17 13:32:59
 * t_result
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Result implements Entity
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
   protected $microResult = null;

   /**
    * Relation Many To Many
    * Table-target t_round rou_id
    *
    * @var int
    */
   protected $id = null;

   /**
    * Relation Many To Many
    * Table-target t_player pla_id
    *
    * @var int
    */
   protected $id = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("microResult", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
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
       $this->microResult = $microResult;
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
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "res_id" => $this->id,
            "res_micro_result" => $this->microResult,
            "rou_id" => $this->id,
            "pla_id" => $this->id,
       );
       return $entity;
   }

}
