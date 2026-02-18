<?php
session_start();
if ($_SERVER["HTTP_HOST"] == "localhost") {
  $host = "localhost";
  $user = "root";
  $password = "";
  $database = "tietovisa";
} else {
  $host = "localhost";
  $user = "25p_1735";
  $password = "jEk_BcvQ57/IAU)4";
  $database = "test";
}

$conn = new mysqli($host, $user, $password, $database);

//get user name by id
function get_name($conn, $id)
{
  $name = "";
  $stmt = $conn->prepare("SELECT username from users WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $r = $result->fetch_assoc();
  $name = $r["username"];
  return $name;
}

//get user role by id
function get_role($conn, $id)
{
  $name = "";
  $stmt = $conn->prepare("SELECT role from users WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $r = $result->fetch_assoc();
  $name = $r["role"];
  return $name;
}
