<?php
require_once("./config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tietovisa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./style/general.css">
  <link rel="stylesheet" href="./style/index.css">
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>

    <!-- auth links for desktop -->
    <nav class="links desktop">
      <a href="./auth/login.php" class=" desktop">Kirjaudu</a>
      <a href="./auth/reg.php" class=" desktop">Registeröidy</a>
    </nav>

    <!-- button for opening links to auth files in mobile-->
    <button class="mobile" popovertarget="auth">
      <i class="fas fa-bars"></i>
    </button>

    <!-- auth links for mobile-->
    <nav class="mobile" popover id="auth">
      <a href="./auth/login.php">Kirjaudu</a>
      <a href="./auth/reg.php">Registeröidy</a>
    </nav>
  </Header>


  <Main>
    <div class="upper">
      <div>
        <h1 class="desktop">Taitaja TietoTesti</h1>
        <h2 class="mobile">Taitaja TietoTesti</h2>
        <p>
          Haluatko testata tietosi? se on nyt helppoa valitse opettaja ja aihealue, ja aloita heti!
          Pelaa nyt
        </p>

        <a href="">Pelaa Nyt</a>
      </div>
      <img class="desktop" src="./intructions_folder\assets\images\pexels-leeloothefirst-5428830.jpg" alt="">
    </div>

    <div class="lower">
      <img class="desktop" src="./intructions_folder\assets\images\pexels-rdne-7092416.jpg" alt="">
      <div>
        <h1>Miten Pelataan?</h1>
        <ol>
          <li>
            Tee ensimmäinen valinta - keneltä haluat oppia ja mistä aiheesta?
          </li>

          <li>
            Päätä, kuinka monta kysymystä haluat vastata: 5, 10 tai 15
          </li>

          <li>
            Vastaa kysymyksiin ja seuraa esistymistäsi reaaliakaisesti
          </li>

          <li>
            Näe ja vertaa tulosi muiden kanssa.
          </li>

        </ol>
        <p>
        </p>
        <a href="">Kokeile tatitojasi nyt</a>
      </div>
    </div>
  </Main>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>