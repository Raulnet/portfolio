<?php
/**
 * Entity Results
 * Auto Generate :2016-01-17 13:32:59
 * t_results
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class Results implements Entity
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
   protected $type = null;

   /**
    * @var tinyint
    */
   protected $sequence = null;

   /**
    * Relation Many To Many
    * Table-target t_grids_points gpo_id
    *
    * @var int
    */
   protected $gridsPointsId = null;

   /**
    * @var string
    */
   protected $sort = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("title", new Assert\Length(array("max" => 40, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("title", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("type", new Assert\Length(array("max" => 40, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("type", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("sequence", new Assert\Length(array("max" => 2, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("sequence", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("gridsPointsId", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("sort", new Assert\Length(array("max" => 4, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("sort", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getType()
   {
       return $this->type;
   }

   /**
    * @param string $type
    */
   public function setType($type)
   {
       $this->type = $type;
   }

   /**
    * @return tinyint
    */
   public function getSequence()
   {
       return $this->sequence;
   }

   /**
    * @param tinyint $sequence
    */
   public function setSequence($sequence)
   {
       $this->sequence = $sequence;
   }

   /**
    * @return int
    */
   public function getGridsPointsId()
   {
       return $this->gridsPointsId;
   }

   /**
    * @param int $gridsPointsId
    */
   public function setGridsPointsId($gridsPointsId)
   {
       $this->gridsPointsId = $gridsPointsId;
   }

   /**
    * @return string
    */
   public function getSort()
   {
       return $this->sort;
   }

   /**
    * @param string $sort
    */
   public function setSort($sort)
   {
       $this->sort = $sort;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "res_id" => $this->id,
            "res_title" => $this->title,
            "res_type" => $this->type,
            "res_sequence" => $this->sequence,
            "grids_points_id" => $this->gridsPointsId,
            "res_sort" => $this->sort,
       );
       return $entity;
   }

}
