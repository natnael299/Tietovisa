<?php
require_once("./config.php");
//validate user
if (!isset($_SESSION["user_id"])) {
  header("Location: ../auth/login.php");
}

if (isset($_POST["play"])) {
  if (!empty($_POST["teacher"]) && !empty($_POST["subject"]) && !empty($_POST["length"])) {
    $_SESSION["teacher"] = $_POST["teacher"] ?? 0; //teachers id
    $_SESSION["subject"]  = $_POST["subject"] ?? 0; // categories id
    $_SESSION["length"] = $_POST["length"] ?? 0; // length
    header("Location: ./game.php");
    exit();
  }
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
  <link rel="stylesheet" href="./style/start.css">
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
      <a href="./index.php">Etusivu</a>
      <a href="./logout.php">Kirjausu ulos</a>
    </nav>
  </Header>

  <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <h2>Aloita Peli</h2>
    <!-- selects a teacher -->
    <select name="teacher" id="teacher">
      <option value="">--- Valitse opettaja ---</option>
      <?php
      $stmt = $conn->prepare("SELECT * FROM teachers");
      $stmt->execute();
      $result = $stmt->get_result();
      while ($r = $result->fetch_assoc()) {
        $id = $r['id'];
        $name = $r['username'];
        echo "<option value='$id'>$name</option>";
      }
      ?>
    </select>

    <!-- selects a subject -->
    <select name="subject" id="subject" disabled>
      <option value="">--- Valitse Aihealue ---</option>
    </select>

    <!-- selects a length -->
    <div class="adjustLength">
      <h3>Valitse kysymyksen määrä</h3>
      <div>
        <input type="radio" name="length" value="5">
        <p>Lyhyt (5)</p>
      </div>
      <div>
        <input type="radio" name="length" value="10">
        <p>KeskiPitkä (10)</p>
      </div>
      <div>
        <input type="radio" name="length" value="15">
        <p>Pitkä (15)</p>
      </div>
    </div>
    <input type="submit" name="play" value="Aloita Peli">
  </form>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>

  <script>
    const teacher = document.getElementById("teacher");
    const subject = document.getElementById("subject");
    teacher.addEventListener("change", () => {
      subject.disabled = true;
      //clears the previous option elements
      subject.innerHTML = "";
      const teacherId = teacher.value;
      if (teacherId != "") {
        fetch(`get_subject.php?id=${teacherId}`)
          .then((res) => {
            subject.disabled = false;
            return res.json();
          })
          .then((data) => {
            subject.innerHTML = `<option>--- Valitse aihealue ---</option>`;
            //populate the select grid for subject
            data.forEach((row) => {
              const optionEle = document.createElement("option");
              optionEle.textContent = row.name;
              optionEle.value = row.id;
              subject.appendChild(optionEle);
            })
          })
          .catch((err) => console.log(err))
      } else {
        subject.innerHTML = `<option>Valitse opettaja ensin</option>`;
      }
    })
  </script>
</body>

</html>