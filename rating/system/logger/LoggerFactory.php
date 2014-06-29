<?php

/**
 * 	$id$
 */

require_once(ROOT_PATH . 'system/logger/LoggerInFile.php');
class LoggerFactory {
    const LOGTYPE_FILE = "logtype_file";

    public static function getLogEngine($type) {
        $logger = null;
        switch ($type) {
            case self::LOGTYPE_FILE:
                $logger = LoggerInFile::getInstance();
                break;
            default :
                $logger = LoggerInFile::getInstance();
        }

        return $logger;
    }

}

?>