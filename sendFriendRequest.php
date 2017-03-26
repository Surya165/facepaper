<?php
session_start();
$con = mysql_connect("localhost","root","1234");
$user = $_SESSION['username'];
$friend = $_REQUEST['friend'];
//echo $user." ".$friend;
$db = mysql_select_db("eyebook");
echo $db;
$sql = "select * from friends where user1='".$user."' and user2='".$friend."'";
echo $sql;
$row = mysql_query($sql);
$numberOfRows = mysql_num_rows($sql);
if(!$numberOfRows)
{
	$sql = "insert into friends (user1,user2,areFriends) values ('".$user."','".$friend."',0)";
//echo $sql;
	$row = mysql_query($sql);
}

?>