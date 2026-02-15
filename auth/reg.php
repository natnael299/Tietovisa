<?php
require_once("../config.php");
$error = "";

$detail_page_id = isset($_GET["id"]) ? (int) $_GET["id"] : (isset($_POST["detail_page_id"]) ? (int) $_POST["detail_page_id"] : "");
try {
  if (isset($_POST["submit"])) {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $address = isset($_POST["address"]) ? $_POST["address"] : "";
    $num = isset($_POST["num"]) ? $_POST["num"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $password2 = isset($_POST["password2"]) ? $_POST["password2"] : "";
    $role = "user";
    if (isset($_POST["agree"]) && !empty($username) && !empty($email) && !empty($address) && !empty($num) && !empty($password) && !empty($password2)) {
      if ($password !== $password2) {
        throw new Exception("Salasanat eivät täsmää");
      }
      $hashed_p = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone_number, address, role) VALUES(?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $username, $email, $hashed_p, $num, $address, $role);
      if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id;
        if (!empty($detail_page_id)) {
          header("Location: ../plans_detail.php?id=" . $detail_page_id);
          exit();
        } else {
          header("Location: ../plans.php");
          exit();
        }
      };
    } else {
      $error = "Täytät lomake kokonaan";
    }
  }
} catch (mysqli_sql_exception $e) {
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
  <link rel="stylesheet" href="../style/reg.css">
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
    <div class="links">
      <a href="../index.php">Etusivu</a>
    </div>
  </Header>

  <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <div class="bodylinks">
      <a href="reg.php">Registeröidä</a>
      <a href="login.php">Kirjaudu</a>
    </div>
    <!-- Hidden input to store the page_id used for redirecting -->
    <?php if (!empty($detail_page_id)): ?>
      <input type="hidden" name="detail_page_id" value="<?= htmlspecialchars($detail_page_id) ?>">
    <?php endif; ?>
    <input type="text" name="username" placeholder="username">
    <input type="text" name="email" placeholder="email">
    <input type="text" name="address" placeholder="address">
    <input type="text" name="num" placeholder="phone number">
    <input type="password" name="password" placeholder="password">
    <input type="password" name="password2" placeholder="conform password">
    <div class="agreementGrid">
      <input type="checkbox" name="agree" value="yes">
      <p class="clause">
        Hyväksyn, että antamani tiedot tallenetaan järjestelmän ja että tietojani käytetään peliin.
      </p>
    </div>
    <input type="submit" name="submit" value="Registeröidä">
    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </form>
  <Footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </Footer>

</body>

</html>