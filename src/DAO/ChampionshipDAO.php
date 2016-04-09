<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 14/03/2015
 * Time: 09:51
 */

namespace portfolio\DAO;

use portfolio\Domain\Championship;


class ChampionshipDAO extends DAO
{
    /**
     * @return array
     */
    public function findAll()
    {
        $sql = "SELECT * FROM t_championship ORDER BY cha_id ";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['cha_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function find($id) {

        $sql = "select * from t_championship where cha_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No championship matching id " . $id);
    }


    /**
     * Creates an Championship object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \portfolio\Domain\Championship
     */
    protected function buildDomainObject($row)
    {
        $championship = new Championship();
        $championship->setId($row['cha_id']);
        $championship->setTitle($row['cha_title']);

        return $championship;
    }


} 