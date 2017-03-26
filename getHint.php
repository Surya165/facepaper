<?php
echo "GetHint.php started";
include 'connect.php';
$db = mysql_select_db("eyebook");
$searchTerm = $_REQUEST['searchTerm'];
$sql = "select username as k from profile where k like  '%".$searchTerm."%'";
$row = mysql_query($sql);
$numberOfRows = mysql_num_rows($row);
for ($i = 0 ; $i < $numberOfRows ; $i ++)
{
	$retVal = mysql_fetch_array($row);
	echo $retVal[$i]."&nbsp";
}
?>