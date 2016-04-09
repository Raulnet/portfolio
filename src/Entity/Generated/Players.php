<?php
/**
 * Entity Players
 * Auto Generate :2016-01-17 13:32:59
 * t_players
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Players implements Entity
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
   protected $nickname = null;

   /**
    * Relation Many To One
    * Table-target  
    *
    * @var string
    */
   protected $mail = null;

   /**
    * @var text
    */
   protected $comment = null;

   /**
    * @var string
    */
   protected $support = null;

   /**
    * Relation Many To Many
    * Table-target t_user usr_id
    *
    * @var int
    */
   protected $userId = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("nickname", new Assert\Length(array("max" => 45, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("mail", new Assert\Length(array("max" => 45, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("support", new Assert\Length(array("max" => 6, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("userId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("userId", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getNickname()
   {
       return $this->nickname;
   }

   /**
    * @param string $nickname
    */
   public function setNickname($nickname)
   {
       $this->nickname = $nickname;
   }

   /**
    * @return string
    */
   public function getMail()
   {
       return $this->mail;
   }

   /**
    * @param string $mail
    */
   public function setMail($mail)
   {
       $this->mail = $mail;
   }

   /**
    * @return text
    */
   public function getComment()
   {
       return $this->comment;
   }

   /**
    * @param text $comment
    */
   public function setComment($comment)
   {
       $this->comment = $comment;
   }

   /**
    * @return string
    */
   public function getSupport()
   {
       return $this->support;
   }

   /**
    * @param string $support
    */
   public function setSupport($support)
   {
       $this->support = $support;
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
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "pla_id" => $this->id,
            "pla_nickname" => $this->nickname,
            "pla_mail" => $this->mail,
            "pla_comment" => $this->comment,
            "pla_support" => $this->support,
            "user_id" => $this->userId,
       );
       return $entity;
   }

}
