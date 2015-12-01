<html>
<center>
SEARCH ROOMS
<br><br><br>

<?php
include 'dbinfo.php' ;
session_start();
$user = $_SESSION['username'];
$today = date("Y-m-d");

mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");

$query = "SELECT DISTINCT Location FROM ROOM";
$result = mysql_query($query);

echo "Location  ";
echo "<form action=\"Reserve.php\" method=\"POST\">";
echo "<select id='Location', name='Location'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['Location'] . "'>" . $row['Location'] . "</option>";
}
echo "</select>";
echo "<p>Start Date ";
echo "<input id =\"sdate\" name=\"sdate\" size=\"9\" maxlength=\"10\" type=\"date\" min='$today'/>";
echo "</p>";
echo "<p>End Date ";
echo "<input id =\"edate\" name=\"edate\" size=\"9\" maxlength=\"10\" type=\"date\"/>";
echo "</p>";
echo "<input name=\"submit\" type=\"submit\" value=\"Search\"/>";

$_SESSION['location']   = $_POST['Location'];
$_SESSION['sdate']   = $_POST['sdate'];
$_SESSION['edate']     = $_POST['edate'];

?>

</center>
</html>

