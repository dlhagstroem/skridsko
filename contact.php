<?php
      
      include_once("inc/HTMLTemplate.php");

      $content = <<<END

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-3 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li class="current"><a href="#">Kontakta Oss</a></li>
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
                  <li><a href="#">Vision och verksamhet</a></li>
                  <li><a href="board.php">Styrelse</a></li>
                  <li><a href="#">Möten</a></li>
                </ul>

              </div>

            </div>

            <div class="large-9 columns">

            <h2>Kontakta Oss</h2>
            <p>
            Svenska Konståkningsförbundet<br>
            Idrottens Hus<br>
            114 73 Stockholm<br><br>

            Besöksadress: Fiskartorpsvägen 15 A-H<br><br>

            Tel: +46 (0)8-699 60 00<br>
            Fax: +46 (0)8-699 64 29<br>
            E-post:<a href="info@skatesweden.se">info@skatesweden.se</a><br><br>

            PG: 25 23 86-8<br><br>

            BG: 5892-9472
            

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