<?php

/**
 * 	$id$
 */
require_once(ROOT_PATH . 'system/logger/LoggerRecord.php');

class Logger {
    const ERROR="ERROR";
    const WARNING="WARNING";
    const LOG="LOG";
    const MEASURE="MEASURE";

    protected $logList = array();
    protected $measureTime = array();

    public function Logger() {

    }

    public function startScript($aScriptName, $aFunctionName = null, $aParameter = null, $aMessage = null) {
        list($usec, $sec) = explode(" ", microtime());
        $this->measureTime[$aScriptName . "_start"] = array("sec" => $sec, "usec" => $usec);
        $this->addLog(Logger::MEASURE, $aScriptName, $aFunctionName, $aParameter, $aMessage);
    }

    public function stopScript($aScriptName, $aFunctionName = null, $aParameter = null, $aMessage = null) {
        if (isset($this->measureTime[$aScriptName . "_start"])) {
            list($usec, $sec) = explode(" ", microtime());
            //$this->measureTime[$aScriptName."_stop"] = array("sec"=>$sec, "usec"=>$usec);
            $cost = (float) $sec - (float) ($this->measureTime[$aScriptName . "_start"]["sec"]);
            $cost = $cost + ((float) $usec - (float) ($this->measureTime[$aScriptName . "_start"]["usec"]));
            $this->addLog(Logger::MEASURE, $aScriptName, $aFunctionName, $aParameter, "Time Consuming: " . $cost);
        } else {
            $this->addLog(Logger::WARNING, $aScriptName, $aFunctionName, $aParameter, "startScript is missing");
        }
    }

    /**
     * Add the log entry into log array
     *
     * @param unknown_type $aLevel a log level: error, warning, log, measure
     * @param unknown_type $aScriptName
     * @param unknown_type $aFunctionName
     * @param unknown_type $aParameter
     * @param unknown_type $aMessage
     */
    public function addLog($aLevel, $aScriptName, $aFunctionName, $aParameter, $aMessage) {
        $logObj = new LoggerRecord();
        $logObj->level = $aLevel;
        $logObj->scriptName = $aScriptName;
        $logObj->functionName = $aFunctionName;
        $logObj->parameters = print_r($aParameter);
        $logObj->message = $aMessage;
        $this->logList[] = $logObj;
    }

    public function renderLogs() {
        //write all logs in to log file
    }

}

?>