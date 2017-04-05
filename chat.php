<?php
	session_start();
	include "connect.php";
	$username = $_SESSION['username'];
	include "printFriends.php";
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chatting</title>
	<script type="text/javascript">
		function sendMessage(friend)
		{
			var  xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function ()
			{
				if(this.status == 0 && this.readyState == 4)
				{

				}
			}
			xmlhttp.open("GET","sendMessage.php?message=".$message."&friend=".$friends,true);
			xmlhttp.send();
		}
	</script>
</head>
<body>
<?php
printFriendList($username);
?>
<div id="chatBox" style="position: fixed;bottom: 10px; height: 100px;border: 5px solid red; left: 10px;right: 10px;">
	<textarea id="message" style="width: 95%;height: 70%"></textarea>
	<button id="send" onclikck="sendMessage('..')"
</div>
</body>
</html>