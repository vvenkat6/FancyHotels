<?php
setcookie("location",$_POST['Location']);
setcookie("edate",$_POST['edate']);
setcookie("sdate",$_POST['sdate']);
setcookie("visit","0");
?>
<html>
<head>
<style>
table, th, td {
     border: 1px solid black;
}

input[type="checkbox"]{ vertical-align: top; }
</style>
</head>

<body>
<center>
MAKE A RESERVATION
<br><br><br>
<?php
$location = $_POST['Location'];
$sdate = $_POST['sdate'];
$edate = $_POST['edate'];

include 'dbinfo.php' ;
session_start();

$_SESSION['loc'] = $location;
$_SESSION['sdate'] = $sdate;
$_SESSION['edate'] = $edate;

$days = (strtotime($edate) - strtotime($sdate)) / (60 * 60 * 24);

if($days < 0) { die("End date is lesser than Start date!");}

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$sql_query = "select * from ROOM where Location='$location' and Room_num not in(select RESERVATION_HAS_ROOM.Room_num from RESERVATION inner join RESERVATION_HAS_ROOM on RESERVATION.ReservationID = RESERVATION_HAS_ROOM.ReservationID where not Is_cancelled and RESERVATION_HAS_ROOM.Location='$location' and ('$sdate' Between RESERVATION.Start_Date and RESERVATION.End_Date || '$edate' Between RESERVATION.Start_Date and RESERVATION.End_Date))";

$result = mysql_query($sql_query)  or die(mysql_error());
if (mysql_num_rows($result) > 0) {
    echo "<table><tr><th>Room no</th><th>Room Category</th><th>#persons allowed</th><th>Cost/day</th><th>Cost of extra bed/day</th><th>Select Room</th></tr>";
    echo "<form action='Subesh.php' method='post'>";
    while($row = mysql_fetch_assoc($result)) {
        echo "<tr><td>".$row["Room_num"]."</td><td>".$row["Room_category"]."</td><td>".$row["Num_of_people"]."</td><td>".$row["Cost_per_day"]."</td><td>".$row["Cost_extra_bed"]."</td>";
	echo "<td><input type='checkbox' value=".$row["Room_num"]." name='Room[]'></td></tr>";
    }
    echo "</table><br><br>";
    echo "<input type=\"submit\" name=\"Details\" value=\"Check Details\" />";
    echo "</form>";
}

?>
</center>
</body>
</html>

