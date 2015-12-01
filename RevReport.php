<html>
<center>
REVENUE REPORT

<br><br><br>
<style>
table, th, td {
     border: 1px solid black;
}
</style>

<?php
include 'dbinfo.php' ;
session_start();
$user = $_SESSION['username'];

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$query = "select MONTH(RESERVATION.Start_date),RESERVATION_HAS_ROOM.Location, sum(RESERVATION.Total_cost) from RESERVATION_HAS_ROOM inner join RESERVATION on RESERVATION.ReservationID = RESERVATION_HAS_ROOM.ReservationID where MONTH(RESERVATION.Start_date) in (8,9) and not Is_cancelled group by MONTH(RESERVATION.Start_date),RESERVATION_HAS_ROOM.Location";
$result = mysql_query($query);

if (mysql_num_rows($result) > 0) {
        echo "<table><tr><th>Month</th><th>Location</th><th>Total Revenue</th></tr>";
        while($row = mysql_fetch_assoc($result)) {
                if($row['MONTH(RESERVATION.Start_date)'] == '8'){
                        echo "<tr><td>August</td>";
                }else{
                        echo "<tr><td>September</td>";
                }
                echo "<td>".$row["Location"]."</td><td>".$row["sum(RESERVATION.Total_cost)"]."</td></tr>";
        }
echo "</table>";
}
?>
<br><br><a href="Mmenu.php">Back to main menu</a><br>
</center>
</html>
