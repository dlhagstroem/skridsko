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
              <li class="current"><a href="#">Förbundsinfo</a></li>
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
                  <li><a href="#">Styrelse</a></li>
                  <li><a href="#">Möten</a></li>
                </ul>

              </div>

            </div>

            <div class="large-9 columns">

            <h2>Förbundsinfo</h2>
            <p>

            Här finner du information om Svenska konståkningsförbundets verksamhet.
            Välj bland rubrikerna till vänster det du vill veta mer om.

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