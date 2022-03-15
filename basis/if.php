<?php

$naam=readline("geef jouw naam:");
$leeftijd=readline("geef jouw leeftijd:");

echo"hallo $naam\n";
if($leeftijd<22){
    echo "jij bent jonger dan 22 jaar.\n";
}

if($leeftijd>22){
    echo"jij bent ouder dan 22 jaar.\n ";
}
if ($leeftijd==22) {
    echo "jij bent precies 22 jaar.\n";}
?>


