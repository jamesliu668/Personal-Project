<?php
class DataProcessor {
    /**
     * @var mysqli
     */
    private $con = null;
    
    public function __construct() {
		//$this->con = new mysqli('db-host', 'db-user', 'db-password', 'db-name', 3306);
        $this->con = new mysqli ( 'localhost', 'root', '', 'php_jquery_rating' );
        
        if ($this->con->connect_error) {
            die ( 'Connect Error: ' . $this->con->connect_error );
        }
    }
    
    public function __destruct() {
        $this->con->close ();
    }
    
    public function getProductsAction() {
        $productList = array();
        $sql = "SELECT p.shortname, CAST(FLOOR(AVG(r.score)*2)/2 AS DECIMAL(2,1)) As score,  count(r.score) As total FROM product p
    LEFT JOIN product_rating r ON p.shortname=r.shortname
    GROUP BY p.id;";

		if ($result = $this->con->query ( $sql )) {
            //$productList = $result->fetch_all ( MYSQLI_ASSOC );
			while ($row = mysqli_fetch_assoc($result)) {
				$productList[] = $row;
			}

            $result->close();
        }

        echo json_encode(array("success"=>true,"data"=>$productList));
    }
    
    /**
     * 
     * add raty to database
     */
    public function addRatyAction() {
        try {
            $sql = "INSERT INTO product_rating 
            	(shortname,score,create_time,remote_ip)
            	VALUES(?,?,NOW(),?)";
            
            $productId = $_REQUEST['shortname'];
            $score = $_REQUEST['score'];
            $remote_id = $_SERVER['REMOTE_ADDR'];
            
            if (empty ( $productId ) || ! isset ( $score )) {
                throw new Exception ( "the parameters are not correct." );
            }
			
			ini_set("session.gc_maxlifetime", 24*3600);
			
			$sessionCookieExpireTime = 24*3600;
			session_set_cookie_params($sessionCookieExpireTime);
			session_name("catfoodratings");
			session_start();
			
			if(isset($_SESSION[$productId])) {
				echo json_encode(array("success"=>false, "msg"=>"You vote this cat food brand already."));
				return;
			}
            
            if ($stmt = $this->con->prepare ( $sql )) {
                $stmt->bind_param ( "sds", $productId, $score, $remote_id );
                
                $stmt->execute ();
                
                if ($stmt->affected_rows == 0) {
                    throw new Exception ( "Insert data failed." );
                }
				
				$productList = array();
				$sql = "SELECT p.shortname, CAST(FLOOR(AVG(r.score)*2)/2 AS DECIMAL(2,1)) As score,  count(r.score) As total FROM product p
					LEFT JOIN product_rating r ON p.shortname=r.shortname WHERE r.shortname=\"".$productId."\"
					GROUP BY p.id;";
				
				if ($result = $this->con->query ( $sql )) {
					$productList = $result->fetch_all ( MYSQLI_ASSOC );
					$result->close ();
				}
				
				if (isset($_COOKIE[session_name()])) {
					setcookie(session_name(), $_COOKIE[session_name()], time() + $sessionCookieExpireTime);
				}
				
				$_SESSION[$productId] = 1;
				
				echo json_encode(array("success"=>true,"data"=>$productList));
            }
        } catch ( Exception $e ) {
            echo json_encode ( array ("success" => false, "msg" => $e->getMessage () ) );
        }
    
    }

}

$actionName = $_REQUEST ['action'];

$dataProcessor = new DataProcessor ();

if (! method_exists ( $dataProcessor, $actionName . "Action" )) {
    die ( "Action [$actionName] does not exist. " );
}

call_user_func ( array ($dataProcessor, $actionName . "Action" ) );

?>