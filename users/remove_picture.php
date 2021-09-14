<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['remove_picture'])) {
  $id = $_POST['id'];
  $user = getUser($conn, $id);
  $extension = $user['extension'];

  unlink('../images/user.' . $extension);

  deleteImage($conn, $id);

  header('location: ../profile.php?success=userwaschanged');
}
