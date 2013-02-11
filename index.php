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
if (isset($_GET['color'])) {
  $color = $_GET['color'];
  $image = new image($height, $width, $color);
} else {
  $image = new image($height, $width);  
}


?>
