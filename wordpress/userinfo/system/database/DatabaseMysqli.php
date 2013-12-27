<?php
    /**
     * $id$
     */
    require_once("Database.php");
    
    /**
     * This is the mysqli database implemention
     *
     */
    class DatabaseMysqli extends Database
    {
        protected function connect($host, $port, $user, $pass, $dbName) {  
    		$port = $port ? $port : 3306;
            return (new mysqli($host, $user, $pass, $dbName, $port));
        }
        
        protected function setCharset($aCharset="utf8") {
            mysqli_set_charset($this->connection, $aCharset);
        }
        
        public function query($aQueryString) {
            return mysqli_query($this->connection, $aQueryString);
        }
        
        public function free($result) {
            return mysqli_free_result($result);
        }
        
        public function fetch_assoc_array($result){
            return mysqli_fetch_assoc($result);
        }
        
        public function escape_string($aString) {
            return $this->connection->real_escape_string($aString);
        }
        
        public function affect_rows($aResult) {
            return $this->connection->affected_rows;
        }
        
        public function getInsertID() {
            return $this->connection->insert_id;
        }
    }
?>