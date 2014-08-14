<?php
/*-----------------------------
gb-edit.php
Allows editing of chosen post or comment
-----------------------------*/

include_once("inc/HTMLTemplate.php");



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
			$feedback = "Du har ändrat {$type}en.";
		} else {
			$feedback = "Det blev fel, du har inte ändrat {$type}en.";
		}
		
		$mysqli->close();
		
		$content = <<<END

				<div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="gb.php">Gästbok</a></li>
              <li class="current"><a href="gb-edit.php">Ändra post</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">
            		<p>{$feedback}</p>
					<p><a href="gb.php">Tillbaka till gästboken</a></p>

            
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


			<div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="gb.php">Gästbok</a></li>
              <li class="current"><a href="gb-edit.php">Ändra post</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">

            <h2>Ändra den valda {$type}en</h2>
				{$feedback}
				<form action="gb-edit.php?pid={$postId}&cid={$commId}" method="post">
					<label for="name">Namn:</label>
					<input type="text" id="name" name="name" value="{$name}" />
					<label for="msg">Meddelande:</label>
					<textarea id="msg" name="msg">{$msg}</textarea>
					<input type="submit" value="Spara ändringar" />
				</form>
	
END;
}

?>