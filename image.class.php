<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("config.inc.php");

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
  private $_color;
  private $_text;
  private $_fontSize = 25;

  /**
   * 
   * @param type $height
   * @param type $width
   */
  public function __construct($height, $width, $color = "#FFCC00", $text = NULL) {
    if (($height != 0) && ($width != 0)) {
      $this->setHeight($width);
      $this->setWidth($width);
      $this->setColor($color);
      $this->setText($text);
          
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
    $this->_color = $color;
  }
  
  private function setText($text) {
    if ($text == NULL) {
      $this->_text = ($this->_width . "x" . $this->_height);
    } else {
      $this->_text = $text;
    }
  }
  
  private function newLogLine($text) {
    $filePointer = fopen(LOGPATH, "a");
    $timestamp = time();
    $time = date("[d.m.Y-H:i]", $timestamp);
    fwrite($filePointer, $time . $text);
    fclose($filePointer);
  }
  
  private function hexToRgb($hex) {
    
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
  }

  public function createImage() {
    if (($this->_height != 0) && ($this->_width != 0)) {
      
      header("Content-Type: image/png");
      $im = imagecreatetruecolor($this->_width, $this->_height);
      
      $color = $this->hexToRgb($this->_color);
      $imageColor = imagecolorallocate($im, $color[0], $color[1], $color[2]);
      imagefilledrectangle($im, 0, 0, $this->_width, $this->_height, $imageColor);
      
      $textColor = $this->hexToRgb("#FFFFFF");
      $textColorImage = imagecolorallocate($im, $textColor[0], $textColor[1], $textColor[2]);
      
      $font = "fonts/roboto/RobotoCondensed-Bold.ttf";
      $textSize = imagettfbbox($this->_fontSize, 0, $font, $this->_text);
      $x = (($this->_width - ($textSize[2]-$textSize[0])) / 2);
      $y = ((($this->_height) / 2) + (($textSize[1] - $textSize[7]) / 2) - (($textSize[1]) / 2));
      if(LOGGING) {
        $this->newLogLine("Set Text position: Image position - X: $x Y: $y, Text height:" . ($textSize[1]-$textSize[7]) . "\n");
      }
      imagettftext($im, $this->_fontSize, 0, $x, $y, $textColorImage, $font, $this->_text);
      
      imagepng($im);
      imagedestroy($im);
    } else {
      die("No image sizes given! IMPOSSIBRU!!!");
    }
  }

}

?>
