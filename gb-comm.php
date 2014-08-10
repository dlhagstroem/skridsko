<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/db.php");
$tableComment = "comment";
$tablePost = 	"post";

$feedback = "";
$name = "";
$msg = "";

$postId = isset($_GET['id']) ? $_GET['id'] : '';

if($postId == '') {
	header("Location: gb.php");
	exit();
}

$postId		= $mysqli->real_escape_string($postId);

$query = <<<END
--
-- Gets chosen post from DB
--
	SELECT postName, postMessage, postTime
	FROM {$tablePost}
	WHERE postId = {$postId};
	
END;

$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 	" : " . $mysqli->error);

if($res->num_rows < 1) {
	$content = <<<END
		<div id="container">
			<p>The post you chose cannot be found. Please try again.</p>
			<p><a href="gb.php">Guestbook</a></p>
		</div><!-- container -->
END;

} else {
	if(!empty($_POST)) {
		$name =		isset($_POST['name']) ? $_POST['name'] : '';
		$msg =		isset($_POST['msg']) ? $_POST['msg'] : '';
		$spamTest =		isset($_POST['address']) ? $_POST['address'] : '';

		if($spamTest != '') {
			die("I think you're a robot. If you're not, go back and try again.");	
		}

		if($name == '' || $msg == '') {
		 	$feedback .= "<p class=\"feedback-yellow\">Please fill out all fields.</p>";

		} else {

			$name	= utf8_encode($mysqli->real_escape_string($name));
			$msg	= utf8_encode($mysqli->real_escape_string($msg));
			$adminId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : "NULL";

			$query = <<<END
			-- 
			-- Inserts new comment into DB 
			-- 
			INSERT INTO {$tableComment}(postName, postMessage, postId, adminId)  VALUES('{$name}', '{$msg}', {$postId}, {$adminId});
END;

			$res32 = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);
			$feedback = "<p class=\"feedback-green\">Your comment has been added. Thanks!</p>";
			$msg = "";
			$name = "";

		}
	}

$row = $res->fetch_object();

$date = strtotime($row->postTime);
$date = date("d M Y H:i", $date); //http://php.net/manual/en/function.date.php

$postName		=utf8_decode(htmlspecialchars($row->postName));
$postMessage	=utf8_decode(htmlspecialchars($row->postMessage));

$postHTML = <<<END

	<h3>Write a comment to:</h3>
	<div class="gb-post">
		<p class="gb-name">Written by: {$postName}</p>
		<p class="gb-msg">{$postMessage}</p>
		<p class="gb-date">{$date}</p>
	</div>
	
END;

$name	= htmlspecialchars($name);
$msg	= htmlspecialchars($msg);

$content =  <<<END
	<div id="breadcrumbs">
		<p><a href="gb.php">Guestbook</a> &gt; Comment</p>
	</div><!-- breadcrumbs -->
	
<div id="container">
	{$feedback}
<form action="gb-comm.php?id={$postId}" method="post">
	<label for="name">Name:</label>
	<input type="text" id="name" name="name" value="{$name}" />
	<input type="hidden" id="address" name="address" />
	<label for="msg">Message:</label>
	<textarea id="msg" name="msg">{$msg}</textarea>
	<input type="submit" value="Submit"/>
</form>

{$postHTML}

END;

$query = <<<END
	--
	-- Gets all comments for chosen post from DB
	--
	SELECT postName, postMessage, postTimestamp
	FROM {$tableComment}
	WHERE postId = {$postId}
	ORDER BY postTime ASC;
	
END;

$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error);

while($row = $res->fetch_object()){
	$date = strtotime($row->postTime);
	$date = date("d M Y H:i", $date);

	$commName		= utf8_decode(htmlspecialchars($row->postName));
	$commMessage	= utf8_decode(htmlspecialchars($row->postMessage));
	
	$content .= <<<END
		<div class="gb-comm">
			<p class="gb-name">Written by: {$commName}</p>
			<p class="gb-msg">{$commMessage}</p>
			<p class="gb-date">{$date}</p>
		</div>
END;
	}
	
	$content .= "</div><!-- container -->";
	
	$res->close();
	$mysqli->close();
}

echo $adminHTML;
echo $content;
echo $footer

?>