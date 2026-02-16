<?php
require_once("./config.php");
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
  <title>Document</title>
  <link rel="stylesheet" href="./style/general.css">

  <style>
    Main {
      display: flex;
      flex-direction: column;
      align-items: start;
      width: fit-content;
      margin: 10px auto;
      padding-bottom: 80px;
      gap: 20px;
    }

    Main h2 {
      margin-bottom: 20px;
    }

    ol {
      display: flex;
      width: 100%;
      flex-direction: column;
      align-items: start;
      gap: 8px;
    }

    ol li {
      display: list-item;
      list-style-position: inside;
    }

    li.current {
      font-weight: bold;
    }

    li p {
      display: inline;
      margin-right: 20px;
    }

    .name {
      display: inline-block;
      width: 90px;
    }
  </style>
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <div class="links">
      <a href="../index.php">Etusivu</a>
    </div>
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
                <?= htmlspecialchars($r["username"])  ?>
              </div>

              <p>
                <?= htmlspecialchars($r["point"])  ?>/<?= htmlspecialchars($r["length"])  ?>
              </p>
              <p>Lyhyt</p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p>Tuloksia ei löydetty</p>
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
              <p class="name">
                <?= htmlspecialchars($r["username"])  ?>
              </p>

              <p>
                <?= htmlspecialchars($r["point"])  ?>/<?= htmlspecialchars($r["length"])  ?>
              </p>
              <p>Keskipitkä</p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p>Tuloksia ei löydetty</p>
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
              <p class="name">
                <?= htmlspecialchars($r["username"])  ?>
              </p>

              <p>
                <?= htmlspecialchars($r["point"])  ?>/<?= htmlspecialchars($r["length"])  ?>
              </p>
              <p>Pitkä</p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p>Tuloksia ei löydetty</p>
      <?php endif; ?>
    </div>

  </Main>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>