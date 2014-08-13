<?php

include_once("inc/HTMLTemplate.php");
include_once("inc/db.php");

$tablePost = "post";
$tableComment = "comment";

$postId = isset($_GET['pid'])		?	$_GET['pid'] : '';
$commId = isset($_GET['cid'])		?	$_GET['cid'] : '';

if($postId == '' && $commId == '') {
	$content = <<<END

	<div id="breadcrumbs">
		<p><a href="gb.php">Gästbok</a> &gt; Ta bort</p>
	</div>
	<div>
		<p>Ingen post eller kommentar har valts, var vänlig försök igen.</p>
	</div>
END;

} else if ($s != '') {
	$query = "";

	if($postId == "y") {
		$postId		= $mysqli->real_escape_string($postId);
		$type = "post";

		$query = <<<END

		DELETE FROM {$tablePost}
		WHERE postId = {$postId};
END;

	} else if ($commId != '') {
		$commId		= $mysqli->real_escape_string($commId);
		$type = "comment";

		$query = <<<END

		DELETE FROM {$tableComment}
		WHERE commId = {$commId};
END;
	}

	$mysqli->query($query) or die ("Could not query database" . $mysqli->errno . " : " . $mysqli->error);

	if($mysqli->affected_rows >= 1) {
		$feedback ="{$type} har blivit borttagen.";
	} else {
		$feedback ="Något gick fel och {$type} var ej borttagen.";
	}

	$mysqli->close();

} else {
	$type = ($postId != '') ? "post" : "comment" ;

	$content = <<<END
	<div id="breadcrumbs">
		<p><a href="gb.php">Gästbok</a> $gt; Delete</p>
	</div>
	<div>
		<p>Är du säker på att du vill ta bort {$type}?</p>
		<p><a href="gb-delete.php?pid={postId}&cid={commId}&s=y">Yes</a></p>
	</div>

END;
}

echo $header;
echo $content;
echo $footer;

?>