<?php
session_start();
$username = $_SESSION['username'];
include "connection.php";





function printSentFriendRequests($username)
{
	///echo "Yess";
	$sql = "select user2 from friends where user1='".$username."' and areFriends = 0";
	//echo $sql;
	$row = mysql_query($sql);
	if($row)
	{
		//echo "<br>Keeeka<br>";
	}
	$numberOfRows = mysql_num_rows($row);
	echo "<table>";
	for ($i = 0 ;$i < $numberOfRows; $i++)
	{
		echo "<tr>";
		$retVal = mysql_fetch_assoc($row);
		$friend = $retVal['user2'];	



		if($friend)
		{
	//	echo "query unsuccesful";
		}
		echo "<td>".$friend."</td>";
		echo "<td><button id=\"".$friend."\" onclick=\"unfriend('".$friend."')\"> Friend Request Sent</button></td>\n";
		echo "</tr>";
	}
	echo "</table>";
}




function printRecievedFriendRequests($username)
{
	$sql = "select user1 from friends where user2='".$username."' and areFriends = 0";

	$row = mysql_query($sql);
	$numberOfRows = mysql_num_rows($row);
	if(!$numberOfRows)
	{
		echo "<br>No one<br>";
	}
	echo "<table>";
	for ($i = 0; $i < $numberOfRows; $i++){
		echo "<tr>";
		$retVal = mysql_fetch_array($row);
		$friend = $retVal[0];
		echo "<td>".$friend."</td>";
		echo "<td><button id=\"".$friend."\" onclick=\"acceptFriendRequest('".$friend."')\">
		Accept friend request</button></td>";
		echo "</tr>";
	}
	echo "</table>";

}





function printFriendList($username)
{
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
		echo "<button id=\"".$friend."\" onclick=\"unfriend('".$friend."')\">unfriend</button>\n";
	}
}





function printRecommendedFriends($username)
{
	$sql = "select username from profile where username not in";
	$sql .= "(select user1 from friends where user2='".$username."')";
	$sql .= " and username not in";
	$sql .= "(select user2 from friends where user1='".$username."')";
	$sql .= "and not username='".$username."'";






	//echo $sql;
	$row = mysql_query($sql);
	$numberOfRows = mysql_num_rows($row);
	//echo "<h1>Other People</h1>";
	echo "<table>";
	for ( $j = 0; $j < $numberOfRows; $j++)
	{
		$retVal = mysql_fetch_assoc($row);
		$other = $retVal['username'];
		$stillOther = $other;
		echo "<tr>";
		echo "<td>".$other."</td>";
		echo "<td><button id=\"".$other."\" onclick=\"sendFriendRequest('".$other."')\" value=\"0\">+Add Friend</button></td>";

	}
	echo "</table>";
}