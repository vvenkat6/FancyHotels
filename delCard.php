<html>
<center>
<?php
include 'dbinfo.php' ;
session_start();

$user = $_SESSION['username'];
$delnum = $_POST['Card_num'];

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");


$query = "delete from PAYMENT_INFORMATION where Card_num=$delnum and Card_num not in(select Card_num from RESERVATION)";

$result = mysql_query($query) or die("This card cannot be deleted!");
echo "<br> This card was deleted! <br>";

?>
<a href="addCard.php">Back to add card</a>
<center>
</html>
