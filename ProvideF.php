<html>
<center>
PROVIDE FEEDBACK
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

if(isset($_POST['comment']))  {
        $user = $_SESSION['username'];
        $rate = $_POST['rate'];
        $loc = $_POST['Location'];
        $comment = $_POST['comment'];

        $q = "select max(Review_number) from HOTEL_REVIEW";
        $res = mysql_query($q) or die("Couldnt assign number");
        $temp = mysql_fetch_array($res);
	$num = $temp['max(Review_number)'];
	$num = $num + 1;

	$query = "insert into HOTEL_REVIEW VALUES('$user','$comment','$loc','$rate','$num')";
	$result = mysql_query($query) or die("This review was not accepted! Please try again!");
        if ($result){
        	echo "Review accepted!<br><br>";
        }
}



$query = "SELECT DISTINCT Location FROM ROOM";
$result = mysql_query($query);

echo "Hotel Location  ";
echo "<form action=\"\" method=\"POST\">";
echo "<select id='Location', name='Location'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['Location'] . "'>" . $row['Location'] . "</option>";
}
echo "</select>";
?>
<br><br>
<label>Rating :</label>
<select id='rate', name='rate'>
<option value=5>5</option>
<option value=5>4</option>
<option value=5>3</option>
<option value=5>2</option>
<option value=5>1</option>
</select>
<br><br>
<label>Comment :</label><br>
<input id="comment" name="comment" type="text" maxlength="300" size="50" required><br><br>
<?php
echo "<input name=\"submit\" type=\"submit\" value=\" Submit\"/>";
echo "</form>"
?>
<br><br><a href="Umenu.php">Back to main menu</a><br>
</center>
</html>

