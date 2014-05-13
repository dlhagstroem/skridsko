<?php


include_once('inc/HTMLTemplate.php');
include_once('db.php');

$mysqli->set_charset("utf8");

$query = 'SELECT *
		  FROM news  
		  GROUP BY news.newsId
		  ORDER BY news.timeStamp DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);


$content = <<<END

		<div>
		while($row = $res->fetch_object()) :
	         <h2><?php echo $row->headingText ?></h2> 
	         <p><?php echo $timeStamp; ?></p> <br/>
	         <p><?php echo $row->bodyText ?></p> <br/>
	         <img src="<?php echo $row->image ?>">
        </div>

END;


echo $header;
echo $content;
echo $footer;


?>