<?php
      
      include_once("inc/HTMLTemplate.php");

      $content = <<<END

      <!-- under kommer start på all content -->

      <div class="row">
        <div class="large-12 columns">
          <img src="img/splash1.png" alt="slide image">
          <br><br>
        </div>
      </div>

      <div class="row">
        <div class="large-12 columns">
          <div class="row">
     
            <div class="large-8 columns">
              <div class="panel radius">
     
                <div class="row">
                  <div class="large-12 small-12 columns">
     
                    <h4>Nyheter</h4><hr/>
                    <p>Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Donec dignissim nibh fermentum odio ornare sagittis.
                    Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Donec dignissim nibh fermentum odio ornare sagittis.
                    Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Donec dignissim nibh fermentum odio ornare sagittis.
                    Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Donec dignissim nibh fermentum odio ornare sagittis.</p>

                  </div>
                </div>
              </div>
            </div>
     
            <div class="large-4 columns hide-for-small">
       
              <h4>Följ oss på</h4><hr/>
       
              <a href="#">
                  <img src="img/fb.png">
              </a>
              <br><br>
              <a href="#">
                <img src="img/twitter.png">
              </a>
       
            </div>
          </div>
        </div>
      </div>

      <!-- här slutar contenten -->

END;

echo $header;
echo $content;
echo $footer;

?>