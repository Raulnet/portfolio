<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 14/03/2015
 * Time: 10:17
 */

namespace portfolio\DAO;

use portfolio\Domain\Round;


class RoundDAO extends DAO
{

    /**
     * @var \portfolio\DAO\ChampionshipDAO
     */
    private $championshipDAO;

    /**
     * @param ChampionshipDAO $championshipDAO
     */
    public function setChampionshipDAO(ChampionshipDAO $championshipDAO)
    {
        $this->championshipDAO = $championshipDAO;
    }

    public function find($id) {
        $sql = "
            SELECT *
            FROM t_round
            WHERE rou_id=?
        ";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No round matching id " . $id);
    }

    /**
     * @return array of all championship
     */
    public function findAll()
    {
        $sql = "SELECT *
        FROM t_round
        ORDER BY rou_id DESC
        ";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['rou_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function findByChampionship($champId) {
        $sql = "
            SELECT *
            FROM t_round
            WHERE rou_championship_id=?
        ";
        $result = $this->getDb()->fetchAll($sql, array($champId));

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['rou_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;

    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \portfolio\Domain\Round
     */
    protected function buildDomainObject($row)
    {
        $round = new Round();
        $round->setId($row['rou_id']);
        $round->setTitle($row['rou_title']);


        if (array_key_exists('rou_championship_id', $row)) {
            // Find and set the associated article
            $champId = $row['rou_championship_id'];


            $champ = $this->championshipDAO->find($champId);
            $round->setChampionship($champ);
        }

        return $round;
    }

    /**
     * @param Round $round
     */
    public function save(Round $round) {
        $roundData = array(
            'rou_title' => $round->getTitle(),
            'rou_championship_id' => $round->getChampionship()->getId(),

        );

        if ($round->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('t_round', $roundData, array('rou_id' => $round->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('t_round', $roundData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $round->setId($id);
        }
    }
} // END CLASS