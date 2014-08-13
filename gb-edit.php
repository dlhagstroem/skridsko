<?php

include_once("inc/HTMLTemplate.php");
include_once("inc/db.php");

$tablePost = "post";
$tableComment = "comment";

$feedback = "";
$name = "";
$msg = "";

$postId = isset($_GET['pid']) ? $_GET['pid'] : '';
$commId = isset($_GET['cid']) ? $_GET['cid'] : '';

$type = ($postId != '') ? "post" : "comment" ;

if(!empty($_POST)) {

	//edit post or comment in DB!

} else {

	if($type == "post") {

		$query =<<<END
		--
		--Gets chosen post from DB
		--
		SELECT postId, postName, postMessage, postTimestamp, adminId
		FROM {tablePost}
		WHERE postId = {$postId};
END;

	} else {

	$query = <<<END
	--
	-- Gets chosen comment from DB
	--
	SELECT commId, commName, commMessage, commTimestamp, adminId
	FROM {$tableComment}
	WHERE commId = {$commId};

END;

	}

	$res =$mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error); //Perf

	if($res->num_rows < 1) {
		$content = <<<END
		<div id="container">
			<p>The {$type} you chose cannot be found. Please try again.</p>
			<p><a href="gb.php">Gästbok</a></p>
		</div><!-- container -->
END;

	} else {
		$row = $res->fetch_object(); //Gets result from DB

		$name = ($type == "post") ? $row->postName : $row->commName;
		$msg = ($type == "post") ? $row->postMessage : $row->commMessage;

		$name = utf8_decode($name);
		$msg = utf8_decode($msg);

		$content = getFormHTML($type, $postId, $commId, $name, $msg, $feedback);


	}
}

echo $header;
echo $content;
echo $footer;

function getFormHTML($type, $postId, $commId, $name, $msg, $feedback) {
	$name = htmlspecialchars($name);
	$msg = htmlspecialchars($msg);

	return <<<END
		<div id="breadcrumbs">
			<p><a href="gb.php">Gästbok</a> &gt; Edit</p>
		</div><!-- breadcrumbs -->

		<div id="container">
			<h2>Edit the chosen {$type}</h2>
			{$feedback}
			<form action="gb-edit.php?pid={$postId}&cid={$commID}" method="post">
				<label for ="name">Name:</label>
				<input type="text" id="name" name="name" value="{$name}" />
				<label for="msg">Message:</label>
				<textarea id ="msg" name="msg">{$msg}</textarea>
				<input type ="submit" value="Save changes" />
			</form>
		</div><!-- container -->
END;
}

?>
