<?php
require_once("./config.php");
$id = (int)($_GET["id"] ?? 0);
$stmt = $conn->prepare("SELECT * FROM categories WHERE teacher_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categories = [];
while ($r = $result->fetch_assoc()) {
  $categories[] = $r;
}

echo json_encode($categories);
