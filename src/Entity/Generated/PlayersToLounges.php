<?php
/**
 * Entity PlayersToLounges
 * Auto Generate :2016-01-17 13:32:59
 * t_players_to_lounges
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class PlayersToLounges implements Entity
{

   /**
    * Primary key
    *
    * @var int
    */
   protected $id = null;

   /**
    * Relation Many To Many
    * Table-target t_players_to_championships pca_id
    *
    * @var int
    */
   protected $playerToChampionshipId = null;

   /**
    * Relation Many To Many
    * Table-target t_lounges lou_id
    *
    * @var int
    */
   protected $loungeId = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("playerToChampionshipId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("playerToChampionshipId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("loungeId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("loungeId", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getPlayerToChampionshipId()
   {
       return $this->playerToChampionshipId;
   }

   /**
    * @param int $playerToChampionshipId
    */
   public function setPlayerToChampionshipId($playerToChampionshipId)
   {
       $this->playerToChampionshipId = $playerToChampionshipId;
   }

   /**
    * @return int
    */
   public function getLoungeId()
   {
       return $this->loungeId;
   }

   /**
    * @param int $loungeId
    */
   public function setLoungeId($loungeId)
   {
       $this->loungeId = $loungeId;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "plo_id" => $this->id,
            "player_to_championship_id" => $this->playerToChampionshipId,
            "lounge_id" => $this->loungeId,
       );
       return $entity;
   }

}
