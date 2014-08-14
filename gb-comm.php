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
	SELECT postName, postMessage, postTimestamp
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
			INSERT INTO {$tableComment}(commName, commMessage, postId, adminId)  VALUES('{$name}', '{$msg}', {$postId}, {$adminId});
END;

			$res32 = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);
			$feedback = "<p class=\"feedback-green\">Din kommentar har lagts till!. Tack!</p>";
			$msg = "";
			$name = "";

		}
	}

$row = $res->fetch_object();

$date = strtotime($row->postTimestamp);
$date = date("d M Y H:i", $date); //http://php.net/manual/en/function.date.php

$postName		=utf8_decode(htmlspecialchars($row->postName));
$postMessage	=utf8_decode(htmlspecialchars($row->postMessage));

$postHTML = <<<END

<div class="row">
        <div class="large-12 columns">

         

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">

	<h3>Skriv en kommentar till:</h3>
	<div class="gb-post">
		<p class="gb-name">Skriven Av: {$postName}</p>
		<p class="gb-msg">{$postMessage}</p>
		<p class="gb-date">{$date}</p>
	</div>
	
END;

$name	= htmlspecialchars($name);
$msg	= htmlspecialchars($msg);

$content =  <<<END

<div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="gb.php">Gästbok</a></li>
              <li class="current"><a href="gb-comment.php">Kommentar</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">
            <h3>Kommentar</h3>
            	{$feedback}
					<form action="gb-comm.php?id={$postId}" method="post">
						<label for="name">Namn:</label>
						<input type="text" id="name" name="name" value="{$name}" />
						<input type="hidden" id="address" name="address" />
						<label for="msg">Kommentar:</label>
						<textarea id="msg" name="msg">{$msg}</textarea>
						<input type="submit" value="Skicka"/>
					</form>

{$postHTML}

END;

$query = <<<END
	--
	-- Gets all comments for chosen post from DB
	--
	SELECT commName, commMessage, commTimestamp
	FROM {$tableComment}
	WHERE postId = {$postId}
	ORDER BY commTimestamp ASC;
	
END;

$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error);

while($row = $res->fetch_object()){
	$date = strtotime($row->commTimestamp);
	$date = date("d M Y H:i", $date);

	$commName		= utf8_decode(htmlspecialchars($row->commName));
	$commMessage	= utf8_decode(htmlspecialchars($row->commMessage));
	
	$content .= <<<END
		<div class="gb-comm">
			<p class="gb-name">Skriven av: {$commName}</p>
			<p class="gb-msg">{$commMessage}</p>
			<p class="gb-date">{$date}</p>
		</div>
END;
	}
	
	$content .= "</div><!-- container -->";
	
	$res->close();
	$mysqli->close();
}

echo $header;
echo $content;
echo $footer

?>