<?php
setcookie('visit',5,time()+3600);
?>
<html>
<center>
CONFIRMATION
<?php
include 'dbinfo.php' ;
session_start();
$user = $_SESSION['username'];

mysql_connect($host,$username,$password) or die( "Unable to connect");
mysql_select_db($database) or die( "Unable to select database");

$card=$_POST['Number'];
$sdate=$_COOKIE['sdate'];
$edate=$_COOKIE['edate'];
$iscancelled=0;
$totCost=$_SESSION['cost'];
$location = $_COOKIE['location'];
$rooms = unserialize($_COOKIE['final']);
$extra = $_POST['Extra'];

$q = "select max(ReservationID) from RESERVATION";
$res = mysql_query($q) or die("Couldnt assign number");
$temp = mysql_fetch_array($res);
$num = $temp['max(ReservationID)'];

if($_COOKIE['visit']==5){
	$num = $num - 1;
}else{
	$num = $num + 1;
}

#insert into reservation
$query = "insert into RESERVATION values('$user',$card,$num,'$sdate','$edate',$iscancelled,$totCost)";
$result = mysql_query($query) or die("Reservation failed! Please try again later!");

#insert into reservation_has_room
foreach($rooms as $r){
	if (in_array($r,$extra)){
		$bed = 1;
	}else{
		$bed = 0;
	}
	$query = "insert into RESERVATION_HAS_ROOM values($num,$r,'$location',$bed)";
	$result = mysql_query($query) or die("Reservation failed! Please try again later!");
}

echo "<h2> Your Reservation ID: ".$num." </h2>"
?>
<br>
<br>
<br><br>
Please save this reservation id for all further communication!

<br><br><a href="Umenu.php">Back to main menu</a><br>
<center>
</html>
