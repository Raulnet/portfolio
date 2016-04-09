<?php
/**
 * Entity Stages
 * Auto Generate :2016-01-17 13:32:59
 * t_stages
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Stages implements Entity
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
    * Table-target t_championships cha_id
    *
    * @var int
    */
   protected $championshipId = null;

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
       $metadata->addPropertyConstraint("championshipId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("championshipId", new Assert\NotBlank(array("message" => "Not null")));
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
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "sta_id" => $this->id,
            "sta_title" => $this->title,
            "sta_sequence" => $this->sequence,
            "championship_id" => $this->championshipId,
       );
       return $entity;
   }

}
