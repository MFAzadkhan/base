<html>
<head>
    <title></title>
</head>
<body>


<h1> Ugani Random!</h1>


<?php
if(isset($_POST['submit']))
    $x = $_POST['x'];
$num = $_POST['num'];


$x = rand(1, 10)
if($num<$x)
{
    echo " Your number is higher! "<br/>
}


if($num==$x)
{
    echo " Correct! Press Reset to try again! "<br/>
}


if($num>$x)
{
    echo " Your number is lower! "<br/>
}


?>


<p>
<form>
    <input type="number" name="quantity"> <br />
    <button type="submit" value="<? echo $x?>">Submit</button>
    <button type="reset" value="<? echo $num?>">Reset</button>
</form>
</p>


</body>
</html>