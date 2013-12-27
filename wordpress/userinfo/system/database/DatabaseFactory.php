<?php 
    /**
     * $id$
     */
    require_once(ROOT_PATH."system/database/DatabaseMysqli.php");
    require_once(ROOT_PATH."/Config.php");
    
    /**
     * Database Singaleton
     * 
     * $id$
     */
    class DatabaseFactory
    {
        private static $dbMysqli;
        
        public function DatabaseFactory()
        {
            
        }
        
        public static function getMysqliDatabase()
        {
            if(!isset($dbMysqli))
            {
                $dbMysqli = new DatabaseMysqli(DB_HOST, Config::DBPORT, DB_NAME, DB_USER, DB_PASSWORD);
            }
            
            return $dbMysqli;
        }
    }
?>