<?php
/*------------------
gb.php
Displays guestbook posts
and handles adding of new posts
---------------------------*/

include_once("inc/db.php");
include_once("inc/HTMLTemplate.php");

$feedback = "";
$name = "";
$msg = "";
$tablePost = "gb";
$tablepostMessage = "comment";
if(!empty($_POST)) {
		
		$name =	isset($_POST['name']) ? $_POST['name'] : '';
		$msg =	isset($_POST['msg']) ? $_POST['msg'] : '';
		$spamTest =	isset($_POST['address']) ? $_POST['address'] : '';
		
		if($spamTest != '') {
			die("I think you're a robot. If you're not, go back and try again.");
		}
		
		if($name == '' || $msg == '') {
			$feedback = "<p class=\"feedback-yellow\">Please fill out all fields.</p>";
		
		
		} else {
			//---------------------
			//Prevents SQL injections
			$name  = utf8_encode($mysqli->real_escape_string($name)); 
			$msg   = utf8_encode($mysqli->real_escape_string($msg));
			
			$adminId = isset($_SESSION["userID"]) ? $_SESSION["userID"] : "NULL";
			
			//---------------------
			//SQL query
			$query = <<<END
			--
			-- Insert new message into DB
			--
			INSERT INTO {$tablePost} (postName, postMessage, adminId)
			VALUES('{$name}', '{$msg}', {$adminId});
			
END;

			$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno. " : " . $mysqli->error); //Performs query
			$feedback = "<p class=\"feedback-green\">Your post has been added. Thanks!</p>";
			
	}
}

$name = isset($_SESSION["username"]) ? $_SESSION["username"] : $name;

$name	= utf8_decode(htmlspecialchars($name));
$msg	= utf8_decode(htmlspecialchars($msg));

$content = <<<END

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-3 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li class="current"><a href="gb.php">Gästboken</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

         

            </div>

            <div class="large-9 columns">

            <h2>Gästbok</h2>
            <p>
            	{$feedback}
				<form action="gb.php" method="post">
					<div><label for="name">Name:</label>
					<input type="text" id="name" name="name" value="{$name}" /></div>
					<input type="hidden" id="address" name="address" />
					<div><label for="msg">Message:</label></div><div>
					<textarea id="msg" name="msg">{$msg}</textarea></div>
					<input type="submit" value="Submit" />
				</form>
            </p>

            </div>
          </div>  
        </div>
      </div>

      <br>

      <!-- här slutar contenten -->

END;

//-----------------
//SQL query
$query = <<<END
--
-- Gets all posts DB
--
SELECT postId, postName, postMessage, postTime, adminId
FROM {$tablePost}
ORDER BY postTime DESC;

END;

$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error); //Performs query

//Loops trough results
while($row = $res->fetch_object()) {
	$date = strtotime($row->postTime);
	$date = date("d M Y H:i", $date); //http://php.net/manual/en/function.date.php
	
	$postName		= utf8_decode(htmlspecialchars($row->postName));
	$postMessage	= utf8_decode(htmlspecialchars($row->postMessage));
	
	$adminClass = (!is_null($row->adminId)) ? " admin" : "";
	$adminRow = "";

	if (isset($_SESSION['username'])) {
		$adminRow = <<<END
		<p class="gb-admin-row"><a href="gb-edit.php?pid={$row->postId}">Edit</a> &middot; <a href="gb-delete.php?pid={$row->postId}">Delete</a></p>
END;
	}

	$content .= <<<END
		<div class="gb-post{$adminClass}">
			<p class="gb-name">Written by: {$postName}</p>
			<p class="gb-msg">{$postMessage}</p>
			<p><span class="gb-comment"><a href="gb-comm.php?id={$row->postId}">Write a comment</a></span>
			<span class="gb-date">{$date}</p>
			{$adminRow}
		</div>
END;

//Query for comments
	$query = <<<END
	--
	-- Gets all comments for current post from DB
	--
	SELECT postId, postName, postMessage, postTime, adminId
	FROM {$tablepostMessage}
	WHERE postId = {$row->postId}
	ORDER BY postTime ASC;
END;

	$res2 = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);

	while ($row2 = $res2->fetch_object()) {
		$date = strtotime($row2->postTime);
		$date = date("d M Y H:i",$date);

		$commName = utf8_decode(htmlspecialchars($row2->postName));
		$commMessage = utf8_decode(htmlspecialchars($row2->postMessage));

		$adminRow2 = "";
		$adminClass2 = (!is_null($row2->adminId)) ? " admin" : "";

		if (isset($_SESSION['username'])) {
			$adminRow2 = <<<END
			<p class="gb-admin-row"><a href="gb-edit.php?cid={$row2->commId}">Edit</a> &middot; <a href="gb-delete.php?cid={$row2->commId}">Delete</a></p>
END;
		}

		$content .= <<<END
		<div class="gb-comm{$adminClass2}" style="margin-left:30px;padding-left:10px;">
			<p class="gb-name">Written by: {$commName}</p>
			<p class="gb-msg">{$commMessage}</p>
			<p class="gb-date">{$date}</p>
			{$adminRow2}
		</div>
END;
	}
}

$content .= "</div>";

$res->close();
$mysqli->close();

echo $header;
echo $content;
echo $footer;

?>