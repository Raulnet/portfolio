<?php
/**
 * Entity PlayersToChampionships
 * Auto Generate :2016-01-17 13:32:59
 * t_players_to_championships
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class PlayersToChampionships implements Entity
{

   /**
    * Primary key
    *
    * @var int
    */
   protected $id = null;

   /**
    * Relation Many To Many
    * Table-target t_championships cha_id
    *
    * @var int
    */
   protected $championshipId = null;

   /**
    * Relation Many To Many
    * Table-target t_players pla_id
    *
    * @var int
    */
   protected $playerId = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("championshipId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("championshipId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("playerId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("playerId", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getPlayerId()
   {
       return $this->playerId;
   }

   /**
    * @param int $playerId
    */
   public function setPlayerId($playerId)
   {
       $this->playerId = $playerId;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "pca_id" => $this->id,
            "championship_id" => $this->championshipId,
            "player_id" => $this->playerId,
       );
       return $entity;
   }

}
