<?php

include_once('inc/HTMLTemplate.php');
include_once('db.php');

$mysqli->set_charset("utf8");

$query = 'SELECT *
		  FROM partner  
		  GROUP BY partner.partnerId
		  ORDER BY partner.partnerId DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);


$content = <<<END

		<div>
		while($row = $res->fetch_object()) : 
	         <a href="<?php echo $->linkUrl ?>"><img src="<?php echo $row->imageUrl ?>"</a>
        </div>

END;


echo $header;
echo $content;
echo $footer;



?>