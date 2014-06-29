<?php

require_once(ROOT_PATH . "system/database/DatabaseFactory.php");
require_once("ItemRateRecordViewDTO.php");

class ItemRateRecordViewDAO {

    private $db;
    private $tableName = "jms-item-raterecord";
    private $sql = "";

    public function ItemRateRecordViewDAO() {
        $this->db = DatabaseFactory::getMysqliDatabase();
    }
	
	public function getItemByHashd($hashID) {
        $this->sql = "SELECT * FROM `" . $this->db->addPrefix($this->tableName) . "`
    				WHERE hash_id='" . $this->db->escape_string($hashID) . "'";
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) > 0) {
            if ($row = $this->db->fetch_assoc_array($result)) {
                $item = new ItemRateRecordViewDTO();
                $item->id = $row['id'];
                $item->name = $row['name'];
                $item->product_id = $row['product_id'];
                $item->hash_id = $row['hash_id'];
                $item->score = $row['score'];
                $this->db->free($result);
                $this->sql = null;
                return $item;
            } else {
                return false;
            }
        } else {
            return false;
        }
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
	
	
	
	
	public function getAllItems() {
        $dgList = array();
        $this->sql = "SELECT * FROM " . $this->db->addPrefix($this->tableName);
        $result = $this->db->query($this->sql);
        if ($this->db->affect_rows($result) != 0) {
            while ($row = $this->db->fetch_assoc_array($result)) {
                $dg = new DigitalGoodsDTO();
				$dg->id = $row['id'];
                $dg->itemid = $row['itemid'];
                $dg->name = $row['name'];
				$dg->price = $row['price'];
				$dg->file = $row['file'];
				$dg->fileType = $row['filetype'];
                $dgList[] = $dg;
            }

            $this->db->free($result);
            $this->sql = null;
        }

        return $dgList;
    }
	
	


    private function checkData($item) {
        return true;
    }

    public function getTableName() {
        return $this->db->addPrefix($this->tableName);
    }
}

?>