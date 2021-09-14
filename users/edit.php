<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $username = $_POST['username'];
  $email = $_POST['email'];

  updateUser($conn, $id, $firstName, $lastName, $username, $email);

  header('location: ../profile.php?success=userwaschanged');
  exit();
}
