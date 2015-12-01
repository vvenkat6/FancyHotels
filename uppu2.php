<html>
<center>
CONFIRMATION
<?php
include 'dbinfo.php' ;
session_start();
$user = $_SESSION['username'];

mysql_connect($host,$username,$password) or die( "Unable to connect");
mysql_select_db($database) or die( "Unable to select database");

$card=$_SESSION['cardnum'];
$sdate=$_SESSION['sdate'];
$edate=$_SESSION['edate'];
$iscancelled=0;
$totCost=$_SESSION['cost'];
$location = $_SESSION['loc'];
$rooms = unserialize($_COOKIE['final']);
$extra = $_POST['Extra'];

$q = "select max(ReservationID) from RESERVATION";
$res = mysql_query($q) or die("Couldnt assign number");
$temp = mysql_fetch_array($res);
$num = $_COOKIE['resid'];

#insert into reservation
$query = "update RESERVATION set End_Date='$edate', Start_Date='$sdate', Total_Cost=$totCost where ReservationID=$num";
$result = mysql_query($query) or die("Reservation failed! Please try again later!");

#insert into reservation_has_room
foreach($rooms as $r){
	if (in_array($r,$extra)){
		$bed = 1;
	}else{
		$bed = 0;
	}
	$query = "update RESERVATION_HAS_ROOM set Has_extra_bed=$bed";
	$result = mysql_query($query) or die("Reservation failed! Please try again later!");
}

echo "<h2> Your Reservation ID: ".$num." </h2>";
echo "<br>Your Reservation has been altered!<br>";
?>
<br>
<br>
<br><br>
Please save this reservation id for all further communication!

<br><br><a href="Umenu.php">Back to main menu</a><br>
<center>
</html>
