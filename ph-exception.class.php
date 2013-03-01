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
//put your code here
  public function __construct() {
    $errorMsg = "Error on line " . $this->getLine() . " in file " . $this->getFile() . ": <b>" . $this->getMessage() . "</b>";
    return $errorMsg;
  }
}
?>
