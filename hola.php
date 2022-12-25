<?php

$char = 'G';
$intChar = ord($char);

$nextInt = $intChar + 1;
$nextChar = chr($nextInt);

// $charInt = intval($char);
// $newCharInt = $charInt + 'A';

echo $char . ' ' . $intChar;
echo $nextChar . ' ' . $nextInt;

echo 'genial' . 3;
