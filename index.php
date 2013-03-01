<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("image.class.php");

$height = (int) $_GET['height'];
$width = (int) $_GET['width'];


//var_dump($height);
//echo "<br>";
//var_dump($width);
try {
  if (isset($_GET['color']) && !isset($_GET['text'])) {
    $color = $_GET['color'];
    $image = new image($height, $width, $color);
  } else if (isset($_GET['color']) && isset($_GET['text'])) {
    $color = $_GET['color'];
    $text = $_GET['text'];
    $image = new image($height, $width, $color, $text);    
  } else if (!isset($_GET['color']) && isset($_GET['text'])) {
    $text = $_GET['text'];
    $image = new image($height, $width, NULL, $text);    
  } else {
    $image = new image($height, $width);  
  }
} catch (phException $e) {
  echo $e->returnError();
}

?>
