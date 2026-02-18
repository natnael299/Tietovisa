<?php
require_once("./config.php");

$subjectId = (int) ($_GET["id"] ?? 0);
$_SESSION["page_id"] = $subjectId; // keeps track of the subject id
//get info based on the subject id 
function get_info($conn, $id)
{
  $info = [];
  $stmt = $conn->prepare("SELECT name, teacher_id from categories WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $r = $result->fetch_assoc();
  $info[] = $r["name"];
  $info[] = $r["teacher_id"];
  return $info;
}

$subjectName = get_info($conn, $subjectId)[0];
$teacher_id =  get_info($conn, $subjectId)[1];

//insert new question to the database
if (isset($_POST["create"])) {
  if (!empty($_POST["kysymys"]) && !empty($_POST["option_a"]) && !empty($_POST["option_b"]) && !empty($_POST["option_c"]) && !empty($_POST["option_d"]) && !empty($_POST["answer"])) {
    $kysymys = $_POST["kysymys"];
    $option_a = $_POST["option_a"];
    $option_b = $_POST["option_b"];
    $option_c = $_POST["option_c"];
    $option_d = $_POST["option_d"];
    $answer = strtoupper($_POST["answer"]);

    $stmt = $conn->prepare("INSERT INTO questions (category_id, teacher_id, question, option_a, option_b, option_c, option_d, correct_option) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $subjectId, $teacher_id, $kysymys, $option_a, $option_b, $option_c, $option_d, $answer);
    if ($stmt->execute()) {
      header("Location: questions.php?id=" . $subjectId);
      exit;
    };
  }
}

//edit a question
if (isset($_POST["edit"])) {
  if (!empty($_POST["kysymys"]) && !empty($_POST["option_a"]) && !empty($_POST["option_b"]) && !empty($_POST["option_c"]) && !empty($_POST["option_d"]) && !empty($_POST["answer"])) {
    $questionId = (int) ($_POST["question_id"] ?? 0);
    $kysymys = $_POST["kysymys"];
    $option_a = $_POST["option_a"];
    $option_b = $_POST["option_b"];
    $option_c = $_POST["option_c"];
    $option_d = $_POST["option_d"];
    $answer = strtoupper($_POST["answer"]);
    $stmt = $conn->prepare("UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?");
    $stmt->bind_param("ssssssi", $kysymys, $option_a, $option_b, $option_c, $option_d, $answer, $questionId);
    if ($stmt->execute()) {
      header("Location: questions.php?id=" . $subjectId);
      exit;
    };
  }
}

//fetch questions by subject id
$stmt = $conn->prepare("SELECT * from questions WHERE category_id=?");
$stmt->bind_param("i", $subjectId);
$stmt->execute();
$result = $stmt->get_result();
$questions = [];
while ($r = $result->fetch_assoc()) {
  $questions[] = $r;
};

//delete question
if (isset($_POST["delete"])) {
  $id = $_POST["delete"];
  $stmt = $conn->prepare("DELETE from questions WHERE id=?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    header("Location: questions.php?id=" . $subjectId);
    exit;
  };
}

//fetch results based on the category
$results = [];
$limit = 5;
$pageNo = (int)($_GET["page"] ?? 1);
$offset = ($pageNo - 1) * $limit;
$fetch_results = $conn->prepare("SELECT * FROM result WHERE category_id=? ORDER BY percentage DESC  LIMIT ? OFFSET ?");
$fetch_results->bind_param("iii", $subjectId, $limit, $offset);
$fetch_results->execute();
$rows = $fetch_results->get_result();
while ($r = $rows->fetch_assoc()) {
  $results[] = $r;
};

//prepare links for results table
function get_count($conn, $sql, $num)
{
  $results = [];
  $stmt = $conn->prepare($sql);
  $id = $num;
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $rows = $stmt->get_result();
  while ($r = $rows->fetch_assoc()) {
    $results[] = $r;
  };
  return count($results);
}
$sql = "SELECT * FROM result WHERE category_id=?";
$total_result_row = get_count($conn, $sql, $subjectId);
$totalLinks = ceil($total_result_row / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./style/general.css">
  <link rel="stylesheet" href="./style/questions.css">
</head>

<body>
  <Header>
    <h2>Tietovisa</h2>
    <div class="links">
      <a href="./logout.php">logout</a>
    </div>
  </Header>

  <Main>
    <div class="left">
      <h3 class="subject"><?php echo $subjectName; ?></h3>
      <a class="returnLink" href="./admin.php">Takaisin</a>
      <div class="top">
        <h3>Kysymykset</h3>

        <!-- opens the form for adding a new question -->
        <button class="addQ_btn">
          Lisää uusi kysymys
        </button>

        <!-- add a new question -->
        <dialog class="addNewQ">
          <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?' . $_SERVER['QUERY_STRING'] ?>" id="form">
            <button type="button" class="closeQ">
              <i class="fas fa-x"></i>
            </button>
            <h3>Lisää uusi kysymys</h3>

            <!-- quesiton box -->
            <div class="textContainer">
              <label for="kysymys">Kysymys:</label>
              <textarea name="kysymys" id="kysymys" required></textarea>
            </div>

            <!-- option a of the quesiton -->
            <div class="textContainer">
              <label for="option_a">Valinta A:</label>
              <textarea id="option_a" name="option_a" required></textarea>
            </div>

            <!-- option b of the quesiton -->
            <div class="textContainer">
              <label for="option_b">Valinta B:</label>
              <textarea id="option_b" name="option_b" required></textarea>
            </div>

            <!-- option c of the quesiton -->
            <div class="textContainer">
              <label for="option_c">Valinta C:</label>
              <textarea id="option_c" name="option_c" required></textarea>
            </div>

            <!-- option d of the quesiton -->
            <div class="textContainer">
              <label for="option_d">Valinta D:</label>
              <textarea for="option_d" type="text" name="option_d" required>
          </textarea>
            </div>

            <!-- The answer for the quesiton -->
            <div class="inputContainer">
              <label for="answer">Vastaus:</label>
              <input id="answer" type="text" name="answer" placeholder="esim: A" required>
            </div>
            <input type="submit" name="create" value="Lisää">
          </form>
        </dialog>
      </div>

      <div class="questions">
        <?php foreach ($questions as $q): ?>
          <div class="question">
            <div class="upper">
              <p>
                <!-- button to edit a question -->
                <button class="openEditF" data-edit-id="<?= $q["id"]  ?>">
                  <i class="fas fa-pencil"></i>
                </button>

                <!-- edit dialog -->
                <dialog class="edit<?= $q["id"] ?>">
                  <form class="edit" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?' . $_SERVER['QUERY_STRING'] ?>">
                    <input type="hidden" name="question_id" value="<?= htmlspecialchars($q['id']) ?>">
                    <!-- button to close the popover -->
                    <button class="closeEditF" data-edit-id="<?= $q["id"] ?>">
                      <i class="fas fa-x"></i>
                    </button>
                    <h3>Muokaa kysymystä</h3>

                    <!-- quesiton box -->
                    <div class="textContainer">
                      <label for="kysymys">Kysymys:</label>
                      <input required type="text" name="kysymys" id="kysymys" value="<?= htmlspecialchars($q["question"]) ?>" />
                    </div>

                    <!-- option a of the quesiton -->
                    <div class="textContainer">
                      <label for="option_a">Valinta A:</label>
                      <input required type="text" id="option_a" name="option_a" value="<?= htmlspecialchars($q["option_a"]) ?>" />
                    </div>

                    <!-- option b of the quesiton -->
                    <div class="textContainer">
                      <label for="option_b">Valinta B:</label>
                      <input required type="text" id="option_b" name="option_b" value="<?= htmlspecialchars($q["option_b"]) ?>" />
                    </div>

                    <!-- option c of the quesiton -->
                    <div class="textContainer">
                      <label for="option_c">Valinta C:</label>
                      <input required type="text" id="option_c" name="option_c" value="<?= htmlspecialchars($q["option_c"]) ?>" />
                    </div>

                    <!-- option d of the quesiton -->
                    <div class="textContainer">
                      <label for="option_d">Valinta D:</label>
                      <input required type="text" id="option_d" name="option_d" value="<?= htmlspecialchars($q["option_d"]) ?>" />
                    </div>

                    <!-- The answer for the quesiton -->
                    <div class="inputContainer">
                      <label for="answer">Vastaus:</label>
                      <input required id="answer" type="text" name="answer" value="<?= htmlspecialchars($q["correct_option"]) ?>">
                    </div>

                    <input type="submit" name="edit" value="Muoka">
                  </form>
                </dialog>

                <!-- button to delete a question from the database -->
                <button class="openDeleteF" data-delete-id="<?= $q["id"] ?>">
                  <i class="fas fa-trash"></i>
                </button>

                <!-- Delete form -->
                <dialog class="delete<?= $q["id"] ?>">
                  <form class="deleteForm" action="#" method="post">
                    <p>
                      <strong>
                        Oletko varma, että haluat poista valitsemasi kysymystä?
                      </strong>
                    </p>
                    <div class="buttons">
                      <button name="delete" class="delete" type="submit" value="<?= htmlspecialchars($q['id']) ?>">
                        Poista Kysymys
                      </button>

                      <button class="closeDeleteF" data-delete-id="<?= $q["id"] ?>">
                        Peruta processi
                      </button>
                    </div>
                  </form>
                </dialog>

                <span>
                  <strong>
                    <?= htmlspecialchars($q["question"]) ?>
                  </strong>
                </span>
              </p>
            </div>
            <p class="options">
              <span>
                <?= htmlspecialchars($q["option_a"]) ?>
              </span>|
              <span>
                <?= htmlspecialchars($q["option_b"]) ?>
              </span>|
              <span>
                <?= htmlspecialchars($q["option_c"]) ?>
              </span>|
              <span>
                <?= htmlspecialchars($q["option_d"]) ?>
              </span>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <?php if (count($results) > 0):  ?>
      <div class="right">
        <h2>Tulokset</h2>
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Nimi</th>
              <th>Pisteet</th>
              <th>%</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i < count($results); $i++): ?>
              <tr>
                <td><?= $i + 1 + $offset ?></td>
                <td><?= htmlspecialchars($results[$i]["username"]) ?></td>
                <td>
                  <?= htmlspecialchars($results[$i]["point"]) . '/' .
                    htmlspecialchars($results[$i]["length"]) ?>
                </td>
                <td>
                  <?= htmlspecialchars($results[$i]["percentage"]) . '%' ?>
                </td>
              </tr>
            <?php endfor; ?>
          </tbody>
        </table>
        <?php if ($totalLinks > 1):  ?>
          <div class="pages">
            <?php for ($i = 1; $i <= $totalLinks; $i++):  ?>
              <a class="link" href="questions.php?id=<?= $subjectId ?>&page=<?= $i ?>">
                <?= $i  ?>
              </a>
            <?php endfor;  ?>
          </div>
        <?php endif;  ?>
      </div>
    <?php else:  ?>
      <p>
        <strong>Ei tuloksia vielä!!</strong>
      </p>
    <?php endif;  ?>
  </Main>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>

  <script>
    const addQDialog = document.querySelector(".addNewQ");
    const openQuestionF = document.querySelector(".addQ_btn");
    const closeQuestionF = document.querySelector(".closeQ");

    //opens the dialog element for adding new question
    openQuestionF.addEventListener("click", () => {
      addQDialog.showModal();
    })

    //closes the dialog element for adding new question
    closeQuestionF.addEventListener("click", () => {
      addQDialog.close();
    })

    //open the edit dialog form
    const openEditForms = document.querySelectorAll(".openEditF");
    openEditForms.forEach((form) => {
      form.addEventListener("click", () => {
        const id = form.dataset.editId;
        const editDialog = document.querySelector(`.edit${id}`);
        editDialog.showModal();
      });
    });

    //closes the edit dialog form
    const closeEditForms = document.querySelectorAll(".closeEditF");
    closeEditForms.forEach((form) => {
      form.addEventListener("click", () => {
        const id = form.dataset.editId;
        const editDialog = document.querySelector(`.edit${id}`);
        editDialog.close();
      });
    });

    //opens the delete dialog form
    const openDeleteForms = document.querySelectorAll(".openDeleteF");
    openDeleteForms.forEach((form) => {
      form.addEventListener("click", () => {
        const id = form.dataset.deleteId;
        const editDialog = document.querySelector(`.delete${id}`);
        editDialog.showModal();
      });
    });

    //closes the delete dialog form
    const closeDeleteForms = document.querySelectorAll(".closeDeleteF");
    closeDeleteForms.forEach((form) => {
      form.addEventListener("click", () => {
        const id = form.dataset.deleteId;
        const editDialog = document.querySelector(`.delete${id}`);
        editDialog.close();
      });
    });
  </script>
</body>

</html>