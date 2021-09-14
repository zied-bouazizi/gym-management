<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['change_password'])) {
  $id = $_POST['id'];
  $currentPassword = $_POST['current_password'];
  $newPassword = $_POST['new_password'];
  $repeatPassword = $_POST['repeat_password'];

  changePassword($conn, $id, $currentPassword, $newPassword, $repeatPassword);

  header('location: ../profile.php?success=passwordwaschanged');
  exit();
}
