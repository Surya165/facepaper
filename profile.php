<?php
	session_start();
	include "connect.php";
	//unset($_POST['username']);
	//echo $_COOKIE['name'];
	if(isset($_SESSION['username']))
	{
	}
	//else{
	//	session_destroy();
	//	header("Location: index.php");
			# code...
	//}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>profile page</title>
	<script src="profile.js">
	function printThis()
	{
		window.alert("This is working");
	}
	</script>
</head>
<body>
<form action="logout.php">
	<button>LOG OUT</button>
</form>










<?php
$username = $_SESSION['username'];
if($con)
{






	$db = mysql_select_db("eyebook");
	if ( $db )
	{
		echo "Database connection Succesful<br>";
	}





	//shows details	
	$sql = "select * from profile";
	echo $sql;
	$row = mysql_query($sql);
	$retVal = mysql_fetch_array($row);
	$numberOfFields = mysql_num_fields($row);
	for ( $i = 0; $i < $numberOfFields ; $i ++){
		if($i != 1)
			echo $retVal[$i]."<br/>";
	}










	echo "<br><br><br><br><br><h1>People who sent you friend requests</h1>";
	/**shows friend requests that are to be accepted;
	*/
	$sql = "select user1 from friends where user2='".$username."' and areFriends = 0";

	$row = mysql_query($sql);
	$numberOfRows = mysql_num_rows($row);
	if(!$numberOfRows)
	{
		echo "<br>No one<br>";
	}
	for ($i = 0; $i < $numberOfRows; $i++){
		$retVal = mysql_fetch_array($row);
		$friend = $retVal[0];
		echo $friend." ";
		echo "<button id=\"".$friend."\" onclick=\"acceptFriendRequest('".$friend."')\">Accept friend request</button><br>";

	}
	



	echo "<br><br><br><br><br><h1>People you are friends with</h1>";
	//shows friends
	$sql = "select username from profile where username in (select user1 from friends where user2='".$username."' and areFriends = 1) or username in (select user2 from friends where user1='".$username."' and areFriends=1)";
	
	$row = mysql_query($sql);
	$numberOfRows = mysql_num_rows($row);
	if(!$numberOfRows)
	{
		echo "Hello ".$username." it looks like you don't have any friends. Send friend requests to people.";
	}
	for ( $i = 0; $i < $numberOfRows; $i ++)
	{

		$retVal = mysql_fetch_array($row);
		$friend = $retVal[0];
		echo $friend." ";
		echo "<button id=\"".$friend."\" onclick=\"unfriend('".$friend."')\">unfriend</button>";
	}







	//shows recomended friends
	echo "<h1>People you may know</h1>";
	$sql = "select username from profile where username not in";
	$sql .= "(select user1 from friends where user2='".$username."')";
	$sql .= " and username not in";
	$sql .= "(select user2 from friends where user1='".$username."')";
	$sql .= "and not username='".$username."'";






	//echo $sql;
	$row = mysql_query($sql);
	$numberOfRows = mysql_num_rows($row);
	//echo "<h1>Other People</h1>";
	for ( $j = 0; $j < $numberOfRows; $j++)
	{
		$retVal = mysql_fetch_assoc($row);
		$other = $retVal['username'];
		$stillOther = $other;
		echo $other." ";
		echo "<button id=\"".$other."\" onclick=\"sendFriendRequest('".$other."','".$username."')\">+Add Friend</button>";

	}
}
?>
</body>
</html>