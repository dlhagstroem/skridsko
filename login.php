<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/db.php");



$table = "admin";


$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

/*tittar så där inte är några tomma fält*/
if($username == '' || $password == ''){
	$feedback = "Please fill out all fields";
} else {
	//Prevent SQL injections
	$username = $mysqli->real_escape_string($username);
	$password = $mysqli->real_escape_string($password);
	//SQL query
	$query = <<<END
	SELECT adminId, adminName, adminPassword
	FROM {$table}
	WHERE adminName = "{$username}";
END;

	//Perform query 
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);

	if($res->num_rows == 1){
		$pswmd5 = md5($password);
		$row = $res->fetch_object();
		if($row->adminPassword == $pswmd5) {
			
			session_regenerate_id();
			
			$_SESSION['username'] = $username;
			$_SESSION['userId'] = $row->adminId;

			header("Location:gb.php");
		}
		else
		{
			$feedback = "Password is incorrect!";
		}
		$res->close();
		}
		else
		{
			$feedback = "Username is incorrect!";
		}

		$mysqli->close();

}

/*create the login form */
$content = <<<END
	<form action="login.php" method="post" id="login-form">
	<label for="username">Username:</label>
	<input type="text" id="username" name="username" value="" />
	<label for="password">Password:</label>
	<input type="password" id="password" name="password" value="" />
	<input type="submit" value="Login" />
END;

/*show page contents*/


echo $header;
echo $content;
echo $feedback;
echo $footer;

?>