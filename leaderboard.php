<?php
require_once("./config.php");
//validate user
if (!isset($_SESSION["user_id"])) {
  header("Location: ../auth/login.php");
}


$_SESSION["game_id"] = 3;
//gets saved results by length
function get_results($conn, $length)
{
  $rows = [];
  $limit = 5;
  $stmt = $conn->prepare("SELECT * from result WHERE length=? ORDER BY percentage DESC LIMIT?");
  $stmt->bind_param("ii", $length, $limit);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($r = $result->fetch_assoc()) {
    $rows[] = $r;
  };
  return $rows;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tietovisa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./style/general.css">
  <link rel="stylesheet" href="./style/leaderboard.css">

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

  <Main>
    <h2>High scores</h2>
    <!-- displays results with short length -->
    <div class="lyhyt">
      <?php $results_s = get_results($conn, 5) ?>
      <?php if (count($results_s) > 0): ?>
        <ol>
          <?php foreach ($results_s as $r): ?>
            <li class="<?php if ($r['id'] == $_SESSION['game_id']) {
                          echo 'current';
                        } ?>">
              <div class="name">
                <?= htmlspecialchars(get_name($conn, $r["user_id"]))  ?>
              </div>

              <p class="length">
                <?= htmlspecialchars($r["point"])  ?>/<?= htmlspecialchars($r["length"])  ?>
              </p>
              <p>Lyhyt</p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p>Lyhyt kysymyksien Tuloksia ei löydetty</p>
      <?php endif; ?>
    </div>

    <!-- displays results with midium length -->
    <div class="keski">
      <?php $results_m = get_results($conn, 10) ?>
      <?php if (count($results_m) > 0): ?>
        <ol>
          <?php foreach ($results_m as $r): ?>
            <li class="<?php if ($r['id'] == $_SESSION['game_id']) {
                          echo 'current';
                        } ?>">
              <div class="name">
                <?= htmlspecialchars(get_name($conn, $r["user_id"]))  ?>
              </div>

              <p>
                <?= htmlspecialchars($r["point"])  ?>/<?= htmlspecialchars($r["length"])  ?>
              </p>
              <p>Keskipitkä</p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p> Keskipitkä kysymyksien Tuloksia ei löydetty</p>
      <?php endif; ?>
    </div>

    <!-- displays results with long length -->
    <div class="pitka">
      <?php $results_p = get_results($conn, 15) ?>
      <?php if (count($results_p) > 0): ?>
        <ol>
          <?php foreach ($results_p as $r): ?>
            <li class="<?php if ($r['id'] == $_SESSION['game_id']) {
                          echo 'current';
                        } ?>">
              <div class="name">
                <?= htmlspecialchars(get_name($conn, $r["user_id"]))  ?>
              </div>

              <p>
                <?= htmlspecialchars($r["point"])  ?>/<?= htmlspecialchars($r["length"])  ?>
              </p>
              <p>Pitkä</p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p> Pitkä kysymyksien Tuloksia ei löydetty</p>
      <?php endif; ?>
    </div>

    <a href="./start.php">Pelaa Uudestaan</a>
  </Main>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>