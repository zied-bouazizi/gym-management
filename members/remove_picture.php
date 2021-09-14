<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['remove_picture'])) {
  $id = $_POST['id'];
  $member = getMemberById($conn, $id);
  $extension = $member['extension'];

  unlink('../images/' . $id . '.' . $extension);

  deleteImage($conn, $id);

  header('location: ../member.php?id=' . $id . '&&success=memberwasupdated');
}
