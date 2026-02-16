<?php
require_once("./config.php");
$point = $_SESSION["final_p"];
$length = $_SESSION["length"];
$name = get_name($conn, $_SESSION["user_id"]); //fetch user name based on id

$message = "";
//save the game's data to the database
if (isset($_POST["Save"])) {
  $percentage = ($point / $length) * 100;
  $stmt = $conn->prepare("INSERT INTO result (username, percentage, point, length) VALUES(?, ?, ?, ?)");
  $stmt->bind_param("siii", $name, $percentage, $point, $length);
  if ($stmt->execute()) {
    $_SESSION["game_id"] = $stmt->insert_id;
    $message = "Tuloksesi on tallennettu!!";
    header("Location: ./leaderboard.php");
    exit();
  };
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./style/general.css">
  <link rel="stylesheet" href="./style/result.css">
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <div class="links">
      <a href="./index.php">Etusivu</a>
      <a href="./logout.php">logout</a>
    </div>
    <!-- button for opening links to auth files in mobile-->
    <button class="mobile" popovertarget="auth">
      <i class="fas fa-bars"></i>
    </button>

    <!-- auth links for mobile-->
    <nav class="mobile" popover id="auth">
      <a href="./auth/index.php">Etusivu</a>
      <a href="./auth/logout.php">Kirjausu ulos</a>
    </nav>
  </Header>

  <?php if ($_SESSION["user_id"]): ?>
    <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
      <h2>Tuloksesi</h2>
      <p>
        Pisteet:
        <?= htmlspecialchars($point)  ?>/
        <?= htmlspecialchars($length)  ?>
      </p>
      <p class="user"><?= htmlspecialchars($name) ?></p>
      <input type="submit" name="Save" Value="Tallenna tuloksesi">

      <?php if (!empty($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>
    </form>
  <?php endif; ?>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>