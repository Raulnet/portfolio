<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 13/03/2015
 * Time: 15:15
 */

namespace portfolio\DAO;

use portfolio\Domain\Player;

class PlayerDAO extends DAO {

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \portfolio\Domain\Player
     *
     * @throws \Exception if no matching comment is found
     */
    public function find($id) {

        $sql = "select * from t_player where pla_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }


    /**
     * @return array
     */
    public function findAll(){

        $sql = "select * from t_player order by pla_nickname";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['pla_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * @param $email
     * @return Player|string
     */
    public function findByEmail($email){

        $sql = "select * from t_player where pla_mail=?";
        $row = $this->getDb()->fetchAssoc($sql, array($email));

        if ($row)
            return $this->buildDomainObject($row);
        else
           return 'not found';
    }

    /**
     * @param $nickname
     * @return Player|string
     */
    public function findByNickname($nickname){

        $sql = "select * from t_player where pla_nickname=?";
        $row = $this->getDb()->fetchAssoc($sql, array($nickname));

        if ($row)
            return $this->buildDomainObject($row);
        else
            return 'not found';
    }


    /**
     * @param $row
     * @return Player
     */
    protected function buildDomainObject($row) {
        $player = new Player();
        $player->setId($row['pla_id']);
        $player->setEmail($row['pla_mail']);
        $player->setNickname($row['pla_nickname']);
        $player->setComment($row['pla_comment']);
        $player->setSupport($row['pla_support']);

        return $player;
    }

    /**
     * @param Player $player
     */
    public function save(Player $player) {
        $playerData = array(
            'pla_nickname' => $player->getNickname(),
            'pla_mail' => $player->getEmail(),
            'pla_comment' => $player->getComment(),
            'pla_support' => $player->getSupport(),
        );

        if ($player->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('t_player', $playerData, array('pla_id' => $player->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('t_player', $playerData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $player->setId($id);
        }
    }

    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($id) {

        $this->getDb()->delete('t_player', array('pla_id' => $id));
    }


} // END PLAYER !!!