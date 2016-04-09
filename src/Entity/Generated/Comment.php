<?php
/**
 * Entity Comment
 * Auto Generate :2016-01-17 13:32:59
 * t_comment
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Comment implements Entity
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
   protected $content = null;

   /**
    * @var int
    */
   protected $codemovie = null;

   /**
    * Relation Many To Many
    * Table-target t_article art_id
    *
    * @var int
    */
   protected $id = null;

   /**
    * Relation Many To Many
    * Table-target t_user usr_id
    *
    * @var int
    */
   protected $id = null;

   /**
    * @var timestamp
    */
   protected $datetime = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("content", new Assert\Length(array("max" => 500, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("content", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("codemovie", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
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
    * @return string
    */
   public function getContent()
   {
       return $this->content;
   }

   /**
    * @param string $content
    */
   public function setContent($content)
   {
       $this->content = $content;
   }

   /**
    * @return int
    */
   public function getCodemovie()
   {
       return $this->codemovie;
   }

   /**
    * @param int $codemovie
    */
   public function setCodemovie($codemovie)
   {
       $this->codemovie = $codemovie;
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
    * @return timestamp
    */
   public function getDatetime()
   {
       return $this->datetime;
   }

   /**
    * @param timestamp $datetime
    */
   public function setDatetime($datetime)
   {
       $this->datetime = $datetime;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "com_id" => $this->id,
            "com_content" => $this->content,
            "com_codeMovie" => $this->codemovie,
            "art_id" => $this->id,
            "usr_id" => $this->id,
            "com_dateTime" => $this->datetime,
       );
       return $entity;
   }

}
