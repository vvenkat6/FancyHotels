<html>
<center>
<br>
CANCEL RESERVATION
<br><br>
<style>
table, th, td {
     border: 1px solid black;
}
</style>


<?php
include 'dbinfo.php' ;
$user = $_SESSION['username'];
$today = date("Y-m-d");
$id = $_POST['resnum'];

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$query = "SELECT * FROM RESERVATION WHERE ReservationID=$id";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

if(mysql_num_rows($result) > 0){
	echo "<br><br>Start date :". $row["Start_Date"]."<br>";
	echo "<br>End date :". $row["End_Date"]."<br>";
	$query = "SELECT * FROM RESERVATION_HAS_ROOM WHERE ReservationID=$id";	
	$result2 = mysql_query($query);

	if (mysql_num_rows($result2) > 0) {
		echo "<br><table><tr><th>Room no</th><th>Room Category</th><th>#persons allowed</th><th>Cost/day</th><th>Cost of extra bed/day</th><th>Extra bed</th></tr>";
		while ($row2 = mysql_fetch_array($result2)) {
			$query3 = "select * from ROOM where Room_num=".$row2['Room_num']." and Location='".$row2['Location']."'";
			$result3 = mysql_query($query3);
			$row3 = mysql_fetch_assoc($result3);
			echo "<tr><td>".$row2['Room_num']."</td><td>".$row3['Room_category']."</td><td>".$row3['Num_of_people']."</td><td>".$row3['Cost_per_day']."</td><td>".$row3['Cost_extra_bed']."</td><td>".$row2['Has_extra_bed']."</td></tr>";
		}
	}
echo "</table>";
}else{
	echo "<br><br>Reservation id not found!";
}

echo "<br><br>Total Cost of Reservation :". $row["Total_Cost"]."<br>";
echo "<br>Today's Date: $today<br>";

$sdate = $row["Start_Date"];
$days = (strtotime($sdate) - strtotime($today)) / (60 * 60 * 24);
$refund = 0;
$cost = $row["Total_Cost"];

if ($days > 3){
	$refund = $cost;
}elseif ($days > 1 && $days <= 3) {
	$refund = 0.8 * $cost;
}elseif ($days>0 && $days <= 1){
	$refund = 0;
}elseif ($days < 0){
	echo "<h2>Cannot be cancelled!</h2>";
}

echo "<br>Amount refunded: $refund<br>";

echo "<form action=cancon.php method=POST>";
if ($days>=0){
echo "<input type='submit' value='Cancel'>";}
echo "</form>";

$_SESSION['username'] = $user;
$_SESSION['cardnum'] = $row["Card_Num"];
$_SESSION['edate'] = $row["End_Date"];
$_SESSION['sdate'] = $sdate;
$_SESSION['cancel'] = 1;
$_SESSION['tot_cost'] = $cost;
$_SESSION['id'] = $id;
?>
<br><br><a href="Umenu.php">Back to main menu</a><br>
</center>
</html>
