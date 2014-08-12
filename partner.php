<?php

include_once('inc/HTMLTemplate.php');
include_once('inc/db.php');

$mysqli->set_charset("utf8");

$query = 'SELECT *
		  FROM partner  
		  GROUP BY partner.partnerId
		  ORDER BY partner.partnerId DESC';

 $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);

$content = <<<END

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-3 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li class="current"><a href="partner.php">Samarbetspartners</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              

            </div>

            <div class="large-9 columns">

            <h2>Samarbetspartners</h2>
            <p>
END;

          while($row = $res->fetch_object()) :
               
              $content .= <<<END

          		<a href="$row->linkUrl"><img src="$row->imageUrl"</a>

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