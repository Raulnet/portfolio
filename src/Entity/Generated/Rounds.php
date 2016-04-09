<?php
/**
 * Entity Rounds
 * Auto Generate :2016-01-17 13:32:59
 * t_rounds
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Rounds implements Entity
{

   /**
    * Primary key
    *
    * @var int
    */
   protected $id = null;

   /**
    * @var string
    */
   protected $title = null;

   /**
    * @var int
    */
   protected $sequence = null;

   /**
    * Relation Many To Many
    * Table-target t_stages sta_id
    *
    * @var int
    */
   protected $stageId = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("title", new Assert\Length(array("max" => 45, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("title", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("sequence", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("sequence", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("stageId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("stageId", new Assert\NotBlank(array("message" => "Not null")));
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
    * @return string
    */
   public function getTitle()
   {
       return $this->title;
   }

   /**
    * @param string $title
    */
   public function setTitle($title)
   {
       $this->title = $title;
   }

   /**
    * @return int
    */
   public function getSequence()
   {
       return $this->sequence;
   }

   /**
    * @param int $sequence
    */
   public function setSequence($sequence)
   {
       $this->sequence = $sequence;
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
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "rou_id" => $this->id,
            "rou_title" => $this->title,
            "rou_sequence" => $this->sequence,
            "stage_id" => $this->stageId,
       );
       return $entity;
   }

}
