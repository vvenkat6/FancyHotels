<html>
<center>
VIEW FEEDBACK
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

$query = "SELECT DISTINCT Location FROM ROOM";
$result = mysql_query($query);

echo "Hotel Location  ";
echo "<form action=\"#review\" method=\"POST\">";
echo "<select id='Location', name='Location'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['Location'] . "'>" . $row['Location'] . "</option>";
}
echo "</select>";
echo "<input name=\"check\" type=\"submit\" value=\" Check Reviews\"/>";
?>
<h1><a name="review">Reviews</a></h2>

<?php
$loc = $_POST['Location'];
echo "<h2>".$loc."</h2>";
$query = "select * from HOTEL_REVIEW where Location='$loc'";
$result = mysql_query($query)  or die(mysql_error());

if (mysql_num_rows($result) > 0) {
    	echo "<table><tr><th>Rating</th><th>Comment</th></tr>";
    	while($row = mysql_fetch_assoc($result)) {
        	echo "<tr><td>".$row["Rating"]."</td><td>".$row["Comment"]."</td></tr>";
	}
}
?>
</table>
<br><br><a href="Umenu.php">Back to main menu</a><br>
</center>
</html>
