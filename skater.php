<?php


include_once('inc/HTMLTemplate.php');
include_once('db.php');

$mysqli->set_charset("utf8");

$query = 'SELECT *
		  FROM skater  
		  GROUP BY skater.skaterId
		  ORDER BY skater.firstName DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);

while($row = $res->fetch_object()) :

$content = <<<END

		<div>
			 <img src="$row->skaterPic ">
	         <h2>$row->firstName $row->lastName</h2> 
	         <p>Ålder: $row->age </p> <br/>
	         <p>Födelsestad: $row->birthPlace</p> <br/>
	         <p>Hemstad: $row->homeTown</p> <br/>
	         <p>Längd: $row->height cm</p><br/>
	         <p>Karriärstart: $row->careerStart</p> <br/>
	         <p>Klubb: $row->club</p> <br/>
	    
        </div>

END;
endwhile;


echo $header;
echo $content;
echo $footer;


?>