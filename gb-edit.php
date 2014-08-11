<?php

include_once("inc/HTMLTemplate.php");
include_once("inc/db.php");

$postId = isset($_GET['pid']) ? $_GET['pid'] : '';

$updatedMsg = isset($_POST['msg']) ? $_POST['msg'] : '';

if(isset($_POST['msg'])){

$query =<<<END
UPDATE post
SET postMessage = '$updatedMsg'
WHERE postId = '$postId'
END;

$res = $mysqli->query($query) or die("Failed");

}

$query =<<<END
SELECT * FROM post
WHERE postId = '$postId'
END;

$res = $mysqli->query($query);

while($row = $res->fetch_object()){
	$name = $row->postName;
	$msg = $row->postMessage;
	$date = $row->postTime;
	$postContent =<<<END
	<p>
	Written by: {$name} <br>
	Message: {$msg} <br>
	{$date}
	</p>
END;
}

$updateForm = <<<END
<form action="gb-edit.php?pid={$postId}" method="post">
	<label for="msg">Edit post:</label>
	<textarea id="msg" name="msg">{$msg}</textarea>
	<input type="submit" value="Submit"/>
</form>
END;


echo $header;
echo $postContent;
echo $updateForm;
echo $footer;

?>