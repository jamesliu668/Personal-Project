<?php
    /**
     * This is the database base class
     *
     * $id$
     */
    class Database {
        protected $databaseName;
        protected $connection;
        protected $dbprefix;
        
        public function Database($aHost, $aPort, $aDBName, $aUser, $aPass, $aPrefix='') {
            $this->databaseName = $aDBName;
            $this->dbprefix = $aPrefix;
            $this->connection = $this->connect($aHost, $aPort, $aUser, $aPass, $aDBName);
            $this->setCharset("utf8");
        }
        
        protected function connect($host, $port, $user, $pass, $aDBName) {  
        }
        
        protected function setCharset($aCharset) {
        }
        
        public function query($aQueryString) {
        }
        
        public function free($result) {
            
        }
        
        public function fetch_assoc_array($result){

        }
        
        public function escape_string($aString) {
            
        }
        
        public function affect_rows($aResult) {
            
        }
        
        public function addPrefix($aTableName) {
            return Config::DBPREFIX.$aTableName;
        }
        
        public function getInsertID() {
        }
    }
?>