<?php
require_once("./config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <div class="links">
      <a href="../index.php">Etusivu</a>
    </div>
  </Header>

  <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">


    <input type="submit" name="Save" Value="Tallenna tulostasi">
  </form>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>