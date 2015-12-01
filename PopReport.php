<html>
<center>
POPULAR ROOM CATEGORY REPORT

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

$query = "select * from (select MONTH(Start_Date) as Month, Location, Room_Category, COUNT(*) as Count from RESERVATION inner join (select ReservationID, RESERVATION_HAS_ROOM.Location, Room_Category from RESERVATION_HAS_ROOM inner join ROOM on ROOM.Room_num = RESERVATION_HAS_ROOM.Room_num where ROOM.Location = RESERVATION_HAS_ROOM.Location) as ROOMS on RESERVATION.ReservationID = ROOMS.ReservationID where not Is_cancelled and MONTH(Start_Date) = 8 group by Location,Room_Category order by Count DESC) as dat group by Location";

$result = mysql_query($query);

if (mysql_num_rows($result) > 0) {
        echo "<table><tr><th>Month</th><th>Location</th><th>Category</th><th>Count</th></tr>";
        while($row = mysql_fetch_assoc($result)) {
                if($row['Month'] == '8'){
                        echo "<tr><td>August</td>";
                }else{
                        echo "<tr><td>September</td>";
                }
                echo "<td>".$row["Location"]."</td><td>".$row["Room_Category"]."</td><td>".$row["Count"]."</td></tr>";
        }
echo "</table>";
}
?>
<br><br><a href="Mmenu.php">Back to main menu</a><br>
</center>
</html>

