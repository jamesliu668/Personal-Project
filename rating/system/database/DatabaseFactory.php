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
                $dbMysqli = new DatabaseMysqli(Config::DBSERVER, Config::DBPORT, Config::DBNAME, Config::DBUSERNAME, Config::DBPASSWORD);
            }
            
            return $dbMysqli;
        }
    }
?>