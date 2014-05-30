<?php

$header = <<<END

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>#SWESK8</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>

  <!-- lägger till nödvändiga filer -->
    
  <div class="off-canvas-wrap">
    <div class="inner-wrap">
      <nav class="tab-bar">
        <section class="left-small">
          <a class="left-off-canvas-toggle menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
          <a class="left-off-canvas-toggle"><img src="img/logo3.png"></a>
        </section>
      </nav>

      <!-- skapar en off-canvas på vänster sida och lägger till logotypen -->

      <aside class="left-off-canvas-menu">
        <ul class="off-canvas-list">
          <li><label>Huvudmeny</label></li>
          <li><a href="news.php">NYHETER</a></li>
          <li><a href="forbundsinfo.php">FÖRBUNDSINFO</a></li>
          <li><a href="#">FÖRENINGEN</a></li>
          <li><a href="#">OM KONSTÅKNING</a></li>
          <li><a href="contest.php">TÄVLINGAR</a></li>
          <li><a href="skater.php">ELITTRUPPEN</a></li>
          <li><a href="#">BREDD</a></li>
          <li><a href="#">UTBILDNING</a></li>
          <li><a href="#">MEDIA</a></li>
          <li><a href="contact.php">KONTAKT</a></li>
          <li><a href="#">WEBBSHOP</a></li>
        </ul>
      </aside>

      <!-- huvudmenyn -->

      <br><br>
      <section class="main-section">


      <div class="row">
        <div class="large-2 large-centered columns">
          <div class="house">
            <a href="index.php">
              <img class="home" src="img/house.png">
            </a>
          </div>
        </div>
      </div>

      <!-- lägger till huset som startknapp/homeknapp -->

      <div class="row">
        <div class="large-12 columns">
          <hr>
        </div>
      </div>

      <br>

      <!-- skapar en horisontell linje -->

END;

      $footer = <<<END
     
      <!-- här börjar footern -->
     
      <footer class="row">
        <div class="large-12 columns">
          <hr>
          <div class="row">
            <div class="large-6 columns">
              <p>© SWESK8</p>
            </div>
            <div class="large-6 columns">
              <ul class="inline-list right">
                <li><a href="#">Information</a></li>
                <li><a href="#">Föreningen</a></li>
                <li><a href="#">Kontakt</a></li>
                <li><a href="#">Webbshop</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>

      <!-- här slutar footern -->

      </section>

      <a class="exit-off-canvas"></a>

      </div>
    </div>
        
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>

    <!-- lägger till nödvändiga filer -->

    <script>
      $(document).foundation();
    </script>
  </body>
</html>

END;

?>