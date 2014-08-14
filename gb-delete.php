<?php
/*----------------------
gb-delete.php
Deletes chosen post or comment from DB
----------------------*/

include_once("inc/HTMLTemplate.php");
include_once("inc/db.php");

$tablePost = 	"post";
$tableComment = "comment";

$feedback 	= "";
$name 		= "";
$msg 		= "";

$postId = 	isset($_GET['pid']) 	? 	$_GET['pid'] 	: '';
$commId = 	isset($_GET['cid']) 	? 	$_GET['cid'] 	: '';
$s = 		isset($_GET['s']) 		? 	$_GET['s'] 		: '';

if($postId == '' && $commId == '') {
	$content = <<<END
			<div id="breadcrumbs">
				<p><a href="gb.php">Guestbook</a> &gt; Delete</p>
			</div><!-- breadcrumbs -->
			<div id="container">
				<p>No post or comment has been chosen. Please try again.</p>
			</div><!-- container -->
END;

} else if ($s != '') {
	$query = "";
	
	if($postId == "y") {
		$postId 	= $mysqli->real_escape_string($postId);
		$type = "post";
		
		//------------------------
			//SQL query
			$query = <<<END
			--
			-- Deletes chosen post
			--
			DELETE FROM {$tablePost}
			WHERE postId = {$postId};

END;

	}
	

	
	$content = <<<END

			<div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="gb.php">Gästbok</a></li>
              <li class="current"><a href="gb-delete.php">Ta bort inlägg</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">

            <h2>Ta bort inlägg</h2>

            <p><a href="gb.php">Tillbaka till gästboken</a></p>
	
END;
} else {
	$type = ($postId != '') ? "post" : "comment" ;

	$content = <<<END
			<div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="gb.php">Gästbok</a></li>
              <li class="current"><a href="gb-delete.php">Ta bort inlägg</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">

            <h2>Ta bort inlägg</h2>
            <p>


            	<p>Är du säker på att du vill ta bort denna {$type}?</p>
				<p><a href="gb-delete.php?pid={$postId}&cid={$commId}&s=y">Ja</a></p>
	
END;
}

$type = "post";

$query = <<<END
			--
			-- Deletes chosen post
			--
			DELETE FROM {$tablePost}
			WHERE postId = {$postId};

END;

$mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error); //Performs query

if($mysqli->affected_rows >= 1) {
		$feedback = "The {$type} has been removed.";
	} else {
		$feedback = "Something went wrong and the {$type} was not removed.";
	}
	
	$mysqli->close();

echo $header;
echo $content;
echo $footer;

?>