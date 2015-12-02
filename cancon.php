<html>
<center>
<?php
include 'dbinfo.php' ;
session_start();
$id = $_COOKIE['resnum'];

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$query = "update RESERVATION SET Is_cancelled=1 where ReservationID=$id";
$result = mysql_query($query) or die("Failed");
?>
<br><br><br>
Your booking has been cancelled!
<br><br>
<br><br><a href="Umenu.php">Back to main menu</a><br>
<center>
</html>
