<?php
/**
 * Entity Article
 * Auto Generate :2016-01-17 13:32:59
 * t_article
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Article implements Entity
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
    * @var string
    */
   protected $content = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("title", new Assert\Length(array("max" => 100, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("title", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("content", new Assert\Length(array("max" => 2000, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("content", new Assert\NotBlank(array("message" => "Not null")));
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
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "art_id" => $this->id,
            "art_title" => $this->title,
            "art_content" => $this->content,
       );
       return $entity;
   }

}
