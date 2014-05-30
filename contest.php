<?php
      
      include_once("inc/HTMLTemplate.php");
      include_once('db.php');

      $mysqli->set_charset("utf8");

      $query = 'SELECT *
            FROM contest  
            GROUP BY contest.contestId
            ORDER BY contest.contestName ASC';

       $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);


      $content = <<<END

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-4 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="contact.php">Kontakta Oss</a></li>
              <li class="current"><a href="board.php">Styrelse</a></li>
            </ul>

            </div>
          </div>

          <br>

          <div class="row">
            <div class="large-3 columns">

              <div class="panel callout radius">
                <h5>Förbundsinfo</h5>
                
                <ul class="side-nav">
                  <li><a href="#">Förbundsnyheter</a></li>
                  <li><a href="vision.php">Vision och verksamhet</a></li>
                  <li><a href="board.php">Styrelse</a></li>
                  <li><a href="#">Möten</a></li>
                </ul>

              </div>

            </div>

            <div class="large-9 columns">

            <h2>Styrelse</h2>
            <p>
END;

          while($row = $res->fetch_object()) :
               
              $content .= <<<END

               <h2>$row->contestName</h2>
               <p>$row->contestInfo</p>
               
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