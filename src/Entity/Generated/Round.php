<?php
/**
 * Entity Round
 * Auto Generate :2016-01-17 13:32:59
 * t_round
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Round implements Entity
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
    * Relation Many To Many
    * Table-target t_championship cha_id
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
            "rou_id" => $this->id,
            "rou_title" => $this->title,
            "rou_championship_id" => $this->championshipId,
       );
       return $entity;
   }

}
