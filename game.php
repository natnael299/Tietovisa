<?php
require_once("./config.php");
$teacherId =  $_SESSION["teacher"] ?? 0;
$categoryId =  $_SESSION["subject"] ?? 0;
$length =  $_SESSION["length"] ?? 0;

if (empty($_SESSION["questions"])) {
  $_SESSION["questions"] = [];
  $stmt = $conn->prepare("SELECT * FROM questions WHERE category_id=? AND teacher_id=?  LIMIT ?");
  $stmt->bind_param("iii", $categoryId, $teacherId, $length);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($r = $result->fetch_assoc()) {
    $_SESSION["questions"][] = $r;
  }
  shuffle($_SESSION["questions"]);
}

//avoid zeroing index & point while reloading the page
if (!isset($_SESSION["index"])) {
  $_SESSION["index"] = 0;
}

if (!isset($_SESSION["point"])) {
  $_SESSION["point"] = 0;
}
$current_index =  $_SESSION["index"];
if (!empty($_SESSION["questions"])) {
  $currentR = $_SESSION["questions"][$current_index]; //current question row
  $currentA = $currentR["correct_option"]; // current questions's answer
}
$points = $_SESSION["point"];

if (isset($_POST["answer"])) {
  if (!empty($_POST["option"])) {
    $answer = $_POST["option"];
    //check correct answer
    if ($answer == $currentA) {
      $_SESSION["point"] += 1;
    }

    //check if all question were answered
    if ($_SESSION["index"] == $length - 1) {
      //clear all session variables and redirect
      $_SESSION["questions"] = [];
      $_SESSION["final_p"] =  $_SESSION["point"];
      $_SESSION["length"] = $length;
      $_SESSION["point"] = 0;
      $_SESSION["index"] = 0;
      header("Location: ./result.php");
      exit();
    } else {
      $_SESSION["index"] += 1;
    }
  }
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
  <link rel="stylesheet" href="./style/game.css">
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <div class="links desktop">
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

  <?php if ($_SESSION["questions"]): ?>
    <div class="gameInfo">
      <p>Kysymys <?= htmlspecialchars($current_index + 1) ?>/<?= htmlspecialchars($length) ?></p>
      <p>Pisteet <?= htmlspecialchars($points) ?></p>
    </div>

    <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
      <!-- Question -->
      <p>
        <strong> <?= htmlspecialchars($currentR["question"]) ?> </strong>
      </p>
      <div class="options">
        <!-- option A -->
        <div>
          <input type="radio" name="option" value="A">
          <p>
            <?= htmlspecialchars($currentR["option_a"]) ?>
          </p>
        </div>

        <!-- option B -->
        <div>
          <input type="radio" name="option" value="B">
          <p>
            <?= htmlspecialchars($currentR["option_b"]) ?>
          </p>
        </div>

        <!-- option C -->
        <div>
          <input type="radio" name="option" value="C">
          <p>
            <?= htmlspecialchars($currentR["option_c"]) ?>
          </p>
        </div>

        <!-- option D -->
        <div>
          <input type="radio" name="option" value="D">
          <p>
            <?= htmlspecialchars($currentR["option_d"]) ?>
          </p>
        </div>
        <input type="submit" name="answer" value="Vastaa">
      </div>
    </form>
  <?php endif; ?>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>