<?php

require_once(ROOT_PATH . "system/database/DatabaseFactory.php");
require_once(ROOT_PATH . "model/UserInfoUpdateDTO.php");
//require_once(ROOT_PATH . "dal/utility/DBRecorder.php");

class UserInfoUpdateDAO {

    private $db;
    private $tableName = "User_UpdateList";
    private $sql = "";

    public function UserInfoUpdateDAO() {
        $this->db = DatabaseFactory::getMysqliDatabase();
    }

    public function add($item) {
        if ($this->checkData($item)) {
            $this->sql = "INSERT INTO " . $this->db->addPrefix($this->tableName) . " (userid, isEmailUpdated, isPasswordUpdated)
                		VALUES ('" . $item->userid . "',
                				'" . $item->isEmailUpdated . "',
								'" . $item->isPasswordUpdated . "'
                				)";

            $result = $this->db->query($this->sql);
            $this->sql = null;
            return $this->db->getInsertID();
        }

        return null;
    }
	
	
	public function getItemByItemID($aID) {
        $this->sql = "SELECT * FROM " . $this->db->addPrefix($this->tableName) . "
    				WHERE userid=" . $aID;
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) != 0) {
            if ($row = $this->db->fetch_assoc_array($result)) {
                $dg = new UserInfoUpdateDTO();
                $dg->userid = $row['userid'];
                $dg->isEmailUpdated = $row['isEmailUpdated'];
                $dg->isPasswordUpdated = $row['isPasswordUpdated'];
                $this->db->free($result);
                $this->sql = null;
                return $dg;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	
	
    public function update($item) {
        if ($this->checkData($item)) {
            $this->sql = "UPDATE " . $this->db->addPrefix($this->tableName) . " SET 
                		`isEmailUpdated`=" . $item->isEmailUpdated . ",
                		`isPasswordUpdated`=" . $item->isPasswordUpdated;
			$this->sql .= " WHERE userid=" . $item->userid;
            $result = $this->db->query($this->sql);
            $this->sql = null;
            return $result;
        }

        return false;
    }

    private function checkData($item) {
        return true;
    }

    public function getTableName() {
        return $this->db->addPrefix($this->tableName);
    }
}?>