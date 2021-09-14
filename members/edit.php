<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $phone = $_POST['phone'];
  $createDate = $_POST['create_date'];
  $page = $_POST['page'];
  $category = $_POST['category'];

  updateMember($conn, $id, $firstName, $lastName, $phone, $createDate);

  if ($page > 1 && $category == 'Bodybuilding') {
    header('location: ../bodybuilding.php?success=memberwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Kickboxing') {
    header('location: ../kickboxing.php?success=memberwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Aerobic') {
    header('location: ../aerobic.php?success=memberwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Gymnastic') {
    header('location: ../gymnastic.php?success=memberwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Taekwondo A1') {
    header('location: ../taekwondo_a1.php?success=memberwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Taekwondo A2') {
    header('location: ../taekwondo_a2.php?success=memberwasupdated&&page=' . $page);
    exit();
  } else if ($category == 'Bodybuilding') {
    header('location: ../bodybuilding.php?success=memberwasupdated');
    exit();
  } else if ($category == 'Kickboxing') {
    header('location: ../kickboxing.php?success=memberwasupdated');
    exit();
  } else if ($category == 'Aerobic') {
    header('location: ../aerobic.php?success=memberwasupdated');
    exit();
  } else if ($category == 'Gymnastic') {
    header('location: ../gymnastic.php?success=memberwasupdated');
    exit();
  } else if ($category == 'Taekwondo A1') {
    header('location: ../taekwondo_a1.php?success=memberwasupdated');
    exit();
  } else if ($category == 'Taekwondo A2') {
    header('location: ../taekwondo_a2.php?success=memberwasupdated');
    exit();
  }
} else if (isset($_POST['edit_member'])) {
  $id = $_POST['id'];
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $phone = $_POST['phone'];
  $createDate = $_POST['create_date'];

  updateMember($conn, $id, $firstName, $lastName, $phone, $createDate);

  header('location: ../member.php?id=' . $id . '&&success=memberwasupdated');
} else if (isset($_POST['upload_photo'])) {
  $id = $_POST['id'];
  $file = $_FILES['picture'];

  uploadImage($conn, $file, $id);

  header('location: ../member.php?id=' . $id . '&&success=memberwasupdated');
}
