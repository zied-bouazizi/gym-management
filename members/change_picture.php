<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['change_picture'])) {
  $id = $_POST['id'];
  $file = $_FILES['picture'];

  uploadImage($conn, $file, $id);

  header('location: ../member.php?id=' . $id . '&&success=memberwasupdated');
}
