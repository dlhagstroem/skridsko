<?php
/*-----------------------------
gb-edit.php
Allows editing of chosen post or comment
-----------------------------*/

include_once("inc/HTMLTemplate.php");

if(!isset($_SESSION["username"])) {
	header("Location: index.php");
	exit();
}

include_once("inc/db.php");
$tablePost = 	"post";
$tableComment = "comment";

$feedback 	= "";
$name 		= "";
$msg 		= "";

$postId = isset($_GET['pid']) ? $_GET['pid'] : '';
$commId = isset($_GET['cid']) ? $_GET['cid'] : '';

$type = ($postId != '') ? "post" : "comment" ;

if(!empty($_POST)) {
	
	$name = 	isset($_POST['name']) ? $_POST['name'] : '';
	$msg = 		isset($_POST['msg']) ? $_POST['msg'] : '';
	
	if($name == '' || $msg == '') {
		$feedback = "<p class=\"feedback-yellow\">Please fill out all fields.</p>";
		
		$content = getFormHTML($type, $postId, $commId, $name, $msg, $feedback);
			
	} else {
	
		//--------------------------
		//Prevents SQL injections
		$name 	= utf8_encode($mysqli->real_escape_string($name));
		$msg 	= utf8_encode($mysqli->real_escape_string($msg));
		
		if($type == "post") {
			$query = <<<END
			--
			-- Changes chosen post in DB
			--
			UPDATE {$tablePost}
			SET postName = '{$name}', postMessage = '{$msg}'
			WHERE postId = {$postId};
END;
			
		} else {
			$query = <<<END
			--
			-- Changes chosen comment in DB
			--
			UPDATE {$tableComment}
			SET commName = '{$name}', commMessage = '{$msg}'
			WHERE commId = {$commId};
END;
		}
	
		$mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error); //Performs query
		
		if($mysqli->affected_rows >= 1) {
			$feedback = "The {$type} has been changed.";
		} else {
			$feedback = "Something went wrong and the {$type} was not changed.";
		}
		
		$mysqli->close();
		
		$content = <<<END
				<div id="container">
					<p>{$feedback}</p>
					<p><a href="gb.php">Back to guestbook</a></p>
				</div><!-- container -->
END;
	
	}
	
} else {

	if($type == "post") {
		$query = <<<END
		--
		-- Gets chosen post from DB
		--
		SELECT postId, postName, postMessage, postTimestamp, adminId
		FROM {$tablePost}
		WHERE postId = {$postId};

END;
	} else {
		$query = <<<END
		--
		-- Gets chosen comment from DB
		--
		SELECT  commId, commName, commMessage, commTimestamp, adminId
		FROM {$tableComment}
		WHERE commId = {$commId};

END;
	}

	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error); //Performs query
		
	if($res->num_rows < 1) {
		$content = <<<END
		<div id="container">
			<p>The {$type} you chose cannot be found. Please try again.</p>
			<p><a href="gb.php">Guestbook</a></p>
		</div><!-- container -->
END;

	} else {
		$row = $res->fetch_object(); //Gets result from DB
		
		$name = ($type == "post") ? $row->postName 		: $row->commName;
		$msg = 	($type == "post") ? $row->postMessage 	: $row->commMessage;
		
		$name 	= utf8_decode($name);
		$msg 	= utf8_decode($msg);
		
		$content = getFormHTML($type, $postId, $commId, $name, $msg, $feedback);
	}
}

echo $header;
echo $content;
echo $footer;

function getFormHTML($type, $postId, $commId, $name, $msg, $feedback) {
	$name 	= htmlspecialchars($name);
	$msg 	= htmlspecialchars($msg);
	
	return <<<END
			<div id="breadcrumbs">
				<p><a href="gb.php">Guestbook</a> &gt; Edit</p>
			</div><!-- breadcrumbs -->
			
			<div id="container"> 
				<h2>Edit the chosen {$type}</h2>
				{$feedback}
				<form action="gb-edit.php?pid={$postId}&cid={$commId}" method="post">
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" value="{$name}" />
					<label for="msg">Message:</label>
					<textarea id="msg" name="msg">{$msg}</textarea>
					<input type="submit" value="Save changes" />
				</form>
			</div><!-- container -->
	
END;
}

?>