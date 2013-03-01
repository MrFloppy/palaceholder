<?php

/**
 * This class creates placeholder images
 * 
 * @author Maximilian Sohrt
 * @version 0.8
 * @todo Exception Handling and type-checking
 */

/**
 * Include global config values
 */
include("config.inc.php");

/**
 * Include custom exception handling
 */
include("ph-exception.class.php");

/**
 * Class for the creation of placeholder images
 *
 * @author Maximilian Sohrt
 * 
 */
class image {

  /**
   * Holds the width of the image to be generated
   * 
   * @default 0 which triggers no calculation
   * @var integer
   */
  private $_width = 0;
  
  /**
   * Holds the height of the image to be generated
   * 
   * @default 0 which triggers no calculation
   * @var integer
   */
  private $_height = 0;
  
  /**
   * Holds the backgroundcolor of the image
   * Needs to be hex (e.g. #FFFFFF or #000)
   * 
   * @var string
   */
  private $_color;
  
  /**
   * The text to be shown on the image
   *
   * @var string
   * @todo Needs to be properly implemented
   */
  private $_text;
  
  /**
   * Defines the font-size of the text in the image
   * 
   * @var integer
   * @todo needs automatic calculation to fit the image (e.g. x% of image width)
   */
  private $_fontSize = DEFAULT_FONT_SIZE;

  /**
   * Refers to all methods needed to create an image
   * 
   * @param integer $height Height of image in pixel
   * @param integer $width Width of image in pixel
   * @param string $color default: #FFCC00
   * @param string $text default: NULL
   */
  public function __construct($height, $width, $color = "#FFCC00", $text = NULL) {
    if (($height != 0) && ($width != 0)) {
      
     if ($width > MAX_WIDTH) {
       throw new phException("Too big width");
       exit;
     }
      $this->setWidth($width);
     
     if ($height > MAX_HEIGHT) {
       throw new phException("Too big height");
       exit;
     }
      $this->setHeight($height);

      $this->setColor($color);
      $this->setText($text);
          
      $this->createImage();
    } else {
      die("Nothing to do here. No parameters, no work!");
    }
  }

  /**
   * Sets the width of the image
   * 
   * @param integer $width
   */
  private function setWidth($width) {
    if (is_int($width)) {
      $this->_width = $width;
    }
    //TODO: Error handling
  }

  /**
   * Sets the height of the image
   * 
   * @param integer $height
   */
  private function setHeight($height) {
    if (is_int($height)) {
      $this->_height = $height;
    }
    //TODO: Error handling
  }
  
  /**
   * Sets the backgroundcolor of the image
   * 
   * @param string $color
   */
  private function setColor($color) {
    $this->_color = $color;
  }
  
  /**
   * Sets the text for the image
   * 
   * @todo Implement real text
   * @param string $text
   */
  private function setText($text) {
    if ($text == NULL) {
      $this->_text = ($this->_width . "x" . $this->_height);
    } else {
      $this->_text = $text;
    }
  }
  
  /**
   * Sets the font size depending on settings (static or dynamic)
   */
  private function setFontSize() {
    if(STATIC_FONT_SIZE) {
      $this->_fontSize = DEFAULT_FONT_SIZE;
    } else {
      $this->_fontSize = $this->calculateFontSize();
    }
  }
  
  /**
   * Creates a new line in the log file, prefixed with time and date
   * 
   * @param string $text
   */
  private function newLogLine($text) {
    if (strlen($text) == 0) {
      return;
    }
    $filePointer = fopen(LOGPATH, "a");
    $time = date("[d.m.Y-H:i]", time());
    fwrite($filePointer, $time . $text . "\n");
    fclose($filePointer);
  }
  
  /**
   * Convert hex color to RGB
   * 
   * @param type $hex
   * @return type
   */
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
  
  /**
   * Calculates font size depending on image dimensions and font choosen
   * 
   * @return integer The dynamic calculated font size
   */
  private function calculateFontSize() {
    $textWidthMax = ($this->_width * (TEXT_WIDTH_PERCENTAGE/100));
    $textHeightMax = ($this->_height * (TEXT_HEIGHT_PERCENTAGE/100));
    
    //$logOutput = "TextMaxWidth: $textWidthMax TextMaxHeight: $textHeightMax"; DISABLED FOR FUTURE DEBUG MODE
    
    
    //Let's first get the maximum height that is allowed
    $fontSize = ceil($textHeightMax);
    $textLength = strlen($this->_text) * 0.8;
    
    //Calculate the width of one letter
    $textSize = imagettfbbox($fontSize, 0, FONT, CALCULATION_LETTER);
    $letterWidth = ($textSize[2]-$textSize[0]);
    
    //$logOutput .= "Calculated MaxWidth: " . ($fontSize * $textLength) . "Letter width: " . $letterWidth; DISABLED FOR FUTURE DEBUG MODE
    
    //Now let's see if this font-size also fits for the width
    if (($letterWidth * $textLength) >= $textWidthMax) {
      $fontSize = ($textWidthMax / $textLength);
    }
    
    //$logOutput .= "Choosen font-size: " . $fontSize; DISABLED FOR FUTURE DEBUG MODE
    //$this->newLogLine($logOutput);
    
    return $fontSize;
  }

  /**
   * Renders the image
   * 
   * @todo Move some function-calls into a new method
   */
  public function createImage() {
    if (($this->_height != 0) && ($this->_width != 0)) {
      
      //TODO: Change type for output image
      header("Content-Type: image/png");
      
      //Set width and height
      $im = imagecreatetruecolor($this->_width, $this->_height);
      
      //Recalculate colors and set them
      $color = $this->hexToRgb($this->_color);
      $imageColor = imagecolorallocate($im, $color[0], $color[1], $color[2]);
      imagefilledrectangle($im, 0, 0, $this->_width, $this->_height, $imageColor);
      
      //Change text color
      //TODO: Move this to config.inc.php
      //TODO: Make this dynamic
      $textColor = $this->hexToRgb("#FFFFFF");
      $textColorImage = imagecolorallocate($im, $textColor[0], $textColor[1], $textColor[2]);
      
      //Calculate text size in image
      $this->setFontSize();
      $textSize = imagettfbbox($this->_fontSize, 0, FONT, $this->_text);
      //Calculate the position of the text
      $x = (($this->_width - ($textSize[2]-$textSize[0])) / 2);
      $y = ((($this->_height) / 2) + (($textSize[1] - $textSize[7]) / 2) - (($textSize[1]) / 2));
      //If enabled, do a line of logging here
      if(LOGGING) {
        $this->newLogLine("Set Text position: Image position - X: $x Y: $y, Text height:" . ($textSize[1]-$textSize[7]));
      }
      //Finally create the text
      imagettftext($im, $this->_fontSize, 0, $x, $y, $textColorImage, FONT, $this->_text);
      
      //TODO: Change type for output image
      imagepng($im);
      imagedestroy($im);
    } else {
      die("No image sizes given! IMPOSSIBRU!!!");
    }
  }

}

?>
