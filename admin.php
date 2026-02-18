<?php
require_once("./config.php");
//validate user
if (!isset($_SESSION["user_id"])) {
  header("Location: ../auth/login.php");
}
$categories = [];
$_SESSION["user_id"] = 1;
$teacherId = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT * FROM categories WHERE teacher_id=?");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
while ($r = $result->fetch_assoc()) {
  $categories[] = $r;
}


$message = "";
//creates a new category
if (isset($_POST["create"])) {
  $message = "";
  $name = $_POST["category"];
  $stmt = $conn->prepare("INSERT INTO categories (name, teacher_id) VALUES(?, ?)");
  $stmt->bind_param("si", $name, $teacherId);
  if ($stmt->execute()) {
    $message = "Tuloksesi on tallennettu!!";
  };
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
  <link rel="stylesheet" href="./style/admin.css">
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <div class="links">
      <a href="./logout.php">logout</a>
    </div>
  </Header>

  <Main>
    <div class="top">
      <h2>Kategoriat</h2>
      <button popovertarget="form">Luo uusi kategoria</button>

      <!-- a form to create a new category -->
      <form popover method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" id="form">
        <button popovertarget="form" popovertargetaction="hide">
          <i class="fas fa-x"></i>
        </button>
        <h2>Luoda uusi Kategoria</h2>
        <input type="text" name="category" placeholder="Antaa uusi kategoria">
        <input type="submit" name="create" value="Luoda">
        <?php if (!empty($message)): ?>
          <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
      </form>
    </div>

    <div class="categories">
      <?php foreach ($categories as $c): ?>
        <a href="questions.php?id=<?= htmlspecialchars($c["id"]) ?>">
          <?= htmlspecialchars($c["name"]) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </Main>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>