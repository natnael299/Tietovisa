<?php
require_once("./config.php");

$subjectId = (int) ($_GET["id"] ?? 0);
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
      $message = "kysymys on registeröidetty";
    };
  } else {
    $message = "Täyttä kaikki kohdat";
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
  $stmt->execute();
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
  <style>
    Main {
      padding-bottom: 60px;
    }

    #form:popover-open {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      position: absolute;
      margin: auto;
      padding: 10px 20px;
      border-radius: 5px;
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
    #edit button {
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

    #edit {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 10px 17px;
      gap: 10px;
      position: absolute;
      margin: auto;
      border-radius: 15px;
    }

    #edit input#kysymys,
    #edit input#option_a,
    #edit input#option_b,
    #edit input#option_c,
    #edit input#option_d {
      width: 300px;
      padding: 10px 0 10px 10px;
    }

    #edit .inputContainer {
      width: 100%;
    }

    .inputContainer label {
      margin-right: 5px;
    }

    #edit input#answer {
      width: 50px;
      padding: 10px 0 10px 10px;
    }

    #edit input[type="submit"] {
      width: 150px;
      background-color: green;
      color: #fff;
      padding: 7px 0;
      border-radius: 3px;
      margin-top: 10px;
      border: none;
    }

    #deleteForm:popover-open {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 25px 10px;
      gap: 30px;
      position: absolute;
      margin: auto;
      border-radius: 15px;
    }

    #deleteForm button {
      width: 120px;
      padding: 8px 0;
      border: none;
      border-radius: 3px;
    }

    #deleteForm .delete {
      background-color: red;
      color: #fff;
    }

    #deleteForm .cancel {
      background-color: green;
      color: #fff;
    }

    .left {
      margin-left: 10px;
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
        <button popovertarget="form">
          Lisää uusi kysymys
        </button>

        <!-- add a new question -->
        <form popover method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" id="form">
          <button type="button" popovertarget="form" popovertargetaction="hide">
            <i class="fas fa-x"></i>
          </button>
          <h3>Lisää uusi kysymys</h3>

          <!-- quesiton box -->
          <div class="textContainer">
            <label for="kysymys">Kysymys:</label>
            <textarea name="kysymys" id="kysymys"></textarea>
          </div>

          <!-- option a of the quesiton -->
          <div class="textContainer">
            <label for="option_a">Valinta A:</label>
            <textarea id="option_a" name="option_a"></textarea>
          </div>

          <!-- option b of the quesiton -->
          <div class="textContainer">
            <label for="option_b">Valinta B:</label>
            <textarea id="option_b" name="option_b"></textarea>
          </div>

          <!-- option c of the quesiton -->
          <div class="textContainer">
            <label for="option_c">Valinta C:</label>
            <textarea id="option_c" name="option_c"></textarea>
          </div>

          <!-- option d of the quesiton -->
          <div class="textContainer">
            <label for="option_d">Valinta D:</label>
            <textarea for="option_d" type="text" name="vastaus">
          </textarea>
          </div>

          <!-- The answer for the quesiton -->
          <div class="inputContainer">
            <label for="answer">Vastaus:</label>
            <input id="answer" type="text" name="answer" placeholder="esim: A">
          </div>
          <input type="submit" name="create" value="Lisää">
          <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
          <?php endif; ?>
        </form>
      </div>

      <div class="questions">
        <?php foreach ($questions as $q): ?>
          <div class="question">
            <div class="upper">
              <p>
                <button popovertarget="edit">
                  <i class="fas fa-pencil"></i>
                </button>

                <!-- edit form -->
              <form popover method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" id="edit">
                <button type="button" popovertarget="edit" popovertargetaction="hide">
                  <i class="fas fa-x"></i>
                </button>
                <h3>Muokaa kysymystä</h3>

                <!-- quesiton box -->
                <div class="textContainer">
                  <label for="kysymys">Kysymys:</label>
                  <input type="text" name="kysymys" id="kysymys" value="<?= htmlspecialchars($q["question"]) ?>" />
                </div>

                <!-- option a of the quesiton -->
                <div class="textContainer">
                  <label for="option_a">Valinta A:</label>
                  <input type="text" id="option_a" name="option_a" value="<?= htmlspecialchars($q["option_a"]) ?>" />
                </div>

                <!-- option b of the quesiton -->
                <div class="textContainer">
                  <label for="option_b">Valinta B:</label>
                  <input type="text" id="option_b" name="option_b" value="<?= htmlspecialchars($q["option_b"]) ?>" />
                </div>

                <!-- option c of the quesiton -->
                <div class="textContainer">
                  <label for="option_c">Valinta C:</label>
                  <input type="text" id="option_c" name="option_c" value="<?= htmlspecialchars($q["option_c"]) ?>" />
                </div>

                <!-- option d of the quesiton -->
                <div class="textContainer">
                  <label for="option_d">Valinta D:</label>
                  <input type="text" id="option_d" name="option_d" value="<?= htmlspecialchars($q["option_d"]) ?>" />
                </div>

                <!-- The answer for the quesiton -->
                <div class="inputContainer">
                  <label for="answer">Vastaus:</label>
                  <input id="answer" type="text" name="answer" value="<?= htmlspecialchars($q["correct_option"]) ?>">
                </div>

                <input type="submit" name="edit" value="Muoka">
                <?php if (!empty($message)): ?>
                  <p class="message"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>
              </form>

              <button popovertarget='deleteForm'>
                <i class="fas fa-trash"></i>
              </button>
              <!-- Delete form -->
              <form action="#" method="post" id='deleteForm' popover>
                <p>
                  <strong>
                    Oletko varma, että haluat poista valitsemasi kysymystä?
                  </strong>
                </p>
                <div class="buttons">
                  <button name="delete" class="delete" type="submit" value="<?= htmlspecialchars($q['id']) ?>">
                    Poista Kysymys
                  </button>

                  <button type="button" class="cancel" popovertargetaction="hide" popovertarget="deleteForm">
                    Peruta processi
                  </button>
                </div>
              </form>

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
    <div class="right">

    </div>
  </Main>

  <footer>
    <p><strong>Tekijä: </strong> Natnael Beyene</p>
    <p><strong><a href="https://github.com/natnael299">Github</a></strong> </p>
  </footer>
</body>

</html>