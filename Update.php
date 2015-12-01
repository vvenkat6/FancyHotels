<html>
<center>
<br>
UPDATE RESERVATION
<br><br><br>
Enter your Reservation ID: <br>
<form action=update.php method=POST>
	<input type="text" name="rnum">
	<input type="submit" value="Search">
</form>
<?php
$_SESSION['rnum']=$_POST['rnum'];
?>
</center>
</html>

