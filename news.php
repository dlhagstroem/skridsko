<?php


include_once('inc/HTMLTemplate.php');
include_once('db.php');

$mysqli->set_charset("utf8");

while($row = $res->fetch_object()) :

$query = 'SELECT *
 FROM Entry 
 INNER JOIN Designer 
 ON Entry.designerId=Designer.designerId
 GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp, Designer.designerName, Designer.designerCity
 ORDER BY Entry.accepted ASC, Entry.timeStamp DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);


$content = <<<END

		<div class="entryText">
	         <h2><?php echo $row->entryName ?></h2> 
	         <p><?php echo $entryDate; ?></p> <br/>
	         <p><?php echo $row->designerName ?></p> <br/>
	         <p><?php echo $row->designerCity ?></p> <br/>
	         <p>Antal röster:</p>
	         <p class="votes"><strong><?php echo $row->votes ?></strong></p>
        </div>

END;


echo $header;
echo $content;
echo $footer;


?>