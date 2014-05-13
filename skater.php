<?php


include_once('inc/HTMLTemplate.php');
include_once('db.php');

$mysqli->set_charset("utf8");

$query = 'SELECT *
		  FROM skater  
		  GROUP BY skater.skaterId
		  ORDER BY skater.firstName DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);


$content = <<<END

		<div>
		while($row = $res->fetch_object()) :
	         <h2><?php echo $row->firstName, lastName ?></h2> 
	         <p><?php echo $row->age; ?></p> <br/>
	         <p><?php echo $row->birthPlace ?></p> <br/>
	         <p><?php echo $row->homeTown ?></p> <br/>
	         <p><?php echo $row->height ?></p> <br/>
	         <p><?php echo $row->careerStart ?></p> <br/>
	         <p><?php echo $row->club ?></p> <br/>
	    endwhile;
        </div>

END;


echo $header;
echo $content;
echo $footer;


?>