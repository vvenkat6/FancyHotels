<?php
#has information to connect to mysql server
include 'dbinfo.php' ; 
?>  

<html>
<title>Fance Hotel Login </title>
<body bgcolor="#000000">  
<center>
<font color="#ffffff">  
<p>ONLINE HOTEL RESERVATION PLATFORM</p>
<br /><br />
<b><p>SECURE LOGIN</p></b>
<br /><br />

<?php
//starting the session 
session_start(); 

if(isset($_POST['pass']))  {
	
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	
	//store session data
	$_SESSION['username']=$user;
	$_SESSION['password']=$pass;

	//connect to the db 
	mysql_connect($host,$username,$password) or die( "Unable to connect");;
	mysql_select_db($database) or die( "Unable to select database");


	//SQL Query
	$sql_query = "Select * From CUSTOMER where Username='$user' and Password='$pass'";  
	
	//Run sql query
	$result = mysql_query($sql_query)  or die(mysql_error());

	//Verification process
	if(mysql_numrows($result) > 0){		  
    		header('Location: Umenu.php');
	}else{ 
		$sql_query = "Select * From MANAGEMENT where Username='$user' and Password='$pass'";
		$result = mysql_query($sql_query)  or die(mysql_error());
		if(mysql_numrows($result) > 0){
			header('Location: Mmenu.php');
		}else{
		$err = 'Incorrect User Name or Password!' ; 
		}
	} 
	echo "$err";
} 

echo "<html>"; 
echo "<head>"; 
echo "</head>"; 
echo "<body>"; 
echo "<form action=\"\" method=\"POST\">"; 
echo "<p>User Name:";  
echo "<input id =\"user\" name=\"user\" size=\"9\" maxlength=\"20\" type=\"text\"/>"; 
echo "</p>"; 
echo "<p>Password:";
echo "<input id =\"pass\" name=\"pass\" size=\"9\" maxlength=\"25\" type=\"password\"/>";
echo "</p>";
echo "<input name=\"submit\" type=\"submit\" value=\"Login\"/>";
echo "</form>"; 
echo "</body>"; 
echo "</html>"; 
?>
<a href='newUser.php'>New User? Create Account</a>
</font>
</center>
</body>
</html>

