<?php
/**
 * Zend Entity Manager ZEM Abstract
 * Auto Generate :2016-01-17 13:32:59
 * Abstract
 */
namespace portfolio\ZEM\Generated;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use portfolio\Entity\Generated\Entity;

abstract class ZEM extends AbstractTableGateway
{

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @var string
     */
    protected $primaryKey = null;

    /**
     * @var string
     */
    protected $secondaryKey = null;

    /**
     * @var Application $app
     */
    protected $app = null;

    /**
     * @param Application $app
     * @param $configArray
     */
    public function __construct($configArray, $app)
    {
        $this->adapter = new Adapter($configArray);
        $this->app     = $app;
        $this->sql     = new Sql($this->adapter, $this->table);
    }

    /**
     * Builds a domain object from a ZDB row.
     * Must be overridden by child classes.
     * 
     * @param $row 
     */
    protected abstract function buildZEntityObject($row);

    /**
     * @param      $data
     * @param null $data2
     * 
     * @return bool
     */
    protected function setWhere($data, $data2 = null)
    {
        // if is an instance of Entity Object set to array
        if ($data instanceof Entity) {

            $data = $data->toArray();
        }
        // if is an array
        if (is_array($data)) {
            if (array_key_exists($this->primaryKey, $data)) {
                $this->where[$this->primaryKey] = $data[$this->primaryKey];
            }
            if (array_key_exists($this->secondaryKey, $data)) {
                $this->where[$this->secondaryKey] =$data[$this->secondaryKey];
            }
            if(array_key_exists($this->primaryKey, $this->where) && $this->where[$this->primaryKey] != null){
                return true;
            }
            return false;
        }
        if(is_numeric($data)){
            // filter to INT
            $data = filter_var($data, FILTER_VALIDATE_INT);
            $this->where[$this->primaryKey] = $data;
        }
        if(ctype_alnum($data)){
            // filter to INT
            $this->where[$this->primaryKey] = $data;
        }
        if(is_numeric($data2)){
            // filter to INT
            $data2 = filter_var($data2, FILTER_VALIDATE_INT);
            $this->where[$this->secondaryKey] = $data2;
        }
        if(ctype_alnum($data2)){
            // filter to INT
            $this->where[$this->secondaryKey] = $data2;
        }
        if($this->where){
            return true;
        }
        return false;
    }

    /**
     * @return array Entities
     */
    public function findAll()
    {
        $select = $this->sql->select();
        $result = $this->selectWith($select)->toArray();
        $entities = array();
        foreach ($result as $row) {
            $entities[] = $this->buildZEntityObject($row);
        }

        return $entities;
    }

    /**
     * @param array $where
     * 
     * @return array Entities
     */
    public function find(array $where)
    {
        $select = $this->sql->select();
        $select->where($where);
        $result = $this->selectWith($select)->toArray();
        $entities = array();
        foreach ($result as $row) {
            $entities[] = $this->buildZEntityObject($row);
        }

        return $entities;
    }

    /**
     * @param int      $data
     * @param int|null $data2
     * 
     * @return bool|Entity
     */
     protected function findOneEntityById($data, $data2 = null)
     {
         $entity = false;
         if($this->setWhere($data, $data2)){

             $select = $this->sql->select();
             $select->where($this->where);
             $row = $this->selectWith($select)->current();
             if($row){
                 $entity = $this->buildZEntityObject($row);
             }
         }
         return $entity;
     }

    /**
     * Create Entity
     * 
     * @param array $data | Entity $data
     * 
     * @return bool
     */
    public function createEntity($data)
    {
        if ($data instanceof Entity) {
            $data = $data->toArray();
            if ($data[$this->primaryKey] == null) {
                if($this->insert($data)){
                    return true;
                }
                return false;
            }
            if ($data[$this->secondaryKey] && $data[$this->primaryKey]) {
                if(!$this->findOneById($data[$this->secondaryKey], $data[$this->primaryKey])){
                    if($this->insert($data)){
                        return true;
                    };
                    return false;
                }
                return false;
            }
        }
        return false;
    }

    /**
     * Save Entity
     * 
     * @param Entity|array $entity
     * 
     * @return bool
     */
    public function saveEntity($entity)
    {
        if($entity instanceof Entity){
            $entity = $entity->toArray();
        }

        if ($this->setWhere($entity))  {
            if($this->update($entity, $this->where)){
                return true;
            }
            return false;
        }
        if($this->insert($entity)){
            return true;
        }
        return false;
    }

    /**
     * Delete Entity
     * 
     * @param Entity $data
     * 
     * @return bool
     */
    public function deleteEntity($data)
    {
        if($this->setWhere($data)){
            $this->delete($this->where);
            return true;
        }
        return false;
    }
}
