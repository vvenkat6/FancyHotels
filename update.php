<?php
setcookie('resid',$_POST['rnum'],time()+3600);
?>
<html>
<center>
<br><br>
UPDATE RESERVATION
<br><br>

<?php
include 'dbinfo.php' ;
session_start();

$user = $_SESSION['username'];
$today = date("Y-m-d");
$id = $_POST['rnum'];

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$query = "SELECT * FROM RESERVATION WHERE ReservationID=$id and Username='$user'";
$result = mysql_query($query);


if(mysql_num_rows($result)>0){
	$row = mysql_fetch_assoc($result);
}else{
	echo "This reservation id does not belong to you!<br><br>";
}

echo "<br><br>Start date :". $row["Start_Date"]."<br>";
echo "<br>End date :". $row["End_Date"]."<br>";
echo "<br><br><br><br>";

$sdate = $row['Start_Date'];

$days = (strtotime($sdate) - strtotime($today)) / (60 * 60 * 24);


if($days>3){
	echo "<form action=\"uppu.php\" method=\"POST\">";
	echo "<p>New Start Date :";
	echo "<input id =\"sdate\" name=\"sdate\" size=\"9\" maxlength=\"10\" type=\"date\" min='$today'/>";
	echo "</p>";
	echo "<p>New End Date :";
	echo "<input id =\"edate\" name=\"edate\" size=\"9\" maxlength=\"10\" type=\"date\"/>";
	echo "</p>";
	echo "<input name=\"submit\" type=\"submit\" value=\"Search\"/>";

	$_SESSION['sdate']   = $_POST['sdate'];
	$_SESSION['edate']     = $_POST['edate'];
}elseif ($days>=0) {
	echo "<br>This reservation cannot be updated, only cancelled!<br>";
	echo "<a href='Cancel.php'>Go to cancel page!</a>";
}else{
	echo "<br>This cannot be altered!";
	echo "<br><a href='Umenu.php'>Main Menu</a>";
}
?>
</center>
</html>
