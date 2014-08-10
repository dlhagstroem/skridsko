<?php

include_once("inc/db.php");

$postId = isset($_GET['pid']) ? $_GET['pid'] : '';

$query =<<<END
DELETE FROM Gb
WHERE postId = $postId
END;

$res = $mysqli->query($query) or die("You failed miserably.");

header("Location: gb.php");

?>