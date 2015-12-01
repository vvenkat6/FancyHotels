<html>
<center>
PAYMENT INFORMATION<br><br><br>

<?php
include 'dbinfo.php' ;
session_start();
setcookie("visit",2,time()+3600);
if(!isset($_COOKIE['valagain'])){
	setcookie("valagain",$_COOKIE['values'],time()+3600);
}
?>

<style>
.wrap {
	width: 100%;
	overflow:auo;
	}

.fleft {
    	float:left; 
    	width: 60%;
    	height: 500px;
	}

.fright {
	float: right;
    	height: 500px;
    	width: 40%;
}
</style>

<div class="wrap">
	<div class="fleft"><br><br><br>ADD A NEW CARD<br><br>
	<?php
	session_start();
	if(isset($_POST['cvv'])){
	
	$err = 0;
	$loc = $_SESSION['loc'];
	$edate = $_SESSION['edate'];
	$sdate = $_SESSION['sdate'];
	$user = $_SESSION['username'];
	$name = $_POST['name'];
        $dat = $_POST['dat'];
        $cvv = $_POST['cvv'];
        $num = $_POST['num'];
	$today = date("Y-m-d");
	echo $loc; echo $sdate; echo $edate;
	echo $user;

        if($name == '' || $dat == '' || $cvv == '' || $num == ''){
                echo "<br>All fields are required!<br>";
                $err = 1;
        }
	if($dat <= $today){
		echo "<br>Please enter a card with longer expiry date!<br>";
		$err = 1;
	}
	if($err == 0){
                mysql_connect($host,$username,$password) or die( "Unable to connect");;
                mysql_select_db($database) or die( "Unable to select database");

                $sql_query = "INSERT INTO PAYMENT_INFORMATION VALUES('$user','$name','$dat','$cvv','$num')";
                $result = mysql_query($sql_query) or die("This information exists!");
                if ($result){
                        echo "<br>Card Details accepted!<br>";
                }
        }
	}
	?>

	<form action="" method="post"><br><br>
	<label>Name on Card    :</label>
	<input id="name" name="name" type="text"><br><br>
	<label>Card Number     :</label>
	<input id="num" name="num" type="text"><br><br>
	<label>Expiration Date :</label>
	<input id="dat" name="dat" type="date"><br><br>
	<label>CVV             :</label>
	<input id="cvv" name="cvv" type="cvv"><br><br>

	<input name="save" type="submit" value="Save"><br><br>
	</form>
	</div>

	<div class="fright"><br><br><br>DELETE CARD<br><br><br>
	<?php
	session_start();

	mysql_connect($host,$username,$password) or die( "Unable to connect");;
        mysql_select_db($database) or die( "Unable to select database");

	$user = $_SESSION['username'];

	$q = "select Card_num from PAYMENT_INFORMATION where Username='$user'";
    	$cardnum = mysql_query($q);

    	echo "<br><br>Card Number";

	echo "<form action=\"delCard.php\" method=\"POST\">";
    	echo "<select name='Card_num' , id='Card_num'>";
    	while ($row = mysql_fetch_array($cardnum)) {
        	echo "<option value='" . $row['Card_num'] . "'>" . substr($row['Card_num'],-4) . "</option>";
        }
    	echo "</select>";
	echo "<br><br><br><br><br><br><input name=\"del\" type=\"submit\" value=\"Delete\"/>";
	echo "</form>";
	$_SESSION['delnum'] = $_POST['Card_num'];
	?>
	</div>    
</div>
<a href='SubRoom.php'>Continue booking</a>
</center>
</html>
