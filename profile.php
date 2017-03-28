<?php
	session_start();
	include "connect.php";
	unset($_POST['username']);
	//echo $_COOKIE['name'];
	if(isset($_SESSION['username']))
	{
	}
	else{
	session_destroy();
	header("Location: index.php");
			# code...
	}	
	$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>profile page</title>
	<script src="profile.js">
	</script>
	<script type="text/javascript">
	function friends(friend,username)
	{
		var btn = document.getElementById(friend);
		var i = btn.value;
		switch(i)
		{
			case 0:
				btn.value = 3;
				sendFriendRequest(friend,username);
				break;
			case 1:
				btn.value = 0;
				unfriend(friend);
				break;
			case 2:
				btn.value = 1;
				acceptFriendRequest(friend);
				break;
			case 3:
				btn.value = 0;
				unfriend(friend);
		}
	}









	function unfriend(friend)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)	
			{
			//window.alert(this.responseText);
			
				var btn = document.getElementById(friend);
				btn.innerHTML = "+ Add Friend";
				btn.onclick = "sendFriendRequest("+ friend+")";
				
			}
		}
		xmlhttp.open("GET","unfriend.php?friend="+friend,true);
		xmlhttp.send();
	}

	function acceptFriendRequest(friend)
	{
	
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)
			{
				//window.alert(this.responseText);
				var btn = document.getElementById(friend);
				btn.innerHTML = "Friends";
					btn.onclick="";
			}
		}
		xmlhttp.open("GET","acceptFriendRequest.php?requester=" + friend,true);
		xmlhttp.send();
	}
	function sendFriendRequest(friend)
	{
		var btn = document.getElementById(friend);
		//window.alert(btn.value);
		btn.innerHTML = "Friend Request Sent";
		
	//indow.alert(friend);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
		//window.alert("yes");
			if(this.readyState == 4 && this.status == 200)
			{
	//		window.alert(this.responseText);
			var x = this.responseText;
			}

		}
		xmlhttp.open("GET","sendFriendRequest.php?friend=" + friend,true);
		xmlhttp.send();
	}



	var t = 0;
	function toggle()
	{
		var e = document.getElementById("test");
		var btn = document.getElementById("btn");
		switch(t)
		{
			case 0:
				window.alert(btn.value);
				btn.value = 1;
				e.innerHTML = "1";
				t = 1;
				break;
		
			case 1:
				window.alert(btn.value);
				btn.value = 0;
				t = 0;
				e.innerHTML = "0";
		}

	}






	function deletePost(id)
	{
		var xmlhttp = new XMLHttpRequest();
		var btn = document.getElementById(id);
		xmlhttp.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)
			{
				btn.style.display = "none";
				var post = document.getElementById()
			}
		}
	}
	</script>
</head>
<body>
<form action="logout.php">
	<button>LOG OUT</button>
</form>
<button onclick="toggle()" value="0" id="btn">Click This</button>
<div id="test" style="width:100px;height: 100px;"></div> 










<div id="post" style="border:1px solid black;padding: 10px;border-radius: 2px; margin:0px 25% 0px 25%">
	<!--form  id="text" action = "profile.php" method="POST">
				<input type="submit" name="post" value="post">
	</form-->


	<form id="text" name="imageUpload" action="profile.php" enctype="multipart/form-data" method="POST">
	
	<textarea form="text" placeholder="Post your Status" name="text"></textarea>
	<input type="file" name="image" value="image"/>
	<input type="submit" name="post" value="post"/>
	</form>
</div>



<?php
include "postManager.php";
if(isset($_POST['post']))
{
	$sql = "select max(id) from images";
	$row = mysql_query($sql);
	$retVal = mysql_fetch_array($row);
	$id = $retVal[0] + 1;//gets the id of the last image + 1
	//echo $id;

	//echo $id;
	$image = $_FILES['image'];
	$imageAddress = $home."images/image".$id;
	$text = $_POST['text'];
	$acceptImage = 	isset($_FILES['image']) && basename($_FILES['image']['name']) != $_SESSION['recentImage'];
	if($acceptImage)
	{
		//echo "Image is accepted";
		
			$fileName = basename($_FILES['image']['name']);
			$sql = "insert into images (imageName) value ('".$fileName."')";
			$row = mysql_query($sql);
			$home = "/var/www/html/images/";
			
			if(move_uploaded_file($_FILES['image']['tmp_name'], $imageAddress))
			{
				$_SESSION['recentImage'] = basename($_FILES['image']['name']);
				$_SESSION['id'] = $id;
			//	echo "file uploaded";
			}
			else
			{			
			}
		
	}
	$acceptText =isset($text) && $_SESSION['text'] != $text;
	if($acceptText)
	{
		//echo "Boolean is working";
		$_SESSION['text'] =$text;



	}

	if($acceptImage && $acceptText)
	{
		$sql = "insert into posts (text, image,user) values ('".$text."','".$imageAddress."','".$username."')";
		//echo $sql;
		$row = mysql_query($sql);
		if($row)
		{
			echo "<br>Posted<br>";
		}
	}
}	//if(isset($_POST['']))
?>




<div class="container" style="margin-left: 10%;margin-right: 10%;border-radius: 2px;border:1px solid black">
<!--This part of the code prints all the posts-->
<?php
 
 $sql = "select id,text,image,user from  posts where user='".$username."' or user in (";
 $sql .= "select user1 from friends where user2='".$username."' and areFriends = 1)";
 $sql .= "or user in (";
 $sql .= "select user2 from friends where user1='".$username."' and areFriends = 1)";
 //echo $sql;
 $row = mysql_query($sql);
 $numberOfRows = mysql_num_rows($row);
 for($i = 0;$i < $numberOfRows; $i++)
 {
 	$ide = $retVal['id'];
 	echo "<div class='posts' style='border:1px solid red;' id ='div".$ide."'>";

 	$retVal =mysql_fetch_assoc($row);
 	echo "<h1>".$retVal['user']."posted this</h1>";
 	echo "<p>".$retVal['text']."</p>";
 	echo "<img src='".$retVal['image']."' style='width:500px;height:500px;'/><button onclick='deletePost(".$retVal['id'].")'>Delete Post</button>";
 	echo "</div>";
 }
 
?>
</div>






















<?php
include "printFriends.php";
$username = $_SESSION['username'];
if($con)
{






	$db = mysql_select_db("eyebook");
	if ( $db )
	{
	//	echo "Database connection Succesful<br>";
	}





	//shows details	
	$sql = "select * from profile where username='".$username."'";
	//echo $sql;
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
	printRecievedFriendRequests($username);



	/**shows sent friend requests
	**/
	echo "<br><br><br><h1>Friend requests sent by you</h1><br>";
	printSentFriendRequests($username);
	



	echo "<br><br><br><br><br><h1>People you are friends with</h1>";
	//shows friends
	printFriendList($username);







	//shows recomended friends
	echo "<h1>People you may know</h1>";
	printRecommendedFriends($username);
}
?>
</body>
</html>