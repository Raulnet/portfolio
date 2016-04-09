<?php
/**
 * Entity MetaResults
 * Auto Generate :2016-01-17 13:32:59
 * t_meta_results
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class MetaResults implements Entity
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
   protected $result = null;

   /**
    * @var string
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
    * Relation Many To Many
    * Table-target t_rounds rou_id
    *
    * @var int
    */
   protected $roundId = null;

   /**
    * Relation Many To Many
    * Table-target t_players_to_lounges plo_id
    *
    * @var int
    */
   protected $playerToLoungeId = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("result", new Assert\Length(array("max" => 255, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("value", new Assert\Length(array("max" => 255, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("resultId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("resultId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("roundId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("roundId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("playerToLoungeId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("playerToLoungeId", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getResult()
   {
       return $this->result;
   }

   /**
    * @param string $result
    */
   public function setResult($result)
   {
       $this->result = $result;
   }

   /**
    * @return string
    */
   public function getValue()
   {
       return $this->value;
   }

   /**
    * @param string $value
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
   public function getRoundId()
   {
       return $this->roundId;
   }

   /**
    * @param int $roundId
    */
   public function setRoundId($roundId)
   {
       $this->roundId = $roundId;
   }

   /**
    * @return int
    */
   public function getPlayerToLoungeId()
   {
       return $this->playerToLoungeId;
   }

   /**
    * @param int $playerToLoungeId
    */
   public function setPlayerToLoungeId($playerToLoungeId)
   {
       $this->playerToLoungeId = $playerToLoungeId;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "mre_id" => $this->id,
            "mre_result" => $this->result,
            "mre_value" => $this->value,
            "result_id" => $this->resultId,
            "round_id" => $this->roundId,
            "player_to_lounge_id" => $this->playerToLoungeId,
       );
       return $entity;
   }

}
