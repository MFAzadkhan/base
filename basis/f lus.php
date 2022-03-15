<?php
$begin=1;
$maximum=10;
$tekst="hello, World!\n";
for($teller=$begin;$teller<=$maximum;$teller++){echo $tekst;}
?>
<?php
$tafel=readline("welke tafel wil je zien");
$begin=1;
$eind=10;
echo "\n\ntafel van $tafel:\n";
for($teller=$begin;$teller<=$eind;$teller++)
{$product=$teller*$tafel;
    echo $teller."x". $tafel." = $product.";}
?>

<form action="" method="post">
    <label>
        <input type="text" name="num">
    </label>
    <button type="submit" name="submit">Guess</button>
    <button type="reset" name="Reset">Reset</button>
</form>
?>