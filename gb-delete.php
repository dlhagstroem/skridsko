<?php

include_once("inc/connstring.php");

$postId = isset($_GET['pid']) ? $_GET['pid'] : '';

$query =<<<END
DELETE FROM post
WHERE postId = $postId
END;

$res = $mysqli->query($query) or die("You failed miserably.");

header("Location: gb.php");

?>