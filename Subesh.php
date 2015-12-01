<?php
setcookie("visit",1,time()+3600);
setcookie("values",serialize($_POST['Room']),time()+3600);

if($_COOKIE['visit']==0){
	setcookie("final",serialize($_POST['Room']),time()+3600);
}else{
	setcookie("final",$_COOKIE['valagain'],time()+3600);
}

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

<script>
$(document).ready(function() {
    $("input").click(function(event) {
        var total = 0;
        $("input:checked").each(function() {
            total += parseInt($(this).val());
        });
        
        if (total == 0) {
            $('#total').val('');
        }
        else {
            $('#total').val('$' + total);
        }
    });
});
</script>

<?php
include 'dbinfo.php' ;
session_start();

$location = $_COOKIE['location'];
$sdate = $_COOKIE['sdate'];
$edate = $_COOKIE['edate'];
$days = (strtotime($edate) - strtotime($sdate)) / (60 * 60 * 24);
if($_COOKIE['visit']==2 || $_COOKIE['visit']==1){
	$values = unserialize($_COOKIE['valagain']);
}else{
	$values = $_POST['Room'];
}
$user = $_SESSION['username'];

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$rooms = array();
foreach ($values as $v) { $rooms[] = $v;}
$rooms = implode ( ', ', $rooms);
$cost = 0;

$sql = "select * from ROOM where Location='$location' and Room_num in($rooms)";
$result = mysql_query($sql)  or die(mysql_error());

if (mysql_num_rows($result) > 0) {
    echo "<table><tr><th>Room no</th><th>Room Category</th><th>#persons allowed</th><th>Cost/day</th><th>Cost of extra bed/day</th><th>Extra Bed</th></tr>";
    echo "<form action='confirmR.php' method='post'>";
    while($row = mysql_fetch_assoc($result)) {
        echo "<tr><td>".$row["Room_num"]."</td><td>".$row["Room_category"]."</td><td>".$row["Num_of_people"]."</td><td>".$row["Cost_per_day"]."</td><td>".$row["Cost_extra_bed"]."</td>";
        echo "<td><input type='checkbox' value=".$row["Room_num"]." name='Extra[]'></td></tr>";
	$cost = $cost+$row["Cost_per_day"];
    }
    $cost = $cost * $days;
    echo "</table><br><br>";
    echo "Start Date: $sdate<br>End Date: $edate<br><br>";
    echo "Total Cost: <input type='text' id='total' value=$cost readonly>";
    $_SESSION['cost']=$cost;
    $query = "select Card_num from PAYMENT_INFORMATION where Username='$user'";
    $cardnum = mysql_query($query);

    echo "<br><br>Use Card ";
    echo "<select name='Number' , id='Number' required>";
    while ($row = mysql_fetch_array($cardnum)) {
    	echo "<option value='" . $row['Card_num'] . "'>" . substr($row['Card_num'],-4) . "</option>";
	}
    echo "</select>";
    echo "<a href='addCard.php'> Add Card</a>";

    echo "<br><br><br><input type=\"submit\" name=\"Submit\" value=\"Submit\" />";
    echo "</form>";
    $_SESSION['snum'] = $_POST['Number'];
}

?>
</center>
</body>
</html>
