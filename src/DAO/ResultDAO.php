<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 17/03/2015
 * Time: 16:08
 */

namespace portfolio\DAO;

use portfolio\Domain\Result;
use portfolio\Model\ChronoConverter;

class ResultDAO extends DAO
{

    /**
     * @var \portfolio\DAO\RoundDAO
     */
    private $roundDAO;

    /**
     * @var \portfolio\DAO\PlayerDAO
     */
    private $playerDAO;

    /**
     * @var \portfolio\model\ChronoConverter
     */
    private $chronoConverter;

    /**
     * @param ChronoConverter $chronoConverter
     */
    public function setChronoConverter(ChronoConverter $chronoConverter){

        $this->chronoConverter = $chronoConverter;
    }

    /**
     * @param RoundDAO $roundDAO
     */
    public function setRoundDAO(RoundDAO $roundDAO)
    {
        $this->roundDAO = $roundDAO;
    }

    /**
     * @param PlayerDAO $playerDAO
     */
    public function setPlayerDAO(PlayerDAO $playerDAO)
    {
        $this->playerDAO = $playerDAO;
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \portfolio\Domain\Result
     */
    protected function buildDomainObject($row)
    {

        $result = new Result();
        $result->setId($row['res_id']);
        $result->setMicroResult($row['res_micro_result']);
        $result->setStringResult($this->chronoConverter->getStringFromMicro($result->getMicroResult()));

        if (array_key_exists('rou_id', $row)) {
            // Find and set the associated round
            $roundId = $row['rou_id'];

            $round = $this->roundDAO->find($roundId);
            $result->setRound($round);
        }

        if (array_key_exists('pla_id', $row)) {
            // Find and set the associated player
            $playerId = $row['pla_id'];

            $player = $this->playerDAO->find($playerId);
            $result->setPlayer($player);
        }

        return $result;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function find($id) {

        $sql = "select * from t_result where res_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No result matching id " . $id);
    }

    /*
    * @return array of all championship
    */
    public function findAll()
    {
        $sql = "SELECT *
        FROM t_result
        ORDER BY res_id DESC
        ";

        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['res_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function findByChampionship($id){

        $sql = "SELECT *
        FROM t_result re
        JOIN t_round ro ON ro.rou_id = re.rou_id
        WHERE ro.rou_championship_id = ?
        ORDER BY re.rou_id, res_micro_result ASC
        ";
        $result = $this->getDb()->fetchAll($sql, array($id));

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['res_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;

    }

    /**
     * @param $id
     * @return array
     */
    public function findTopByChampionship($id){

        $sql = "
        select *
        from t_result re
        join t_round ro on ro.rou_id = re.rou_id
        where ro.rou_championship_id = ?
        order by re.res_micro_result asc
        ";
        $result = $this->getDb()->fetchAll($sql, array($id));

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['pla_id'];
            if(array_key_exists($id, $entities)){
                if($entities[$id]->getMicroResult() > $row['res_micro_result']){
                    $entities[$id] = $this->buildDomainObject($row);
                }
            }
            else{
                $entities[$id] = $this->buildDomainObject($row);
            }
        }
        return $entities;
    }

    /**
     * @param $id
     * @return array
     */
    public function findByRound($id){

        $sql = "
        SELECT *
        FROM t_result
        WHERE rou_id = ?
        ORDER BY res_micro_result ASC
        ";
        $result = $this->getDb()->fetchAll($sql, array($id));

        $entities = array();
        foreach ($result as $row) {
            $id = $row['res_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;

    }

    /**
     * @param $roundId
     * @param $playerId
     * @throws \Exception
     */
    public function findByRoundAndPlayer($roundId, $playerId){

        $sql = "SELECT *
        FROM t_result
        WHERE rou_id = ? AND pla_id = ?
        ";

        $row = $this->getDb()->fetchAssoc($sql, array($roundId, $playerId));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No result matching roundId " . $roundId   );

    }

    /**
     * @param Result $result
     * @return null
     */
    public function save(Result $result) {

        $reponse = null;

        if(null != $result->getPlayer() && null != $result->getRound()) {

            $results = $this->findByRound($result->getRound()->getId());

            foreach($results as $data){
                if($data->getPlayer()->getId() === $result->getPlayer()->getId()){

                    $result->setId($data->getId());
                }
            }

            $min = $result->getMinute();
            $sc = $result->getSeconde();
            $milli = $result->getMilliseconde();
            $result->setMicroResult($this->chronoConverter->getMicroFromData(0, $min, $sc, $milli));

            $resultData = array(
                'rou_id' => $result->getRound()->getId(),
                'pla_id' => $result->getPlayer()->getId(),
                'res_micro_result' => $result->getMicroResult(),
            );

            if ($result->getId()) {
                // The comment has already been saved : update it

                $resultLoaded = $this->find($result->getId());

                if($result->getMicroResult() < $resultLoaded->getMicroResult() ) {

                    $this->getDb()->update('t_result', $resultData, array('res_id' => $result->getId()));

                    $reponse = ' Résultat mis à jour !';
                }
                else {

                    $reponse = 'le nouveau résultat est moins bon! résultat non enregistrer!';
                }

            } else {
                // The comment has never been saved : insert it
                $this->getDb()->insert('t_result', $resultData);
                // Get the id of the newly created comment and set it on the entity.
                $id = $this->getDb()->lastInsertId();
                $result->setId($id);

                $reponse = ' New result added';
            }
        }
        else {

            $reponse = ' DATA INVALIDED !!!';

        }

        return $reponse;
    }

    public function edit($result){

        $min = $result->getMinute();
        $sc = $result->getSeconde();
        $milli = $result->getMilliseconde();
        $result->setMicroResult($this->chronoConverter->getMicroFromData(0, $min, $sc, $milli));


        $resultData = array(
            'res_micro_result' => $result->getMicroResult(),
            'rou_id' => $result->getround()->getId(),
            'pla_id' => $result->getPlayer()->getId(),

        );

        if ($result->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('t_result', $resultData, array('res_id' => $result->getId()));
        }
    }

    /**
     * @param $resultId
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete($resultId) {
        // Delete the result
        $this->getDb()->delete('t_result', array('res_id' => $resultId));
    }

} // END CLASS