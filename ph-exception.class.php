<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ph-exception
 *
 * @author max
 */
class phException extends Exception {
  public $message;
  
  public function __construct($message) {
    //TODO: Add the ability to to return an image instead of text
    $this->message = $message;
  }
//put your code here
  public function returnError() {
    $errorMsg = "Error on line " . $this->getLine() . " in file " . $this->getFile() . ": <b>" . $this->getMessage() . "</b><br>";
    $errorMsg .= $this->message;
    return $errorMsg;
  }
}
?>
