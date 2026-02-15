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
