<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['new'])) {
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $phone = $_POST['phone'];
  $createDate = $_POST['create_date'];
  $membershiExpiry = $_POST['membership_expiry'];
  $category = $_POST['category'];

  $id = createMember($conn, $firstName, $lastName, $phone, $createDate, $membershiExpiry, $category);

  if (isset($_FILES['picture'])) {
    $file = $_FILES['picture'];

    uploadImage($conn, $file, $id);
  }

  if ($category == 'Bodybuilding') {
    header('location: ../bodybuilding.php?success=memberwassaved');
    exit();
  } else if ($category == 'Kickboxing') {
    header('location: ../kickboxing.php?success=memberwassaved');
    exit();
  } else if ($category == 'Aerobic') {
    header('location: ../aerobic.php?success=memberwassaved');
    exit();
  } else if ($category == 'Gymnastic') {
    header('location: ../gymnastic.php?success=memberwassaved');
    exit();
  } else if ($category == 'Taekwondo A1') {
    header('location: ../taekwondo_a1.php?success=memberwassaved');
    exit();
  } else if ($category == 'Taekwondo A2') {
    header('location: ../taekwondo_a2.php?success=memberwassaved');
    exit();
  }
}
