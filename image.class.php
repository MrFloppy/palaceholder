<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image
 *
 * @author max
 */
class image {

  /**
   * This var holds the width of the image to be generated
   * 
   * @var type integer
   */
  private $_width = 0;
  private $_height = 0;
  private $_color = 0x00FF0000;

  /**
   * 
   * @param type $height
   * @param type $width
   */
  public function __construct($height, $width, $color) {
    if (($height != 0) && ($width != 0)) {
      $this->setHeight($width);
      $this->setWidth($width);
      
      $this->setColor("0x00" . $color);
      
      $this->createImage();
    } else {
      die("Nothing to do here. No parameters, no work!");
    }
  }

  private function setWidth($width) {
    if (is_int($width)) {
      $this->_width = $width;
    }
    //TODO: Error handling
  }

  private function setHeight($height) {
    if (is_int($height)) {
      $this->_height = $height;
    }
    //TODO: Error handling
  }
  
  private function setColor($color) {
    $this->_color = (int) $color;
  }

  public function createImage() {
    if (($this->_height != 0) && ($this->_width != 0)) {
      header('Content-Type: image/png');
      $im = imagecreatetruecolor($this->_width, $this->_height);
      imagefilledrectangle($im, 0, 0, $this->_width, $this->_height, $this->_color);
      imagepng($im);
      imagedestroy($im);
    } else {
      die("No image sizes given! IMPOSSIBRU!!!");
    }
  }

}

?>
