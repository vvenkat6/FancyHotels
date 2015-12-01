<html>
<center>
NEW USER REGISTRATION
<br><br>
<?php
include 'dbinfo.php' ;

//starting the session
session_start();

if(isset($_POST['pass']))  {
	
	$err = 0;
        $user = $_POST['user'];
        $pass = $_POST['pass'];
	$pass2 = $_POST['pass2'];
	$email = $_POST['email'];
	
	if($user == '' || $pass == '' || $pass2 == '' || $email == ''){
		echo "All fields are required!";
		$err = 1;
	}
	if ($pass != $pass2){
		echo "Passwords do not match! Please try again.";
		$err = 1;
	}

	if($err == 0){
		mysql_connect($host,$username,$password) or die( "Unable to connect");;
        	mysql_select_db($database) or die( "Unable to select database");

		$sql_query = "INSERT INTO CUSTOMER VALUES('$user','$pass','$email')";
		$result = mysql_query($sql_query) or die("The username or password already exist!");
		if ($result){
			echo "Login Details accepted!";
		}
	}

}
?>
<body>

<form action="" method="post"><br><br>
<label>UserName :</label>
<input id="user" name="user" type="text"><br><br>
<label>Password :</label>
<input id="pass" name="pass" type="password"><br><br>
<label>Confirm Password :</label>
<input id="pass2" name="pass2" type="password"><br><br>
<label>Email :</label>
<input id="email" name="email" type="text"><br><br>

<input name="submit" type="submit" value="Submit"><br><br>
<span><?php echo $error; ?></span>
</form>
<a href='index.php'>Back to login Page</a>
</center>
</body>
</html>
