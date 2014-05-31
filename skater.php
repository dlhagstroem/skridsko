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

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="#">Åkare</a></li>
              <li class="current"><a href="skater.php">Personporträtt</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              <div class="panel callout radius">
                <h5>Åkare</h5>
                
                <ul class="side-nav">
                  <li><a href="skater.php">Personporträtt</a></li>
                  <li><a href="#">Landslaget i synkroniserad konståkning</a></li>
                  <li><a href="#">Landslagstruppen i singel</a></li>
                </ul>

              </div>

            </div>

            <div class="large-9 columns">

            <h2>Personporträtt</h2>
            <p>
END;

          while($row = $res->fetch_object()) :
               
              $content .= <<<END

          		 <img src="$row->skaterPic ">
		         <h2>$row->firstName $row->lastName</h2> 
		         <p>Ålder: $row->age </p> <br/>
		         <p>Födelsestad: $row->birthPlace</p> <br/>
		         <p>Hemstad: $row->homeTown</p> <br/>
		         <p>Längd: $row->height cm</p><br/>
		         <p>Karriärstart: $row->careerStart</p> <br/>
		         <p>Klubb: $row->club</p> <br/>

               
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