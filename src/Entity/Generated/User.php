<?php
/**
 * Entity User
 * Auto Generate :2016-01-17 13:32:59
 * t_user
 */
namespace portfolio\Entity\Generated;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


class User implements Entity
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
   protected $name = null;

   /**
    * @var string
    */
   protected $password = null;

   /**
    * @var string
    */
   protected $salt = null;

   /**
    * @var string
    */
   protected $role = null;

   /**
    * @param ClassMetadata $metadata
    */
   static public function loadValidatorMetadata(ClassMetadata $metadata)
   {
       $metadata->addPropertyConstraint("id", new Assert\Length(array("max" => 11, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("id", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("name", new Assert\Length(array("max" => 50, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("name", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("password", new Assert\Length(array("max" => 88, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("password", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("salt", new Assert\Length(array("max" => 23, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("salt", new Assert\NotBlank(array("message" => "Not null")));
       $metadata->addPropertyConstraint("role", new Assert\Length(array("max" => 50, "maxMessage" => "trop long")));
       $metadata->addPropertyConstraint("role", new Assert\NotBlank(array("message" => "Not null")));
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
   public function getName()
   {
       return $this->name;
   }

   /**
    * @param string $name
    */
   public function setName($name)
   {
       $this->name = $name;
   }

   /**
    * @return string
    */
   public function getPassword()
   {
       return $this->password;
   }

   /**
    * @param string $password
    */
   public function setPassword($password)
   {
       $this->password = $password;
   }

   /**
    * @return string
    */
   public function getSalt()
   {
       return $this->salt;
   }

   /**
    * @param string $salt
    */
   public function setSalt($salt)
   {
       $this->salt = $salt;
   }

   /**
    * @return string
    */
   public function getRole()
   {
       return $this->role;
   }

   /**
    * @param string $role
    */
   public function setRole($role)
   {
       $this->role = $role;
   }

   /**
    * @return array Entity 
    */
   public function toArray()
   {
       $entity = array(
            "usr_id" => $this->id,
            "usr_name" => $this->name,
            "usr_password" => $this->password,
            "usr_salt" => $this->salt,
            "usr_role" => $this->role,
       );
       return $entity;
   }

}
