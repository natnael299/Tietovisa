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

$message = "kysymys on registeröidetty";
$message = "kysymys on registeröidetty";
$subjectName = get_info($conn, $subjectId)[0];
$teacher_id =  get_info($conn, $subjectId)[1];

//insert new question to the database
$new_q_message = "";
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
      $new_q_message = "kysymys on registeröidetty";
    };
  } else {
    $new_q_message = "Täyttä kaikki kohdat";
  }
  header("Location: questions.php?id=" . $_SESSION["page_id"]);
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
  $stmt->execute();
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
$total_result_row = get_count($conn, $sql, 1);
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
  <style>
    Main {
      padding-bottom: 60px;
      display: flex;
      justify-content: space-between;
      padding: 0 40px 70px 10px;
    }

    .right {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 60px;
    }

    table {
      margin: 10px 0;
      padding: 0;
      border-collapse: collapse;
    }

    table tr th,
    table tr td {
      border: 1px solid black;
      padding: 6px 9px;
      text-align: center;
    }

    .pages {
      margin: 15px 0 0 0;
      margin-top: 15px;
      display: flex;
      gap: 6px;
    }

    .pages a {
      text-decoration: none;
      border: 1px solid black;
      padding: 5px 10px;
      font-size: 0.8rem;
    }

    .pages a:hover,
    .addQ:hover {
      box-shadow: 0px 0px 2px blue;
    }

    dialog {
      margin: auto;
      padding: 1rem;
      border-radius: 10px;
    }

    #form {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      padding: 10px;
    }

    #form textarea#kysymys {
      width: 300px;
      height: 45px;
    }

    #form textarea {
      width: 300px;
      height: 37px;
    }

    #form button,
    .edit .closeEditF {
      position: absolute;
      top: 5px;
      right: 5px;
      font-size: 0.7rem;
      background-color: red;
      color: #fff;
      border: none;
      padding: 2px;
    }

    #form .textContainer {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    #form .inputContainer {
      display: flex;
      width: 100%;
      justify-content: start;
      align-items: center;
      gap: 15px;
    }

    #form input[type="text"] {
      width: 60px;
      height: 30px;
      padding-left: 3px;
    }

    #form input[type="submit"] {
      margin-top: 10px;
      width: 150px;
      background-color: black;
      color: #fff;
      padding: 6px;
    }

    .edit {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      padding: 10px;
    }

    .edit input#kysymys,
    .edit input#option_a,
    .edit input#option_b,
    .edit input#option_c,
    .edit input#option_d {
      width: 350px;
      padding: 10px 0 10px 10px;
    }

    .edit .inputContainer {
      width: 100%;
    }

    .inputContainer label {
      margin-right: 5px;
    }

    .edit input#answer {
      width: 50px;
      padding: 10px 0 10px 10px;
    }

    .edit input[type="submit"] {
      width: 150px;
      background-color: green;
      color: #fff;
      padding: 7px 0;
      border-radius: 3px;
      margin-top: 10px;
      border: none;
    }

    .deleteForm {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 25px 10px;
      gap: 30px;
      border-radius: 15px;
    }

    .deleteForm button {
      width: 120px;
      padding: 8px 0;
      border: none;
      border-radius: 3px;
    }

    .deleteForm .delete {
      background-color: red;
      color: #fff;
    }

    .deleteForm .closeDeleteF {
      background-color: green;
      color: #fff;
    }

    .subject {
      margin: 10px 0;
    }

    .top {
      display: flex;
      align-items: center;
      gap: 11rem;
      margin-top: 15px;
    }

    .top button {
      padding: 4px 10px;
    }

    .message {
      color: green;
    }

    .questions {
      font-size: 0.84rem;
      margin-top: 15px;
    }

    .question {
      display: flex;
      flex-direction: column;
      gap: 5px;
      margin-bottom: 12px;
    }

    .question .upper {
      display: flex;
      gap: 3px;
      align-items: center;
    }

    .upper button {
      background: transparent;
      font-size: 0.7rem;
      margin-right: 4px;
      border: none;
    }

    @media (max-width: 750px) {
      Main {
        display: flex;
        flex-direction: column;
        margin-left: 10px;
        gap: 30px;
      }

      .right {
        width: fit-content;
        align-items: center;
        margin-top: 0;
      }
    }
  </style>
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
              <textarea for="option_d" type="text" name="vastaus" required>
          </textarea>
            </div>

            <!-- The answer for the quesiton -->
            <div class="inputContainer">
              <label for="answer">Vastaus:</label>
              <input id="answer" type="text" name="answer" placeholder="esim: A" required>
            </div>
            <input type="submit" name="create" value="Lisää">
            <?php if (!empty($new_q_message)): ?>
              <p class="addMessage"><?= htmlspecialchars($new_q_message) ?></p>
            <?php endif; ?>
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
                  <form class="edit" method="post" action="#">

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
                    <?php if (!empty($message)): ?>
                      <p class="message"><?= htmlspecialchars($message) ?></p>
                    <?php endif; ?>
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
        <?php if ($totalLinks > 0):  ?>
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