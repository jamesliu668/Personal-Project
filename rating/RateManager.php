<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	define('ROOT_PATH', './');
	

	if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == "createnew")
	{
		showCreateRateView();
	}
	else if(!empty($_POST["action"]) && $_POST["action"] == "add")
	{
		if(!empty($_POST["projname"])
			&& !empty($_POST["rateitem"])
			&& !empty($_POST["projdesc"]))
		{
			addRateProject($_POST["projname"], $_POST["projdesc"], $_POST["rateitem"]);
		}
	}
	else if(!empty($_POST["action"]) && $_POST["action"] == "getitems")
	{
		if(!empty($_POST["projectid"]))
		{
			getItemListInJSON($_POST["projectid"]);
		}
	}
	else if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == "rating")
	{
		if(!empty($_REQUEST["score"])
			&& !empty($_REQUEST["itemid"]))
		{
			rating($_REQUEST["itemid"], $_REQUEST["score"]);
		}
		else
		{
			echo "false";
			exit;
		}
	}
	else if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == "getScore")
	{
		if(!empty($_REQUEST["itemid"]))
		{
			getScore($_REQUEST["itemid"]);
		}
		else
		{
			echo "0";
			exit;
		}
	}
	else
	{
		showRateProject();
	}
	
	function showCreateRateView()
	{
		require_once(ROOT_PATH."global.php");
		require_once(ROOT_PATH."views/header.php");
		require_once(ROOT_PATH."views/nav.php");
		require_once(ROOT_PATH."views/jumbotron.php");
		require_once(ROOT_PATH."views/addproject.php");
		require_once(ROOT_PATH."views/footer.php");
	}
	
	function rating($itemid, $score)
	{
		require_once(ROOT_PATH . "Utility.php");
		//check there is this itemid
		require_once(ROOT_PATH . "/model/RateItemDTO.php");
		require_once(ROOT_PATH . "/model/RateItemDAO.php");
		$rateItemDao = new RateItemDAO();
		$item = $rateItemDao->getItemByHashID($itemid);
		if($item != null)
		{
			require_once(ROOT_PATH . "/model/RateRecordDTO.php");
			require_once(ROOT_PATH . "/model/RateRecordDAO.php");
			$ratingdao = new RateRecordDAO();
			//check if this item is rated within 24 hours
			
			//rate
			$rating = new RateRecordDTO();
			$rating->item_id = $item->id;
			$rating->score = $score;
			$rating->rate_time = date("Y-m-d H:i:s");
			$rating->remote_ip = getUserIP();
			$recordID = $ratingdao->add($rating);
			if ($recordID != false && $recordID != 0)
			{
				echo("true");
				exit;
			}
			else
			{
				echo("false");
				exit;
			}
		}
		
		echo("false");
		exit;
	}
	
	function getScore($hashID)
	{
		require_once(ROOT_PATH . "/model/ItemRateRecordViewDTO.php");
		require_once(ROOT_PATH . "/model/ItemRateRecordViewDAO.php");
		$ratingdao = new ItemRateRecordViewDAO();
		$item = $ratingdao->getItemByHashd($hashID);
		if($item != false)
		{
			echo $item->score;
			exit;
		}
		
		echo "0";
		exit;
	}
	
	function showRateProject()
	{
		require_once(ROOT_PATH."global.php");
		require_once(ROOT_PATH."views/header.php");
		require_once(ROOT_PATH."views/nav.php");
		require_once(ROOT_PATH."views/jumbotron.php");
		
		require_once(ROOT_PATH . "/model/ProductDTO.php");
		require_once(ROOT_PATH . "/model/ProductDAO.php");
		$projDAO = new ProductDAO();
		$projectList = $projDAO->getAllItems();
		
		require_once(ROOT_PATH."views/viewproject.php");
		require_once(ROOT_PATH."views/footer.php");
	}
	
	function getItemListInJSON($projectId)
	{
		require_once(ROOT_PATH . "/model/RateItemDTO.php");
		require_once(ROOT_PATH . "/model/RateItemDAO.php");
		$rateItemDao = new RateItemDAO();
		$itemList = $rateItemDao->getItemByProductID($projectId);
		
		$json = "{\"item\": [";
		if(count($itemList) > 0)
		{
			foreach($itemList as $k=>$v)
			{
				$json = $json . "\"" . $v->hash_id . "\",";
			}
			
			$json = substr($json, 0, -1);
		}
		$json = $json ."]}";
		
		echo $json;
	}
	
	function addRateProject($projectName, $projectDesc, $rateItemList)
	{
		$projectName = trim($projectName);
		$projectDesc = trim($projectDesc);
		if($projectName === "")
		{
			return false;
		}
		
		if(!is_array($rateItemList))
		{
			return false;
		}
		else
		{
			foreach($rateItemList as $k=>$v)
			{
				if(!trim($v))
				{
					return false;
				}
			}
		}
		
		require_once(ROOT_PATH . "/model/ProductDTO.php");
		require_once(ROOT_PATH . "/model/ProductDAO.php");
		$projDAO = new ProductDAO();
		$proj = new ProductDTO();
		$proj->name = $projectName;
		$proj->description = $projectDesc;
		$projectID = $projDAO->add($proj);
		if ($projectID !== false)
		{
			$proj->id = $projectID;
			//add rate items
			require_once(ROOT_PATH . "/model/RateItemDTO.php");
			require_once(ROOT_PATH . "/model/RateItemDAO.php");
			require_once(ROOT_PATH . "Utility.php");
			$rateItemDao = new RateItemDAO();
			foreach($rateItemList as $k=>$v)
			{
				$rateItem = new RateItemDTO();
				$rateItem->name = trim($v);
				$rateItem->projectID = $projectID;
				$rateItem->hash_id = mt_rand_str(10);
				$rateItemID = $rateItemDao->add($rateItem);
				if(!$rateItemID)
				{
					echo "Adding Rate Item Failed!";
					return false;
				}
			}
			
			echo "Adding Project Successfully!";
		}
		else
		{
			echo "Adding Project Failed!";
			return false;
		}
	}
?>