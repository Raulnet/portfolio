<?php
/**
 * Entity UserHasChampionship
 * Auto Generate :2016-01-17 13:32:59
 * user_has_championship
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class UserHasChampionship implements Entity
{

   /**
    * Primary key
    *
    * Relation Many To One
    * Table-target t_user usr_id
    *
    * @var int
    */
   protected $userId = null;

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
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("userId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("userId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("championshipId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("championshipId", new Assert\NotBlank(array("message" => "Not null")));
   }

   /**
    * @return int
    */
   public function getUserId()
   {
       return $this->userId;
   }

   /**
    * @param int $userId
    */
   public function setUserId($userId)
   {
       $this->userId = $userId;
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
            "user_id" => $this->userId,
            "championship_id" => $this->championshipId,
       );
       return $entity;
   }

}
