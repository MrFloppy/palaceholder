<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$plain = 0x00000000;
$value = FF0000;
$correct = 0x00FF0000;

var_dump($plain);
var_dump($value);
var_dump($correct);

echo $plain . "<br>";
echo $value . "<br>";
echo $correct . "<br>";
$value = "0x00" . $value;
var_dump($value);
$value = (int) $value;
echo $value . "<br>";
//$value = $value;
?>
