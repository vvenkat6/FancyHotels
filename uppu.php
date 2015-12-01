<style>
table, th, td {
     border: 1px solid black;
}

input[type="checkbox"]{ vertical-align: top; }
</style>
</head>

<body>
<center>
UPDATE RESERVATION
<br><br><br>

<script>
function myFunction() {
        alert("Clicked!");
        <?php
        echo "oho";
        ?>
}
</script>

<?php
include 'dbinfo.php' ;
session_start();

$sdate = $_POST['sdate'];
$edate = $_POST['edate'];
$_SESSION['sdate'] = $sdate;
$_SESSION['edate'] = $edate;
$id = $_COOKIE['resid'];
$days = (strtotime($edate) - strtotime($sdate)) / (60 * 60 * 24);
$user = $_SESSION['username'];

mysql_connect($host,$username,$password) or die( "Unable to connect");
mysql_select_db($database) or die( "Unable to select database");

$query = "SELECT * FROM RESERVATION WHERE ReservationID=$id";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$cardnum = $row['Card_Num'];
$_SESSION['cardnum'] = $cardnum; 

$query = "SELECT * from RESERVATION_HAS_ROOM WHERE ReservationID=$id";
$result = mysql_query($query)  or die(mysql_error());
$cost = 0;

if (mysql_num_rows($result) > 0) {
    echo "<table><tr><th>Room no</th><th>Room Category</th><th>#persons allowed</th><th>Cost/day</th><th>Cost of extra bed/day</th><th>Select Extra Bed</th></tr>";
    echo "<form action='uppu2.php' method='post'>";
    while($row = mysql_fetch_assoc($result)) {
	$rno = $row["Room_num"];
	$location = $row["Location"];

	$query = "select * from ROOM where Room_num=$rno and Location='$location'";
	$result2 = mysql_query($query);
	$row2 = mysql_fetch_assoc($result2);
        echo "<tr><td>".$row2["Room_num"]."</td><td>".$row2["Room_category"]."</td><td>".$row2["Num_of_people"]."</td><td>".$row2["Cost_per_day"]."</td><td>".$row2["Cost_extra_bed"]."</td>";
        echo "<td><input type='checkbox' value=".$row["Room_num"]." name='Room[]'></td></tr>";
	$cost = $cost + $row2["Cost_per_day"];
    }
    $cost = $cost * $days;
    echo "</table><br><br>";
    echo "<br>Total Cost:$cost<br><br>";
    $_SESSION['cost'] = $cost;
    $_SESSION['loc'] = $location;
    if ($days<0){ 
	echo "<br>Cannot proceed! End date is less than start date!<br>";
	echo "<br><br><a href='Umenu.php'>Back to main menu</a><br>";
    }else{
    	echo "<input type=\"submit\" name=\"Details\" value=\"Update\" />";
    }
    echo "</form>";
}



?>
</center>
</html>
