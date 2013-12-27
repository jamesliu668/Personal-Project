<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logrecord
 *
 * @author James
 */
class LoggerRecord {

    //put your code here
    public $time = '';
    public $level = '';
    public $scriptName = '';
    public $functionName = '';
    public $parameters = '';
    public $message = '';

    public function __construct() {
        $this->time = time();
    }

}

?>
