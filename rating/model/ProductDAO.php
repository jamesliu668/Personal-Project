<?php

require_once(ROOT_PATH . "system/database/DatabaseFactory.php");
require_once("ProductDTO.php");
//require_once(ROOT_PATH . "dal/utility/DBRecorder.php");

class ProductDAO {

    private $db;
    private $tableName = "jms-rate-product";
    private $sql = "";

    public function ProductDAO() {
        $this->db = DatabaseFactory::getMysqliDatabase();
    }

    public function add($item) {
        if ($this->checkData($item)) {
            $this->sql = "INSERT INTO `" . $this->db->addPrefix($this->tableName) . "` (name, description)
                		VALUES ('" . $this->db->escape_string($item->name) . "',
								'" . $this->db->escape_string($item->description) . "'
                				)";
								
            $result = $this->db->query($this->sql);
            $this->sql = null;
            return $this->db->getInsertID();
        }

        return null;
    }
	
	public function getAllItems() {
        $projectList = array();
        $this->sql = "SELECT * FROM `" . $this->db->addPrefix($this->tableName) ."`";
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) != 0) {
            while ($row = $this->db->fetch_assoc_array($result)) {
                $project = new ProductDTO();
				$project->id = $row['id'];
                $project->description = $row['description'];
                $project->name = $row['name'];
                $projectList[] = $project;
            }

            $this->db->free($result);
            $this->sql = null;
        }

        return $projectList;
    }
	
	
	
	
	
	
	
	
	
	
	
	public function getItemListByUserid($aID) {
		$dgList = array();
        $this->sql = "SELECT * FROM " . $this->db->addPrefix($this->tableName) . "
    				WHERE userid=".$aID;
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) > 0) {
            while ($row = $this->db->fetch_assoc_array($result)) {
                $dg = new AffiliateCreditDTO();
                $dg->id = $row['id'];
                $dg->userid = $row['userid'];
                $dg->productPrice = $row['product_price'];
                $dg->productName = $row['product_name'];
                $dg->rate = $row['rate'];
                $dg->credit = $row['credit'];
                $dg->date = $row['date'];
                $dg->status = $row['status'];
                $dgList[] = $dg;
            }
			
			$this->db->free($result);
			$this->sql = null;
        }
		
		return $dgList;
    }
	
	public function getItemListByUseridAndDate($aID, $fromdate, $enddate) {
		$dgList = array();
        $this->sql = "SELECT * FROM " . $this->db->addPrefix($this->tableName) . "
    				WHERE userid=".$aID." AND CAST(date AS UNSIGNED) > ".$fromdate." AND CAST(date AS UNSIGNED) < ".$enddate;
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) > 0) {
            while ($row = $this->db->fetch_assoc_array($result)) {
                $dg = new AffiliateCreditDTO();
                $dg->id = $row['id'];
                $dg->userid = $row['userid'];
                $dg->productPrice = $row['product_price'];
                $dg->productName = $row['product_name'];
                $dg->rate = $row['rate'];
                $dg->credit = $row['credit'];
                $dg->date = $row['date'];
                $dg->status = $row['status'];
                $dgList[] = $dg;
            }
			
			$this->db->free($result);
			$this->sql = null;
        }
		
		return $dgList;
    }
	
	public function getUnpaidCashByUserid($aID) {
		$this->sql = "SELECT sum(credit) AS total FROM " . $this->db->addPrefix($this->tableName) . "
    				WHERE userid=".$aID." AND status='available'";
		$result = $this->db->query($this->sql);
		$this->sql = null;
		if ($this->db->affect_rows($result) > 0) {
			if ($row = $this->db->fetch_assoc_array($result)) {
				return $row['total'];
			} else {
				$this->db->free($result);
				return false;
			}
		} else {
			return false;
		}
	}
	
	
	public function getItemByItemID($aID) {
        $this->sql = "SELECT * FROM " . $this->db->addPrefix($this->tableName) . "
    				WHERE id=" . $aID;
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) > 0) {
            if ($row = $this->db->fetch_assoc_array($result)) {
                $dg = new AffiliateLinkDTO();
                $dg->id = $row['id'];
                $dg->userid = $row['userid'];
                $dg->referlink = $row['referlink'];
				$dg->alias = $row['alias'];
				$dg->clickcount = $row['clickcount'];
				$dg->linkid = $row['linkid'];
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
                		`referlink`='" . $this->db->escape_string($item->referlink) . "',
                		`alias`='" . $this->db->escape_string($item->alias) . "' ";
			$this->sql .= "WHERE id=" . $item->id;
            $result = $this->db->query($this->sql);
            $this->sql = null;
            return $result;
        }

        return false;
    }
	
	public function getItemByLinkID($aID) {
        $this->sql = "SELECT * FROM " . $this->db->addPrefix($this->tableName) . "
    				WHERE linkid='" . $this->db->escape_string($aID) ."'";
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) > 0) {
            if ($row = $this->db->fetch_assoc_array($result)) {
                $dg = new AffiliateLinkDTO();
                $dg->id = $row['id'];
                $dg->userid = $row['userid'];
                $dg->referlink = $row['referlink'];
				$dg->alias = $row['alias'];
				$dg->clickcount = $row['clickcount'];
				$dg->linkid = $row['linkid'];
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
	
	
	
	

	
	


    private function checkData($item) {
        return true;
    }

    public function getTableName() {
        return $this->db->addPrefix($this->tableName);
    }
}

?>