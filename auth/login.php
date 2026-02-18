<?php
require_once("../config.php");
$error = "";
try {
  if (isset($_POST["submit"])) {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (!empty($email) && !empty($password)) {
      $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
          if (password_verify($password, $r["password"])) {
            $_SESSION["user_id"] = $r["id"];
            if ($r["role"] == "user") {
              header("Location: ../start.php?id=");
              exit();
            } else {
              header("Location: ../admin.php");
              exit();
            }
          } else {
            $error = "Virheellinen salasana!!";
          }
        }
      } else {
        $error = "Käyttäjä ei löydy";
      }
    }
  };
} catch (mysqli_sql_exception  $e) {
  $error = "joku virhe on tapahtunut";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../style/general.css">
  <link rel="stylesheet" href="../style/login.css">
  <style>
    .bodylinks {
      width: 100%;
      display: flex;
      justify-content: space-between;
      padding: 0 5px;
    }

    .bodylinks a {
      text-decoration: none;
      color: blue;
    }

    .bodylinks a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <a href="../index.php">Etusivu</a>
  </Header>

  <!-- login form -->
  <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <div class="bodylinks">
      <a href="reg.php">Registeröidä</a>
      <a href="login.php">Kirjaudu</a>
    </div>
    <input type="text" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="submit" value="Kirjaudu">
    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </form>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>

</body>

</html>