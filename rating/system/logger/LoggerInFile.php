<?php

/**
 * 	$id$
 */
require_once(ROOT_PATH . 'system/logger/Logger.php');
class LoggerInFile extends Logger {

    private static $instance;
    private $loggerFile = "logfile.txt";

    public function LoggerInFile() {
        
    }


    public static function getInstance() {
        if(!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }


    public function renderLogs() {
        $logfile = fopen($this->loggerFile, "a+");
        $logCount = count($this->logList);
        for ($i = 0; $i < $logCount; $i++) {
            $logger = $this->logList[$i];
            fwrite($logfile, date('Y-m-d G:i:s', $logger->time)."::".$logger->level."::".$logger->scriptName.
                    "::".$logger->functionName."::".$logger->parameters."::".$logger->message);
        }

        fclose($logfile);
        $this->logList = array();
    }
}

?>