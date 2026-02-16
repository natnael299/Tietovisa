<?php
require_once("./config.php");
$ids = isset($_GET["ids"]) ? explode('.', $_GET["ids"]) : "";
$teacherId = (int) $ids[0] ?? 0;
$categoryId = (int) $ids[1] ?? 0;
$length = (int) $ids[2] ?? 0;
$_SESSION["questions"] = [];
if (count($_SESSION["questions"]) < 1) {
  $stmt = $conn->prepare("SELECT * FROM questions WHERE category_id=? AND teacher_id=?  LIMIT ?");
  $stmt->bind_param("iii", $teacherId, $categoryId, $length);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($r = $result->fetch_assoc()) {
    $_SESSION["questions"][] = $r;
  }
}

//avoid zeroing index & point while reloading the page
if (!isset($_SESSION["index"])) {
  $_SESSION["index"] = 0;
}

if (!isset($_SESSION["point"])) {
  $_SESSION["point"] = 0;
}
$current_index =  $_SESSION["index"];
$currentR = $_SESSION["questions"][$current_index]; //current question row
$currentA = $currentR["correct_option"]; // current questions's answer
$points = 0;

if (isset($_POST["answer"])) {
  if (!empty($_POST["option"])) {
    $answer = $_POST["option"];
    //check correct answer
    if ($answer == $currentA) {
      $_SESSION["point"] += 1;
    }

    //check if all question were answered
    if ($_SESSION["index"] == $length - 1) {
      //insert the info to the db
      $name = get_name($conn, $_SESSION["point"]);
      $point = $_SESSION["point"];
      $percentage = ($point / $length) * 100;
      $stmt = $conn->prepare("INSERT INTO (username, percentage, point, length) VALUES(?, ?, ?, ?)");
      $stmt->bind_param("siii", $name, $percentage, $point, $length);
      $stmt->execute();

      //clear all session variables and redirect
      $_SESSION["questions"] = [];
      $_SESSION["final_p"] =  $_SESSION["point"];
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
    <div class="links">
      <a href="../index.php">Etusivu</a>
    </div>
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
      <?php endif; ?>
    </form>

    <footer>
      <p><strong>Tekijä: </strong> Natnael Beyene</p>
      <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
    </footer>
</body>

</html>