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

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-3 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li class="current"><a href="news.php">Nyheter</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">

            <h2>Nyheter</h2>
            <p>
END;

          while($row = $res->fetch_object()) :
               
              $content .= <<<END

            <div>
		
	         <h2>$row->headingText</h2> 
	         <p>$row->timeStamp</p> <br/>
	         <p>$row->bodyText</p> <br/>
	         <img src="$row->image">
	    
        	</div>
               
END;
          endwhile;

        $content .= <<<END
            </p>

            </div>
          </div>  
        </div>
      </div>

      <br>

      <!-- här slutar contenten -->

END;



echo $header;
echo $content;
echo $footer;


?>