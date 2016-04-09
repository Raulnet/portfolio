<?php
/**
 * Entity Championships
 * Auto Generate :2016-01-17 13:32:59
 * t_championships
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Championships implements Entity
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
    * Table-target t_user usr_id
    *
    * @var int
    */
   protected $userId = null;

   /**
    * @var int
    */
   protected $status = null;

   /**
    * @var string
    */
   protected $backgroundFile = null;

   /**
    * @var string
    */
   protected $styleCss = null;

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
       $metadata->addPropertyConstraint("title", new Assert\Length(array("max" => 45, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("title", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("userId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("userId", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("status", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("status", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("backgroundFile", new Assert\Length(array("max" => 80, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("styleCss", new Assert\Length(array("max" => 80, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("resultId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
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
   public function getStatus()
   {
       return $this->status;
   }

   /**
    * @param int $status
    */
   public function setStatus($status)
   {
       $this->status = $status;
   }

   /**
    * @return string
    */
   public function getBackgroundFile()
   {
       return $this->backgroundFile;
   }

   /**
    * @param string $backgroundFile
    */
   public function setBackgroundFile($backgroundFile)
   {
       $this->backgroundFile = $backgroundFile;
   }

   /**
    * @return string
    */
   public function getStyleCss()
   {
       return $this->styleCss;
   }

   /**
    * @param string $styleCss
    */
   public function setStyleCss($styleCss)
   {
       $this->styleCss = $styleCss;
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
            "cha_id" => $this->id,
            "cha_title" => $this->title,
            "user_id" => $this->userId,
            "status" => $this->status,
            "cha_background_file" => $this->backgroundFile,
            "cha_style_css" => $this->styleCss,
            "result_id" => $this->resultId,
       );
       return $entity;
   }

}
