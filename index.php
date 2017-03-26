<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<script src="index.js"></script>
	<title>SQL project login page</title>
</head>
<body>
<form action="index.php" method="POST" name="login">
<input name="username" type="text" placeholder="username" />
<input name="password" type="password" placeholder="password" />
<input name="Submit" type="submit" value="login"/>
</form>




<?php

	$con = mysql_connect("localhost","root","1234");
	$db = mysql_select_db("eyebook");
	if(!$db)
	{
		echo "Connection unsuccesful";
	}
	else
	{
		echo "Connection Succesful";
	}

		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
//		echo "Connection succesful";
		
		if($db)
		{


			$password = $_SESSION['password'];
//			echo "Database connection succesful\n";
			$sql = "select * from profile where username = '".$_SESSION['username']."'";
			echo $sql;
			$row = mysql_query($sql);
			$retVal = mysql_fetch_assoc($row);
			if($retVal['password'] == $password && isset($_SESSION['username']) )
			{
				
				header("Location: profile.php");
			}
			else
			{
				echo "Enter the correct Password";
			}

		}
		else
		{
			echo "Database connection aborted"."<br/>";
		}
	



	

?>
</body>

</html>
