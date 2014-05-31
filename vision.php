<?php
      
      include_once("inc/HTMLTemplate.php");
      include_once('db.php');

      

      $content = <<<END

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">

          <div class="row">
            <div class="large-3 columns">

            <ul class="breadcrumbs">
              <li><a href="index.php">Hem</a></li>
              <li><a href="contact.php">Kontakta Oss</a></li>
              <li class="current"><a href="vision.php">Vår Vision</a></li>
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

            <h2>Vår vision</h2>
            <p>

              Svenska Konståkningsförbundets vision är:<br><br>

              VI SKA BRETT STÅ - FÖR ATT HÖGT NÅ!

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