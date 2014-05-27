<?php


include_once('inc/HTMLTemplate.php');
include_once('db.php');

$mysqli->set_charset("utf8");

$query = 'SELECT *
		  FROM news  
		  GROUP BY news.newsId
		  ORDER BY news.timeStamp DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);


while($row = $res->fetch_object()) :
$content = <<<END

		<div>
		
	         <h2>$row->headingText</h2> 
	         <p><$row->timeStamp</p> <br/>
	         <p><$row->bodyText</p> <br/>
	         <img src="$row->image">
	    
        </div>

END;
endwhile;


echo $header;
echo $content;
echo $footer;


?>